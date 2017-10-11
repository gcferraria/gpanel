<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Options extends JSON_Controller 
{
    /**
     * _own_options: Get Own Options.
     *
     * @access private
     * @param  object $category, Category Identifier.
     * @return array
    **/
    public function own( $id ) 
    {
        // Inicialize Category Object.
        $category = new Category;

        // Get Category.
        $category->get_by_id( $id );

        // Get Own Options for this Category.
        $own = $category->options;

        // Define base columns
        $columns = array('name', 'value');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) 
        {
            $own->or_like( array(
                    'name'     => $search_text,
                    'value' => $search_text,
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
                    $own->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
        {
            $own->order_by('name');
        }

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) 
        {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $own->get_paged( $page, $this->input->post('iDisplayLength') );

        $own_options = array();
        foreach ( $own as $option ) 
        {
            $own_options[] = array(
                "DT_RowId" => $option->id,
                0 => $option->name,
                1 => $option->value,
                2 => '<a href="'.site_url('categories/options/edit/'. $category->id . '/' . $option->id ).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> ' . $this->lang->line('edit') . '</a> <a href="#" class="btn btn-xs red-sunglo" data-text="' . $this->lang->line('delete_record') . '" data-url="'.base_url('/categories/options/delete/' . $option->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> ' . $this->lang->line('delete') . '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $own->paged->total_rows,
                "iTotalDisplayRecords" => $own->paged->total_rows,
                "aaData"               => $own_options,
                "page"                 => $page
            )
        );
    }

    /**
     * add: Validate and Insert Category Options.
     *
     * @access public
     * @param int $id, [Required] Category Identifier.
     * @return json
    **/
    public function add( $id ) 
    {
        // Inicialize Category Object and Category Option Object.
        $category = new Category;
        $option   = new Category_Option;

        // Get Category to Associate.
        $category->get_by_id( $id );

        // Set Category Option attributes.
        $option->name        = $this->input->post('name');
        $option->value       = $this->input->post('value');
        $option->inheritable = $this->input->post('inheritable');
        $option->category_id = $category->id;

        // If the Category Option is valid insert the data.
        if ( $option->save( $category, 'category' ) ) 
        {
            $data = array(
                'reset'        => 1,
                'notification' => array('success', $this->lang->line('save_success_message') ),
            );
        }
        else 
        {
            $data = array(
                'show_errors'  => $option->errors->all,
                'notification' => array('error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * edit: Validate and Update Category Option.
     *
     * @access public
     * @param int $id, [Required] Category Identifier.
     * @return json
    **/
    public function edit( $id ) 
    {
        // Inicialize Category Option Object.
        $option = new Category_Option;

        // Find Category Option to Edit.
        $option->get_by_id( $id );

        // Set Category Option attributes.
        $option->name        = $this->input->post('name');
        $option->value       = $this->input->post('value');
        $option->inheritable = $this->input->post('inheritable');

        // If the Category Option is valid update the data.
        if ( $option->save() ) 
        {
            $data = array(
                'show_errors'  => array(),
                'notification' => array('success', $this->lang->line('save_success_message') ),
            );
        }
        else 
        {
            $data = array(
                'show_errors'  => $option->errors->all,
                'notification' => array('error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * delete: Delete Category Option.
     *
     * @access public
     * @param  int $id, [Required] Category Identifier
     * @return json
    **/
    public function delete( $id ) 
    {
        // Inicialize Category Option Object.
        $option = new Category_Option;

        // Find Category Option to Delete.
        $option->get_by_id( $id );

        // Save category id before delete to refresh list.
        $category_id = $option->category_id;

        /*
          If Category Option has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if ( $option->delete() ) 
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