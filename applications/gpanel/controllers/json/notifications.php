<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends JSON_Controller {

    /**
     * __construct: Ajax Notifications Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct( 'restrict' );
    }

    /**
     * index: Get Notifications.
     *
     * @access public
     * @return json
    **/
    public function index() {
        $notifications = new Notification();
        $columns = array( 'name','source','subject','creation_date','status');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $notifications->or_like( array(
                    'name'    => $search_text,
                    'email'   => $search_text,
                    'subject' => $search_text,
                    'body'    => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $notifications->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else {
            $notifications->order_by('status');
            $notifications->order_by('creation_date', 'desc');
        }

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $notifications->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $notifications as $notification ) {
            $attach = '';
            if ( $notification->attach ) {
                $attach = '<a href="' . $this->config->item('static_url') . 'docs/'. $notification->attach . '" target="_blank" class="btn default btn-xs black"><i class="fa fa fa-file-pdf-o"></i></a> '; 
            }

            $data[] = array(
                "DT_RowId" => $notification->id,
                0 => '<a href="mailto:'.strtolower($notification->email).'">'.word_limiter( $notification->name, 10 ).'</a>',
                1 => $notification->source,
                2 => word_limiter( $notification->subject, 10 ),
                3 => $notification->creation_date,
                4 => ( $notification->status == 1 )
                        ? '<span class="label label-success">Lido</span>'
                        : '<span class="label label-warning">Pendente</span>',
                5 => $attach . '<a href="'.site_url('notifications/open/'. $notification->id).'" class="btn btn-xs blue-madison"><i class="fa fa-search"></i> Abrir</a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="Tem a certeza que pretende apagar o registo?" data-url="'.base_url('notifications/delete/' . $notification->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> Apagar</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $notifications->paged->total_rows,
                "iTotalDisplayRecords" => $notifications->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * delete: Delete Notification.
     *
     * @access public
     * @param  int $id, Notification Id
     * @return json
    **/
    public function delete( $id ) {
        $notification = new Notification();

        // Find Notification to be Deleted.
        $notification->get_by_id( $id );

        /*
          If Notification has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if ( $notification->delete() ) {
            return parent::index(
                array(
                    'result'  => 1,
                    'message' => 'A notificação foi apagada com sucesso.',
                )
            );
        }
        else {
            return parent::index(
                array(
                    'result'  => 0,
                    'message' => 'Não foi possível apagar a notificação. Contacte o Administrador do Sistema.',
                )
            );
        }
    }

}

/* End of file notifications.php */
/* Location: ./applications/gpanel/controllers/json/notifications.php */
