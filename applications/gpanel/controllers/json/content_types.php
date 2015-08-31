<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_Types extends JSON_Controller {

    /**
     * __construct: Ajax Content Types Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct( 'restrict' );
    }

    /**
     * index: Get Content Types.
     *
     * @access public
     * @return json
    **/
    public function index() {
        $content_types = new Content_Type;
        $columns = array( 'name','uriname','creation_date','status');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $content_types->or_like( array(
                    'name'    => $search_text,
                    'uriname' => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $content_types->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $content_types->order_by('name');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $content_types->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $content_types as $content_type ) {
            $data[] = array(
                "DT_RowId" => $content_type->id,
                0 => $content_type->name,
                1 => $content_type->uriname,
                2 => $content_type->creation_date,
                3 => ( $content_type->active_flag == 1 )
                        ? '<span class="label label-success">Activo</span>'
                        : '<span class="label label-danger">Inactivo</span>',
                4 => '<a href="'.site_url('content_types/fields/index/'. $content_type->id).'" class="btn btn-xs btn blue-madison"><i class="fa fa-cogs"></i> Campos</a>
                      <a href="'.site_url('content_types/edit/'. $content_type->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> Editar</a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="Tem a certeza que pretende apagar o registo?" data-url="'.base_url('content_types/delete/' . $content_type->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> Apagar</a>',
                );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $content_types->paged->total_rows,
                "iTotalDisplayRecords" => $content_types->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * add: Validate and Insert Content Type.
     *
     * @access public
     * @return json
    **/
    public function add() {

        // Inicialize Content Type Object.
        $content_type = new Content_Type;

        // Set Content Type attributes.
        $content_type->name        = $this->input->post('name');
        $content_type->uriname     = $this->input->post('uriname');
        $content_type->active_flag = $this->input->post('active_flag');

        // If the Content Type is valid insert the data.
        if( $content_type->save() ) {

            $data = array(
                'reset'        => 1,
                'notification' => array( 'success',$this->lang->line('content_type_insert_success_message') ),
            );
        }
        else {

            $data = array(
                'show_errors'  => $content_type->errors->all,
                'notification' => array( 'error', $this->lang->line('content_type_insert_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * edit: Validate and Update Content Type.
     *
     * @access public
     * @param  int $id, Content Type Id.
     * @return json
    **/
    public function edit( $id ) {

        // Inicialize Content Type Object.
        $content_type = new Content_Type;

        // Find Content Type to Edit.
        $content_type->get_by_id( $id );

        // Set Content Type attributes.
        $content_type->name        = $this->input->post('name');
        $content_type->uriname     = $this->input->post('uriname');
        $content_type->active_flag = $this->input->post('active_flag');

        // If the Content Type is valid insert the data.
        if( $content_type->save() ) {
            $data = array(
                'show_errors'  => array(),
                'notification' => array( 'success', $this->lang->line('content_type_update_success_message') ),
            );
        }
        else {
            $data = array(
                'show_errors'  => $content_type->errors->all,
                'notification' => array( 'error', $this->lang->line('content_type_update_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * delete: Delete Content Type.
     *
     * @access public
     * @param  int $id, Content Type Id
     * @return json
    **/
    public function delete( $id ) {

        // Inicialize Content Type Object.
        $content_type = new Content_Type;

        // Find Content Type to Delete.
        $content_type->get_by_id( $id );

        /*
          If Content Type has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if ( $content_type->delete() ) {
            return parent::index(
                array(
                    'result'  => 1,
                    'message' => 'O Tipo de conteúdo foi apagado com sucesso.',
                )
            );
        }
        else {
            return parent::index(
                array(
                    'result'  => 0,
                    'message' => $this->lang->line('content_type_delete_error_message'),
                )
            );
        }
    }

}

/* End of file content_types.php */
/* Location: ./applications/gpanel/controllers/json/content_types.php */
