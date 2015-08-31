<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends JSON_Controller {

    /**
     * index: Get Categories Structure.
     *
     * @access public
     * @param  int $id, Base Category Id.
     * @return json
    **/
    public function index( $id ) {
        parent::index( $this->_category_data( $id ) );
    }

    /**
     * _category_data: Get Category information and your childrens
     *
     * @access private
     * @param  int $id, Category Id.
     * @return array
    **/
    private function _category_data( $id ) {

        // Initialize Category Object.
        $category = new Category;

        // Find Category.
        $category->get_by_id( $id );

        // Get Categories
        $categories = $category
            ->childrens
            ->order_by('weight ASC');

        // Get Children for this Category.
        $children = array();
        foreach ( $categories->get() as $child ) {
            array_push( $children, $this->_category_data( $child->id ) );
        }

        $data = array(
            'id'    => $category->id,
            'text'  => $category->name,
            'state' => array(
                'selected' => ( $category->id == $this->input->get('selected') ) ? TRUE : FALSE
            ),
            'a_attr' => array(
                'href' => site_url( 'categories/contents/index/' . $category->id ),
                'id' => $category->id
            ),
            'li_attr'  => array(
                'id' => $category->id
            ),
            'children' => $children,
        );

        return $data;
    }

    /**
     * add: Validate and Insert Category.
     *
     * @access public
     * @param  int $id, Parent Category Id
     * @return json
    **/
    public function add( $id ) {

        // Inicialize Category Object and Get Parent Category.
        $parent = new Category();
        $category = new Category;

        $parent->get_by_id( $id );

        // Build Uriname.
        $uripath = sprintf( '%s%s/',
                $parent->path(),
                $this->input->post('uriname')
            );

        // Set Category attributes.
        $category->parent_id    = $id;
        $category->name         = $this->input->post('name');
        $category->uriname      = $this->input->post('uriname');
		$category->description  = $this->input->post('description');
        $category->weight       = $this->input->post('weight');
        $category->publish_flag = $this->input->post('publish_flag');
        $category->listed       = $this->input->post('listed');
        $category->exposed      = $this->input->post('exposed');
        $category->uripath      = $uripath;
        $category->creator_id   = $this->administrator->id;

        // Validate Category.
        $category->validate();

        // If the Category is valid insert the data.
        if ( $category->valid ) {

            $content_types = array();
            if( is_array($this->input->post('content_types') ) ) {
                foreach ( $this->input->post('content_types')  as $content_type ) {
                    if( !empty($content_type) )
                        $content_types[] = $content_type;
                }
            }

            // Get Categories to build category view.
            $categories = array();
            if ( $this->input->post('views') )
                $categories = json_decode( $this->input->post('views') );

            // Save Category and content types in Database.
            if (
                $category->save( array(
                        'content_types' => $content_types,
                        'views'         => $categories
                    )
                )
            ) {
                $data = array(
                    'reset'         => 1,
                    '$notification' => array(
                        'value' => $this->lang->line('category_insert_success_message'),
                        'show'  => 'success',
                    ),
                    'root.$categories.$body.reload' => 1
                );
            }
        }
        else {

            $data = array(
                'show_errors' => $category->errors->all,
                '$notification' => array(
                    'value' => $this->lang->line('category_insert_error_message'),
                    'show'  => 'error'
                ),
            );
        }

        parent::index( $data );
    }

    /**
     * edit: Validate and Update Category.
     *
     * @access public
     * @param  int $id, Category id.
     * @return json
    **/
    public function edit( $id ) {

        // Initialize Category Object.
        $category = new Category;

        // Find Category to Edit.
        $category->get_by_id( $id );

        // Save Original Uriname.
        $uriname = $category->uriname;

        // Set Category attributes.
        $category->name         = $this->input->post('name');
        $category->uriname      = $this->input->post('uriname');
        $category->description  = $this->input->post('description');
		$category->weight       = $this->input->post('weight');
        $category->publish_flag = $this->input->post('publish_flag');
        $category->listed       = $this->input->post('listed');
        $category->exposed      = $this->input->post('exposed');

        if ( $uriname != $this->input->post('uriname') )
            $category->uripath = $category->path();

        // Validate Category.
        $category->validate();

        // If the Category is valid insert the data.
        if ( $category->valid ) {

            $content_types = array();
            if( is_array($this->input->post('content_types') ) ) {
                foreach ( $this->input->post('content_types')  as $content_type ) {
                    if( !empty($content_type) )
                        $content_types[] = $content_type;
                }
            }

            // Get Categories to build category view.
            $categories = array();
            if ( $this->input->post('views') )
                $categories = json_decode( $this->input->post('views') );

            // Save Category and content types in Database.
            if (
                $category->save( array(
                        'content_types' => $content_types,
                        'views'         => $categories
                    )
                )
            ) {
                // Necessary update all your childrens.
                if ( $uriname != $category->uriname ) {

                    foreach ( $category->childrens->get() as $child ) {
                        $child->uripath = $child->path();
                        $child->save();
                    }
                }

                $data = array(
                    'show_errors'  => array(),
                    'notification' => array('success', $this->lang->line('category_update_success_message') ),
                    'root.$categories.$body.reload' => 1
                );
            }
        }
        else {
            $data = array(
                    'show_errors'  => $category->errors->all,
                    'notification' => array('error',$this->lang->line('category_update_error_message') ),
                );
        }

        parent::index( $data );
    }

    /**
     * delete: Validate and Delete Category.
     *
     * @access public
     * @param  int $id, Category id.
     * @return json
    **/
    public function delete( $id ) {

         // Initialize Category Object.
        $category = new Category;

        // Find Category to Delete.
        $category->get_by_id( $id );

        // Set rule validation to macth category name
        $category->validation['name']['rules'] = array(
                'required',
                'valid_match' => array( $category->name )
            );

        // Set Category attributes.
        $category->name = $this->input->post('name');

        // Validate Category.
        $category->validate();

        // If the Category is valid insert the data.
        if ( $category->valid ) {

            // Save parent id before delete category.
            $parent_id = $category->parent_id;

            // Save Category in database.
            if ( $category->delete() ) {

                $data = array(
                    'reset'        => 1,
                    'notification' => array('success', $this->lang->line('category_delete_success_message') ),
                    'redirect'     => array(
                        'url'      => site_url("/categories/contents/index/$parent_id"),
                        'duration' => 1000,
                    ),
                );
            }
        }
        else {
            $data = array(
                'show_errors'  => $category->errors->all,
                'notification' => array('error', $this->lang->line('category_delete_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * search: Search Category by Name.
     *
     * @access public
     * @return json
    **/
    public function search() {

        // Instanciate Category Object.
        $categories = new Category();

        // Add Search Text if defined.
        $search_text = $this->input->post('q');

        // Get Content Type Filter.
        $content_type = $this->input->get('content_type');

        // Initialize Result.
        $data = array();
        if ( !empty( $search_text ) ) {

            // Add Content Type filter if defined.
            if ( !empty ( $content_type ) ) {
                $categories->where_related_content_types(
                        'uriname', $content_type
                    );
            }

            // For not include current category.
            $curr_id = $this->input->get('current_id');
            if( !empty( $curr_id ) )
                $categories->not_like('id', $curr_id);

            // Add Search Text on name.
            $categories->like( 'name', $search_text );

            foreach ( $categories->get() as $category ) {
                $data[] = array(
                    'name'  => $category->id,
                    '$name' => $category->name,
                    '$path' => implode( ' » ', $category->path_name_array() ),
                );
            }
        }

        parent::index( $data );
    }

}

/* End of file categories.php */
/* Location: ./applications/gpanel/controllers/json/categories.php */