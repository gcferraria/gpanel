<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Translations Class
 *
 * @package    CodeIgniter
 * @subpackage Controllers
 * @uses       Categories
 * @category   Categories
 * @author     Gonçalo Ferraria <gferraria@gmail.com>
 * @copyright  2014 Gonçalo Ferraria
 * @version    1.0 translations.php 2014-12-08 gferraria $
 */

include APPPATH . "controllers/html/categories.php";

class Translations extends Categories {

    /**
     * __construct: Class contruct.
     *              Load Language File.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();

        // Load Language File.
        $this->lang->load('categories/translations');

        // Add Default Breadcrumb.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('category_translation_title'),
                'href' => 'categories/translations/index/' . $this->category->id,
            )
        );
    }

    /**
     * index: Add data and render list page.
     *
     * @access public
     * @return void
    **/
    public function index() {

        $this->add_data( array(
                'title'   => $this->lang->line('category_translation_title'),
                'table'   =>  (object) array(
                    'source' => 'categories/translations/index/' . $this->category->id . '.json',
                    'header' => array(
                        $this->lang->line('translation_name'),
                        $this->lang->line('translation_language'),
                        $this->lang->line('translation_creation_date'),
                    ),
                ),
                'actions' => array(
                    $this->lang->line('add') => 'categories/translations/add/' . $this->category->id,
                )
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render Form.
     *
     * @access public
     * @return void
    **/
    public function add() {

        // Add Breadcumb to Add Category Translation.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('category_translation_title_add'),
                'href' => uri_string()
            )
        );

        // Build Translation Form.
        $form = new Form();
        $form->builder( 'post', '/categories/translations/save/' . $this->category->id . '.json' )
             ->add_fields( $this->_fields() );

        $this->add_data( array(
                'title' => $this->lang->line('category_translation_title_add'),
                'form'  => $form->render_form(),
            )
        );

        parent::index();
    }

    /**
     * edit: Build and Render Form.
     *
     * @access public
     * @return void
    **/
    public function edit() {
        $language = new I18n_Language();
        $language->get_by_id( $this->uri->segment(5) );

        if ( ! $language->exists() )
            show_404();

        // Add Breadcumb to Edit Category Translation.
        $this->breadcrumb->add( array(
                'text' => sprintf( $this->lang->line('category_translation_title_edit'), $language->name ),
                'href' => uri_string()
            )
        );

         // Build Language Form.
        $form = new Form();
        $form->builder( 'post', '/categories/translations/save/' . $this->category->id . '.json' )
             ->add_fields( $this->_fields( $language ) );

        $this->add_data( array(
                'title' => sprintf($this->lang->line('category_translation_title_edit'), $language->name ),
                'form'  => $form->render_form()
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in form as well as their attributes.
     *
     * @access private
     * @param $object, $lang Language Object
     * @return array
    **/
    private function _fields( $lang = NULL ) {
        $translation = new Translation();

        // Get category translatable fields.
        $fields = $this->category->translatable_fields();

        // Get category translatable values.
        $values = array();
        if ( !is_null( $lang ) )
            $values = $this->category->translatable_values( $lang );

        // Get languages available for this category ( default language not included ).
        $languages = array();
        foreach ($this->category->languages() as $language ) {
            if( !$language->default )
                $languages[ $language->name ] = $language->id;
        }

        // Add language to category translatable fields.
        $fields['language_id'] = $translation->validation['language_id'];

        // Define category translatable fields attributes.
        $attrs = array( 'language_id' => array('values' => $languages ) );

        if ( !empty($lang ) ) {

            // Add a hidden field for indicate that operation is an update.
            $fields['operation'] = array(
                'field' => 'operation',
                'value' => 'update',
                'type'  => 'hidden',
                'rules' => array(),
            );

            // Add a hidden field for the language for.
            $fields['language_id'] = array(
                'field' => 'language_id',
                'value' => $lang->id,
                'type'  => 'hidden',
                'rules' => array(),
            );
        }

        $fields = array_replace_recursive( $fields, $attrs );

        // Add Values to Fields if exist.
        if ( !empty ( $values ) ) {
            foreach ( $values as $name => $value )
                $fields[$name]['value'] =  $value;
        }

        return $fields;
    }

}

/* End of file  translations.php */
/* Location: ../applications/gpanel/controllers/categories/translations.php */
