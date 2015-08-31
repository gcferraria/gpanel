<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Options Class
 *
 * @package    CodeIgniter
 * @subpackage Controllers
 * @uses       Categories
 * @category   Categories
 * @author     Gonçalo Ferraria <gferraria@gmail.com>
 * @copyright  2014 Gonçalo Ferraria
 * @version    1.0 options.php 2014-11-22 gferraria $
 */

include APPPATH . "controllers/html/categories.php";

class Options extends Categories {

    /**
     * __construct: Category Options Class constructor.
     *              Get current Category Object.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();

        // Add Default Breadcrumb.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('category_option_breadcrumb'),
                'href' => 'categories/options/index/' . $this->category->id,
            )
        );
    }

    /**
     * index: Add Category Options data, define actions and render
     *        Category Options List page.
     *
     * @access public
     * @return void
    **/
    public function index() {

        $options = (object) array(
            'source' => 'categories/options/own/' . $this->category->id . '.json',
            'header' => array(
                $this->lang->line('category_option_name'),
                $this->lang->line('category_option_value'),
            ),
        );

        $inherited = (object) array(
            'name'   => 'inherit',
            'header' => array(
                $this->lang->line('category_option_name'),
                $this->lang->line('category_option_value'),
            ),
            'contents' => $this->_inherit_options(),
        );

        $this->add_data( array(
                'title'   => $this->lang->line('category_option_title'),
                'actions' => array(
                    'Adicionar' => 'categories/options/add/' . $this->category->id,
                ),
                'options' => (object) array(
                    'own_options'       => $this->lang->line('own_options'),
                    'inherited_options' => $this->lang->line('inherited_options'),
                    'options_table'     => $options,
                    'inherit_table'     => $inherited,
                ),
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render Category Options Form.
     *
     * @access public
     * @return void
    **/
    public function add() {

        // Add Breadcumb to Add Category Option.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('category_option_breadcrumb_add'),
                'href' => uri_string(),
            )
        );

        // Inicialize Category Option Object and Form Object.
        $category_option_form = new Form();
        $category_option      = new Category_Option();

        // Build Category Object Form.
        $category_option_form
            ->builder( 'post', '/categories/options/add/' . $this->category->id . '.json')
            ->add_fields( $this->_fields( $category_option ) );

        $this->add_data( array(
                'title' => $this->lang->line('category_option_title_add'),
                'category_option' => (object) array(
                    'form' => $category_option_form->render_form()
                )
            )
        );

        parent::index();
    }

    /**
     * edit: Build and Render Category Option Form with Category Option data to edit.
     *
     * @access public
     * @return void
    **/
    public function edit( $id ) {

        // Initialize Category Object.
        $category_option = new Category_Option();

        // Find Category Object to Edit.
        $category_option->get_by_id( $this->uri->segment(5) );

        if ( ! $category_option->exists() )
            return;

        // Add Breadcrumb to edit Category Option.
        $this->breadcrumb->add( array(
                    'text' => sprintf(
                        $this->lang->line('category_option_breadcrumb_edit'),
                        $category_option->name
                    ),
                    'href' => uri_string(),
                )
            );

        // Inicialize Category Option Form Object.
        $category_option_form = new Form();

        // Build Category Object Form.
        $category_option_form
            ->builder( 'post', '/categories/options/edit/' . $category_option->id . '.json')
            ->add_fields(
                $this->_fields( $category_option ),
                $category_option
            );

        $this->add_data( array(
                    'title'   => $this->lang->line('category_option_title_edit'),
                    'category_option' => (object) array(
                        'form' => $category_option_form->render_form()
                    )
                )
            );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in category option form as
     *          well as their attributes.
     *
     * @access private
     * @return array
    **/
    private function _fields( $category_option ) {

        // Get Category Option Base Fields.
        $fields = $category_option->validation;

        // Define Category Option Attributes.
        $attrs = array(
            'inheritable' => array(
                'values' => array(
                    $this->lang->line('category_option_inheritable_yes') => 1,
                    $this->lang->line('category_option_inheritable_no')  => 0,
                ),
            )
        );

        return array_replace_recursive( $fields, $attrs );
    }

    /**
     * _inherit_options: Get Inherit Options.
     *
     * @access private
     * @return array
    **/
    private function _inherit_options () {

        // Get Inherit Options for this category.
        $inherit = $this->category->inherited_options();
        $own     = $this->category->own_options();

        $inherit_options = array();
        foreach ( $inherit as $name => $value ) {

            if ( array_key_exists( $name, $own ) )
                continue;

            $inherit_options[] = array(
                'name'  => $name,
                'value' => $value,
            );
        }

        return $inherit_options;
    }
}

/* End of file options.php */
/* Location: ../applications/gpanel/controllers/categories/options.php */