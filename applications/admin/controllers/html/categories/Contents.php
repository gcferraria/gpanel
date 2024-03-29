<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH . "controllers/html/Categories.php";

class Contents extends Categories 
{
    /**
     * __construct: Contents Class constructor.
     *              Define data for upload modal.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        $this->config->load('i18n');

        if (
            $this->uri->segment(3) == 'add' ||
            $this->uri->segment(3) == 'edit'
        ) 
        {
            // Add upload modal data.
            $this->add_data( array(
                    'table' => (object) array(
                        'source' => 'media/modal.json',
                        'header' => array(
                            $this->lang->line('file_name'),
                            $this->lang->line('file_filename'),
                            $this->lang->line('file_filesize'),
                        ),
                        'showAll'   => 1,
                        'noActions' => 1,
                    )
                )
            );
        }
    }

    /**
     * index: Add Content data, define category actions and render Content List page.
     *
     * @access public
     * @return void
    **/
    public function index( $template = 'index' )
    {
        $actions = $languages = array();

        if ( count( explode ( '/', $this->category->uripath ) ) >= 4 ) 
        {
            $actions = array(
                $this->lang->line('add')  => 'categories/add/'  . $this->category->id,
                $this->lang->line('edit') => 'categories/edit/' . $this->category->id
            );

            // Checks if option delete category it is available.
            if( count( explode ( '/', $this->category->uripath ) ) > 4 )
                $actions[ $this->lang->line('delete') ] = 'categories/delete/' . $this->category->id;

            // Checks if category has translations.
            $languages = $this->category->languages();
            if ( count( $languages ) > 1 )
                $actions[ $this->lang->line('translations') ] = 'categories/translations/index/' . $this->category->id;
        }

        // Always add category options.
        $actions[ sprintf( $this->lang->line('category_option_title'), $this->category->name ) ] = 'categories/options/index/' . $this->category->id;

        // Gets available Content Types.
        $content_types = $this->category->content_types->where('active_flag', 1);

        // Gets Availables Category Views.
        $views = array();
        foreach ( $this->category->views->get() as $view ) 
        {
            $category = new Category();
            $category->get_by_id( $view->dest_category_id );
            array_push( $views, $category );
        }

        // If Exists content types for this category show icon for add content.
        if ( $content_types->count() && count( $views ) == 0 )
            $actions[ $this->lang->line('content_title_add') ] = 'categories/contents/add/' . $this->category->id;

        $data = (object) array(
            'source'    => 'categories/contents/index/' . $this->category->id . '.json',
            'languages' => $languages,
            'header'    => array(
                $this->lang->line('content_name'),
                $this->lang->line('content_content_type'),
                $this->lang->line('content_publish_date'),
                $this->lang->line('content_weight'),
                $this->lang->line('content_status'),
            )
        );

        $this->add_data( array(
                'views'     => $views,
                'table'     => $data,
                'actions'   => $actions
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render Content Form.
     *
     * @access public
     * @return void
    **/
    public function add() 
    {
        // Add Breadcumbs to Add Content.
        $this->breadcrumb->add( array(
                array(
                    'text'  => $this->lang->line('content_title_add'),
                    'href'  => uri_string(),
                ),
            )
        );

        // Inicialize Content and Content Form Object.
        $content      = new Content();
        $content_form = new Form();

        /*
            If exist one more content types and any have chose, show form to
            select content type.
        */
        $content_type  = $this->session->flashdata('content_type');
        $content_types = $this->category->content_types->where( array(
                'active_flag' => 1,
            )
        );

        if ( $content_types->count() > 1 && !$content_type ) 
        {
            // Load available content types.
            $values = array();
            foreach ( $content_types->get() as $object ) 
                $values[ $object->name ] = $object->id;

            // Build Chose Content Type Form.
            $content_form
                ->builder( 'post', '/categories/contents/content_type/' . $this->category->id . '.json' )
                ->add_fields(
                    array(
                        'content_type_id' => array(
                            'field'  => 'content_type_id',
                            'label'  => $this->lang->line('content_content_type_id'),
                            'type'   => 'select',
                            'rules'  => array('required'),
                            'values' => $values,
                            'help'   => $this->lang->line('content_content_type_help'),
                        ),
                    )
                );
        }
        else 
        {
            // Keep content type.
            $this->session->keep_flashdata('content_type');

            // Get Content Type Object.
            if ( $content_type )
                $content_type = $content_types->get_by_id( $content_type );
            else
                $content_type = $content_types->get(1);

            // Add Content Type Fields to Content Base Fields.
            $fields = $this->_fields( $content, $content_type );

            $content_form
                ->builder( 'post', '/categories/contents/add/' . $this->category->id . '.json')
                ->add_fields( $fields );
        }

        $this->add_data( array(
                'title' => $this->lang->line('content_title_add'),
                'content' => (object) array(
                    'form' => $content_form->render_form(),
                )
            )
        );

        parent::index();
    }

    /**
    * edit: Build and Render Content Form.
    *
    * @access public
    * @return void
    **/
    public function edit( $id ) 
    {
        // Add Breadcumbs to Edit Content.
        $this->breadcrumb->add( array(
                array(
                    'text'  => $this->lang->line('content_title_edit'),
                    'href'  => uri_string(),
                ),
            )
        );

        // Inicialize Content and Content Form Object.
        $content      = new Content();
        $content_form = new Form();

        // Get Content to Edit.
        $content->get_by_id( $this->uri->segment(5) );

        if ( ! $content->exists() )
            show_404();

        // Get Categories for this Content and convert to JSON.
        $categories = array();
        foreach ( $content->categories->order_by('contents_category_content.id')->get() as $category ) 
        {   
            $obj = array(
                'name'   => $category->id,
                '$name'  => $category->name,
                '$path'  => implode( ' » ', $category->path_name_array() ),
            );

            if ( ( $category->uripath == $content->uripath ) ) {
                $obj['select'] = true;
            }

            array_push( $categories, $obj);
        }

        //die(var_dump($categories));

        $content->categories = htmlentities( json_encode( $categories ) );

        // Build Content Object Form.
        $content_form
            ->builder(
                'post',
                '/categories/contents/edit/' . $content->id . '.json?category_id=' . $this->category->id
            )
            ->add_fields(
                $this->_fields( $content, $content->content_type->get() ),
                $content
            );

        $this->add_data( array(
                'title' => $this->lang->line('content_title_edit'),
                'content' => (object) array(
                    'form' => $content_form->render_form(),
                )
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in content form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $content     , [Required] Content Object.
     * @param  object $content_type, [Required] Content Type Object.
     * @return array
    **/
    private function _fields( $content, $content_type ) 
    {
        // Gets Content Base Fields.
        $fields = $content->validation;

        // Gets Content Values.
        $values = $content->as_name_value_array();

        // Define Content Fields Attributes.
        $attrs = array(
            'content_type_id' => array(
                'value' => $content_type->id,
            ),
            'publish_flag' => array(
                'values' => array(
                    $this->lang->line('content_publish_yes') => 1,
                    $this->lang->line('content_publish_no')  => 0,
                ),
            ),
            'categories'   => array(
                'attrs' => array(
                    'placeholder'  => $this->lang->line('content_categories_placeholder'),
                    'data-jsb-url' => base_url( '/categories/search.json?content_type=' . $content_type->uriname ),
                ),
            ),
        );

        $fields = array_replace_recursive( $fields, $attrs );
        $content_type_fields = $content_type->fields();

        // Populate values for content type fields category.
        foreach ($content_type_fields as $content_type_field) 
        {
            if ( $content_type_field['type'] == 'category' ) 
            {
                if ( isset( $values[$content_type_field['field'] ] ) ) 
                {
                    $ids = json_decode($values[$content_type_field['field'] ]);

                    $categories = array();
                    foreach ($ids as $id) 
                    {
                        $category = new Category();
                        $category->get_by_id( $id );

                        array_push( $categories, array(
                                'name'  => $id,
                                '$name' => $category->name,
                                '$path' => implode( ' » ', $category->path_name_array() ),
                            )
                        ); 
                    }

                    $values[$content_type_field['field'] ] = htmlentities( json_encode( $categories ) );
                }
            }
            else if ( $content_type_field['type'] == 'content' ) 
            {
                if ( isset( $values[$content_type_field['field'] ] ) ) 
                {
                    $ids = json_decode($values[$content_type_field['field'] ]);

                    $contents = array();
                    foreach ($ids as $id) 
                    {
                        $c = new Content();
                        $c->get_by_id( $id );

                        array_push( $contents, array(
                                'name'  => $c->id,
                                '$name' => character_limiter($c->name,50),
                                '$path' => implode( ' » ', $c->categories->get(0)->path_name_array() ),
                            )
                        ); 
                    }

                    $values[$content_type_field['field'] ] = htmlentities( json_encode( $contents ) );
                }
            }
        }

        // Add Content Type Fields to Base Fields.
        $fields = $fields + $content_type_fields;

        // Sort Firlds Array by Position.
        array_sort( $fields, 'position' );

        // Add Values to Fields if exist.
        if ( !empty ( $values ) ) 
        {
            foreach ( $values as $name => $value )
                $content->{ $name } = $value;
        }

        return $fields;
    }

    /**
     * _upload_fields: Define the fields to be displayed in upload form
     *          well as their attributes.
     *
     * @access private
     * @return array
    **/
    private function _upload_fields() 
    {
        // Initialize File Object.
        $file = new File();

        // Get Media base fields.
        $fields = $file->validation;

        // Define Media Fields Attributes.
        $attrs = array(
            'name' => array(
                'attrs' => array( 'class' => 'big' )
            ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

}