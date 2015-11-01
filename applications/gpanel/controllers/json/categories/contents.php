<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contents extends JSON_Controller {

    /**
     * index: Get Contents.
     *
     * @access public
     * @param  int $id, [Required] Category Identifier.
     * @return json
    **/
    public function index( $id ) {

        // Get Category to list contents.
        $category = new Category;
        $category->get_by_id( $id );

        // Get All Contents for this Category.
        $contents = $category->contents;
        $columns = array( 'name','content_type','publish_date','weight','publish_flag','id');

        // Get languages available for this category.
        $languages = $category->languages();

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $contents->or_like( array(
                    'name' => $search_text,
                )
            );
        }

         // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $contents->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else {
            // Order Content by Publish date and weight.
            $contents->order_by( 'publish_date DESC' );
            $contents->order_by( 'weight ASC');
        }

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $contents->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $contents as $content ) {

            switch( $content->status() ) {
                case -1:
                    $status = '<span class="label label-sm label-danger">'.$this->lang->line('inactive').'</span>';
                    break;
                case 0:
                    $status = '<span class="label label-sm label-warning">'.$this->lang->line('hold').'</span>';
                    break;
                case 1:
                    $status = '<span class="label label-sm label-success">'.$this->lang->line('active').'</span>';
                    break;
            }

            $row = array(
                "DT_RowId" => $content->id,
                0 => character_limiter($content->name,50),
                1 => $content->content_type->get()->name,
                2 => $content->publish_date,
                3 => $content->weight,
                4 => $status,
                5 => '<a href="'.site_url('categories/contents/edit/' . $id . '/' . $content->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> ' . $this->lang->line('edit') . ' </a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="'. $this->lang->line('delete_record') .'" data-url="'.base_url('categories/contents/delete/' . $content->id . ".json?category_id=$id" ).'" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> '.$this->lang->line('delete').'</a>',
            );

            // Show icons for add/edit translations for this content.
            if ( count( $languages ) > 1 ) {
                $operations = $row['5'];

                $icons = '';
                foreach( $languages as $language ) {
                    if( !$language->is_default() ) {
                        $translations = $content->translations->where( 'language_id', $language->id );

                        $icons .= ( $translations->count() > 1 )
                            ?  '<a href="' . site_url('categories/contents/translations/save/' . $category->id . '/' . $content->id . '/' . $language->id) . '" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i></a>'
                            :  '<a href="' . site_url('categories/contents/translations/save/' . $category->id . '/' . $content->id . '/' . $language->id) . '" class="btn btn-xs yellow-crusta"><i class="fa fa-warning"></i></a>';
                    }
                }

                $row['5'] = $icons;
                $row['6'] = $operations;
            }

            $data[] = $row;
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $contents->paged->total_rows,
                "iTotalDisplayRecords" => $contents->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * content_type: Set content type chosed on session and redirect
     *               to content form.
     *
     * @access public
     * @param  int $id, [Required] Category Identifier.
     * @return json
    **/
    public function content_type( $id ) {

        // Get Content Type Chosed.
        $content_type_id = $this->input->post('content_type_id');

        // Set Content Type on Flash Data Session.
        $this->session->set_flashdata( 'content_type', $content_type_id );

        parent::index(
            array(
                'notification' => array('success', $this->lang->line('content_content_type_success_message') ),
                'redirect'     => array(
                    'url'      => site_url( "categories/contents/add/$id" ),
                    'duration' => 1000,
                ),
            )
        );
    }

    /**
     * add: Validate and Insert Content.
     *
     * @access public
     * @param  int $id, [Required] Category Identifier.
     * @return json
    **/
    public function add( $id ) {

        // Inicialize Content Type and Content Object.
        $content_type = new Content_Type();
        $content      = new Content();

        // Get Content Type.
        $content_type->get_by_id( $this->input->post('content_type_id') );

        // Set Content attributes.
        $content->name            = $this->input->post('name');
        $content->publish_date    = $this->input->post('publish_date');
        $content->disable_date    = $this->input->post('disable_date');
        $content->weight          = $this->input->post('weight');
        $content->publish_flag    = $this->input->post('publish_flag');
        $content->creator_id      = $this->administrator->id;
        $content->keywords        = $this->input->post('keywords');

        // Get Content Type Fields, add validation rules and save your values.
        $fields = $content_type->fields();

        $values = array();
        $rules  = 0;
        foreach ( $fields as $field ) {
            $values[ $field['field'] ] = $this->input->post( $field['field'] );

            foreach ( $field['rules'] as $rule ) {
                $rules++;

                // Add validation rule for field.
                $this->form_validation->set_rules(
                    $field['field'],
                    $field['label'],
                    $rule
                );
            }
        }

        // Validate the Content and your fields.
        $content->validate();

        // Validate the Content Fields.
        $valid = ( $rules > 0 ) ? $this->form_validation->run() : TRUE;

        // If the Content is valid insert the data.
        if ( $valid && $content->valid ) {

            // Get Categories to associate at this Content.
            $categories = array();
            if ( $this->input->post('categories') )
                $categories = json_decode( $this->input->post('categories') );

            // If the current category is not listed, add it.
            if ( !in_array( $id, $categories) )
                array_push( $categories, $id );

            // Get main category uripath.
            $category = new Category();
            $category = $category->get_by_id( $categories[0] );

            // Set main uripath in content.
            $content->uripath = $category->uripath;

            // Save Content and your categories and values in Database.
            if ( $content->save( array(
                        'content_type' => $content_type,
                        'categories'   => $categories,
                        'values'       => $values,
                    )
                )
            ) {
                $data = array(
                    'reset'        => 1,
                    'notification' => array('success', $this->lang->line('save_success_message') ),
                );
            }
            else
                $data = array( 'notification' => array('error', $this->lang->line('save_error_message') ) );
        }
        else {

            //Get Fields Error Messages.
            $errors = array();
            foreach ( $fields as $field ) {
                if ( $error = $this->form_validation->error( $field['field'] ) )
                    $errors[ $field['field'] ] = strip_tags( $error );
            }

            $data = array(
                'show_errors'  => $content->errors->all + $errors,
                'notification' => array('error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * edit: Validate and Update a Content.
     *
     * @access public
     * @param  int $id, [Required] Content Identifier.
     * @return json
    **/
    public function edit( $id ) {

        // Get Category Id.
        $category_id = $this->input->get('category_id');

        // Initialize Content Object.
        $content = new Content;

        // Find Content to Edit.
        $content->get_by_id( $id );

        // Get Content Type Object.
        $content_type = $content->content_type->get();

        // Set Content attributes.
        $content->name             = $this->input->post('name');
        $content->publish_date     = $this->input->post('publish_date');
        $content->disable_date     = $this->input->post('disable_date');
        $content->weight           = $this->input->post('weight');
        $content->publish_flag     = $this->input->post('publish_flag');
        $content->last_update_date = gmdate("Y-m-d H:i:s"); // Force.
        $content->keywords         = $this->input->post('keywords');

        // Get Content Type Fields, add validation rules and save your values.
        $fields = $content_type->fields();

        $values = array();
        $rules  = 0;
        foreach ( $fields as $field ) {
            $values[ $field['field'] ] = $this->input->post( $field['field'] );

            foreach ( $field['rules'] as $rule ) {
                $rules++;

                // Add validation rule for field.
                $this->form_validation->set_rules(
                    $field['field'],
                    $field['label'],
                    $rule
                );
            }
        }

        // Validate the Content and your fields.
        $content->validate();

        // Validate the Content Fields.
        $valid = ( $rules > 0 ) ? $this->form_validation->run() : TRUE;

        // If the Content is valid insert the data.
        if ( $valid && $content->valid ) {

            // Get Categories to associate at this Content.
            $categories = array();
            if ( $this->input->post('categories') )
                $categories = json_decode( $this->input->post('categories') );

            // If the current category is not listed, and not have any category add it.
            if ( !in_array( $category_id, $categories ) && empty( $categories ) )
                array_push( $categories, $category_id );

            // Get main category uripath.
            $category = new Category();
            $category = $category->get_by_id( $categories[0] );

            // Set main uripath in content.
            $content->uripath = $category->uripath;

            // Save Content and your categories and values in Database.
            if ( $content->save( array(
                        'content_type' => $content_type,
                        'categories'   => $categories,
                        'values'       => $values,
                    )
                )
            ) {
                $data = array(
                    'show_errors'  => array(),
                    'notification' => array('success',$this->lang->line('save_success_message') ),
                );
            }
        }
        else {
            //Get Fields Error Messages.
            $errors = array();
            foreach ( $fields as $field ) {
                if ( $error = $this->form_validation->error( $field['field'] ) )
                    $errors[ $field['field'] ] = strip_tags( $error );
            }

            $data = array(
                'show_errors'  => $content->errors->all + $errors,
                'notification' => array('error',$this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * delete: Delete a Content
     *
     * @access public
     * @param  int $id, Content id
     * @return json
    **/
    public function delete( $id ) {

        // Get Category Id.
        $category_id = $this->input->get('category_id');

        // Initialize Content Object.
        $content = new Content;

        // Find Content to Edit.
        $content->get_by_id( $id );

        /*
          If Content has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if ( $content->delete( array( 'category' => $category_id ) ) ) {
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

/* End of file contents.php */
/* Location: ./applications/gpanel/controllers/json/categories/contents.php */
