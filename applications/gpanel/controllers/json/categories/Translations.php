<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translations extends JSON_Controller 
{
    /**
     * index: Get Category Translations data.
     *
     * @access public
     * @return json
    **/
    public function index( $id ) 
    {
        // Initialize Category Object.
        $category = new Category();

        // Define base columns.
        $columns = array();

        // Get Category Object.
        $category->get_by_id( $id );

        if ( !$category->exists() )
            show_404();

        // Get All Translations for this Category.
        $translations = $category->translations->where('name','name');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) 
        {
            $translations->or_like( array(
                    'name'  => $search_text,
                    'value' => $search_text
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) 
            {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) 
                {
                    $translations->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
        {
            $translations->order_by('id');
        }
        
         // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) 
        {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $translations->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $translations as $translation ) 
        {
            $language = $translation->language->get();

            $data[] = array(
                "DT_RowId" => $translation->id,
                0 => $translation->value,
                1 => $language->name,
                2 => $translation->creation_date,
                3 => '<a href="'.site_url('categories/translations/edit/'. $category->id  . '/' . $language->id ).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> ' . $this->lang->line('edit') . '</a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="' . $this->lang->line('delete_record') . '" data-url="'.base_url('categories/translations/delete/' . $language->id ).'.json?category_id=' . $category->id . '" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> ' . $this->lang->line('delete') .'</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $translations->paged->total_rows,
                "iTotalDisplayRecords" => $translations->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * save: Validate and Save an Category Translation.
     *
     * @access public
     * @param  int $id, Category Id
     * @return json
    **/
    public function save( $id ) 
    {
        $errors      = array();
        $category    = new Category();
        $translation = new Translation();
        $language    = new I18n_Language();

        // Get Category Object for Translate.
        $category->get_by_id( $id );
        $language->get_by_id( $this->input->post('language_id') );

        if ( !$category->exists() || !$language->exists() )
            show_404();

        $translation->category_id = $category->id;
        $translation->language_id = $language->id;
        $translation->name        = 'name';

        // Get Translatable fields to be validate.
        $fields = $category->translatable_fields();

        // Validate Translation.
        $translation->validate();

        $values = array();
        $rules  = 0;
        foreach ( $fields as $field ) 
        {
            $values[ $field['field'] ] = $this->input->post( $field['field'] );

            foreach ( $field['rules'] as $rule ) 
            {
                $rules++;

                // Add validation rule for field.
                $this->form_validation->set_rules(
                    $field['field'],
                    $field['label'],
                    $rule
                );
            }
        }

         // Validate the Content Fields.
        $valid = ( $rules > 0 ) ? $this->form_validation->run() : TRUE;

        // Check Operation
        $operation = $this->input->post('operation');

        // Check if this combination already exists
        if( $valid && empty( $operation ) ) 
        {
            if ( ( $valid = !($translation->get()->exists()) ) == FALSE )
                $errors['language_id'] = $this->lang->line('unique_combination');
        }

        // If the Content is valid insert the data.
        if ( $valid && $translation->valid ) 
        {
            foreach ($fields as $field) 
            {
                $translation = new Translation();

                if ( empty( $operation ) ) 
                {
                    $translation->category_id = $category->id;
                    $translation->language_id = $language->id;
                    $translation->name        = $field['field'];
                    $translation->value       = $this->input->post( $field['field'] );
                }
                else 
                {
                    $translation->where(array(
                            'category_id' => $category->id,
                            'language_id' => $language->id,
                            'name'        => $field['field']
                        )
                    )->get();

                    $translation->value = $this->input->post( $field['field'] );
                }

                $translation->save();
            }

            $data = array('notification' => array('success', $this->lang->line('save_success_message') ) );

            if ( empty( $operation ) )
                $data['reset'] = 1;
        }
        else 
        {
            //Get Fields Error Messages.
            foreach ( $fields as $field ) 
            {
                if ( $error = $this->form_validation->error( $field['field'] ) )
                    $errors[ $field['field'] ] = strip_tags( $error );
            }

            $data = array(
                'show_errors'  => $errors + $translation->errors->all,
                'notification' => array('error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * delete: Delete Translations for combination Category/Content and Language.
     *
     * @access public
     * @param  int $language id, Language identifier
     * @return json
    **/
    public function delete( $language_id ) 
    {
        $object;
        $category_id = $this->input->get('category_id');
        if ( !empty( $category_id ) ) 
        {
            $object = new Category();
            $object->get_by_id( $category_id );
        }

        if( empty($object) || !$object->exists() ) 
        {
            return parent::index(
                array(
                    'result'  => 0,
                    'message' => $this->lang->line('delete_error_message'),
                )
            );
        }

        $result = TRUE;
        if ( $object->translations->count() > 0 ) 
        {
            $translations = $object->translations->where('language_id', $language_id)->get();
            $result = $object->delete( $translations->all, 'translations' );
        }

        if( $result ) 
        {
            return parent::index(
                array(
                    'result'  => 1,
                    'message' => $this->lang->line('delete_success_message'),
                )
            );
        }
        else 
        {
            return parent::index(
                array(
                    'result'  => 0,
                    'message' => $this->lang->line('delete_error_message'),
                )
            );
        }
    }
}