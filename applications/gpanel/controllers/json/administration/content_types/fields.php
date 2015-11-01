<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fields extends JSON_Controller {

    /**
     * index: Get Content Type Fields.
     *
     * @access public
     * @param  int $id, Content Type Id.
     * @return json
    **/
    public function index( $id ) {

        // Inicialize Content Type Object.
        $content_type = new Content_Type;

        // Define base columns
        $columns = array('name','label','type','active_flag');

        // Get Content Type.
        $content_type->get_by_id( $id );

        // Get All Fields for this Content Type.
        $fields = $content_type->content_type_fields;

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $fields->or_like( array(
                    'name'  => $search_text,
                    'label' => $search_text
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $fields->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $fields->order_by('position');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $fields->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $fields as $field ) {
            $data[] = array(
                "DT_RowId" => $field->id,
                0 => $field->name,
                1 => $field->label,
                2 => $field->type,
                3 => ( $field->active_flag == 1 )
                        ? '<span class="label label-sm label-success">' . $this->lang->line('active')   . '</span>'
                        : '<span class="label label-sm label-danger">'  . $this->lang->line('inactive') . '</span>',
                4 => '<a href="'.site_url('/administration/content_types/fields/edit/'. $field->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> ' . $this->lang->line('edit') .'</a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="' . $this->lang->line('delete_record') . '" data-url="'.base_url('/administration/content_types/fields/delete/' . $field->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> ' . $this->lang->line('delete') .'</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $fields->paged->total_rows,
                "iTotalDisplayRecords" => $fields->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * add: Validate and Insert Content Type Field.
     *
     * @access public
     * @param  int $id, Content Type Id
     * @return json
    **/
    public function add( $id ) {

        // Inicialize Content Type and Content Type Field Object.
        $content_type       = new Content_Type;
        $content_type_field = new Content_Type_Field;

        // Get Content Type to Associate.
        $content_type->get_by_id( $id );

        // Set Content Type Field attributes.
        $content_type_field->content_type_id = $content_type->id;
        $content_type_field->name            = $this->input->post('name');
        $content_type_field->label           = $this->input->post('label');
        $content_type_field->type            = $this->input->post('type');
        $content_type_field->required        = $this->input->post('required');
        $content_type_field->args            = $this->input->post('args');
        $content_type_field->help            = $this->input->post('help');
        $content_type_field->position        = $this->input->post('position');
        $content_type_field->active_flag     = $this->input->post('active_flag');
        $content_type_field->translatable    = $this->input->post('translatable');

        // If the Content Type Field is valid insert the data.
        if ( $content_type_field->save( $content_type ) ) {

            $data = array(
                'reset'        => 1,
                'notification' => array( 'success', $this->lang->line('save_success_message') )
            );
        }
        else {

            $data = array(
                'show_errors'  => $content_type_field->errors->all,
                'notification' => array( 'error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * edit: Validate and Update Content Type Field.
     *
     * @access public
     * @param  int $id, Content Type Field id.
     * @return json
    **/
    public function edit( $id ) {

        // Inicialize Content Type Field Object.
        $content_type_field = new Content_Type_Field;

        // Find Content Type Field to Edit.
        $content_type_field->get_by_id( $id );

        // Set Content Type Field attributes.
        $content_type_field->name          = $this->input->post('name');
        $content_type_field->label         = $this->input->post('label');
        $content_type_field->type          = $this->input->post('type');
        $content_type_field->required      = $this->input->post('required');
        $content_type_field->args          = $this->input->post('args');
        $content_type_field->help          = $this->input->post('help');
        $content_type_field->position      = $this->input->post('position');
        $content_type_field->active_flag   = $this->input->post('active_flag');
        $content_type_field->translatable  = $this->input->post('translatable');

        // If the Content Type Field is valid insert the data.
        if ( $content_type_field->save() ) {

            $data = array(
                'show_errors'  => array(),
                'notification' => array( 'success', $this->lang->line('save_success_message') )
            );
        }
        else {

            $data = array(
                'show_errors' => $content_type_field->errors->all,
                'notification' => array( 'error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * delete: Delete Content Type Field.
     *
     * @access public
     * @param  int $id, Content Type Field id
     * @return json
    **/
    public function delete( $id ) {

        // Inicialize Content Type Field Object.
        $content_type_field = new Content_Type_Field;

        // Find Content Type Field to Delete.
        $content_type_field->get_by_id( $id );

        /*
          If Content Type Field has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if ( $content_type_field->delete() ) {
            return parent::index(
                array(
                    'result'  => 1,
                    'message' => $this->lang->line('delete_success_message'),
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
}

/* End of file fields.php */
/* Location: ./applications/gpanel/controllers/json/administration/content_types/fields.php */
