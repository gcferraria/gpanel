<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends JSON_Controller {

    /**
     * index: Get Notifications.
     *
     * @access public
     * @return json
    **/
    public function index( $data = array() ) {
        $notifications = new Notification();
        $columns = array( 'id', 'name','source','subject','creation_date','status');

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
                $file   = explode( '/', $notification->attach);
                $attach = '<a href="' . $this->config->item('download_url') . end( $file ) . '" title="'.$this->lang->line('download').'" target="_blank" class="btn default btn-xs black"><i class="fa fa fa-file-pdf-o"></i></a> '; 
            }

            $data[] = array(
                "DT_RowId" => $notification->id,
                0 => '<input type="checkbox" class="checkboxes" id="'.$notification->id.'" data-jsb-class="CheckBox" />',
                1 => '<a href="mailto:'.strtolower($notification->email).'">'.word_limiter( $notification->name, 10 ).'</a>',
                2 => $notification->source,
                3 => word_limiter( $notification->subject, 10 ),
                4 => $notification->creation_date,
                5 => ( $notification->status == 1 )
                        ? '<span class="label label-sm label-success">' . $this->lang->line('read')   . '</span>'
                        : '<span class="label label-sm label-warning">' . $this->lang->line('pendent'). '</span>',
                6 => $attach . '<a href="' . site_url('notifications/open/'. $notification->id) . '" class="btn btn-xs blue-madison"><i class="fa fa-search"></i> ' . $this->lang->line('open') . '</a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="' . $this->lang->line('delete_record') . '" data-url="'.base_url('notifications/delete/' . $notification->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> ' . $this->lang->line('delete') . '</a>',
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
            If the Notification has been deleted successfully, updates the list,
            otherwise shows an unexpected error.
        */
        if ( $notification->delete() ) {
            return parent::index(
                array(
                    'result'  => 1,
                    'message' => $this->lang->line('delete_success_message')
                )
            );
        }
        else {
            return parent::index(
                array(
                    'result'  => 0,
                    'message' => $this->lang->line('delete_error_message'),
                )
            );
        }
    }

    /**
     * read: Mark a notification as read
     *
     * @access public
     * @return json 
     */
    public function read() {

        $rows = $this->input->post('rows');
        if ( isset($rows) && !empty($rows)) {

            $ids = array();
            foreach ($rows as $row) {
                foreach ($row as $key => $value) {
                    $ids[] = $value;
                }
            }

            // Find Notification to be Mark as Read.
            $notifications = new Notification();
            $notifications->where_in( 'id', $ids )->get();

            /* Save all Notifications */
            $result = TRUE;
            foreach ($notifications as $notification) {
                $notification->status = 1;
                if ( !$notification->save() ) {
                    $result = FALSE;
                }
            }

            /*
                If the Notification(s) has been marked as read with successfully, updates the list,
                otherwise shows an unexpected error.
            */
            if ( $result ) {
                return parent::index(
                    array(
                        'root.$notification.$value.update'  => $notifications->get_unread_messages_number(),
                        'root.$notifications.$reload.click' => 1,
                        'notification'                      => array('success', $this->lang->line('read_success_message') ),
                    )
                );

                $notifications->refresh_all();
            }
            else {
                return parent::index(
                    array(
                        'notification' => array('error', $this->lang->line('unespected_error') ),
                    )
                );
            }
        }
        else {
            return parent::index(
                array(
                    'notification' => array('error', $this->lang->line('please_select_record') ),
                )
            );
        }
    }

}