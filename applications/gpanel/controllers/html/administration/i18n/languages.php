<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Languages Class
 *
 * @package    CodeIgniter
 * @subpackage Controllers
 * @uses       HTML_Controller
 * @category   i18n
 * @author     Gonçalo Ferraria <gferraria@gmail.com>
 * @copyright  2014 Gonçalo Ferraria
 * @version    1.0 Languages.php 2014-11-15 gferraria $
 */

class Languages extends HTML_Controller {

    /**
     * __construct: Class constructor.
     *              Load Language File and Add default Breadcrumb.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();

        // Load Language File.
        $this->lang->load('i18n/languages');

        // Load Config File.
        $this->config->load('i18n');

        // Add Default Breadcrumb.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('i18n_language_title'),
                'href' => 'administration/i18n/languages',
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
                'title'   => $this->lang->line('i18n_language_title'),
                'table'   =>  (object) array(
                    'source' => 'administration/i18n/languages.json',
                    'header' => array(
                        $this->lang->line('i18n_language_code'),
                        $this->lang->line('i18n_language_name'),
                        $this->lang->line('i18n_language_active'),
                        $this->lang->line('i18n_language_default'),
                    ),
                ),
                'actions' => array(
                    $this->lang->line('add') => 'administration/i18n/languages/add',
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

        // Add Breadcumb to Add Language.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('i18n_language_title_add'),
                'href' => uri_string()
            )
        );

        // Build Language Form.
        $form = new Form();
        $form->builder( 'post', '/administration/i18n/languages/save.json' )
             ->add_fields( $this->_fields() );

        $this->add_data( array(
                'title' => $this->lang->line('i18n_language_title_add'),
                'form'  => $form->render_form(),
            )
        );

        parent::index();
    }

    /**
     * edit: Build and Render Form.
     *
     * @access public
     * @param  $id, Language Indentifier
     * @return void
    **/
    public function edit( $id ) {
        $language = new i18n_Language();
        $language->get_by_id( $id );

        if ( ! $language->exists() )
            show_404();

        // Add Breadcumb to Edit Language.
        $this->breadcrumb->add( array(
                'text' => sprintf( $this->lang->line('i18n_language_title_edit'), $language->name ),
                'href' => uri_string()
            )
        );

         // Build Language Form.
        $form = new Form();
        $form->builder( 'post', '/administration/i18n/languages/save/' . $language->id . '.json' )
             ->add_fields( $this->_fields(), $language );

        $this->add_data( array(
                'title' => sprintf( $this->lang->line('i18n_language_title_edit'), $language->name ),
                'form'  => $form->render_form()
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in form as well as their attributes.
     *
     * @access private
     * @return array
    **/
    private function _fields() {
        $language = new i18n_Language();

        // Get base fields.
        $fields = $language->validation;

        // Countries
        $contries = array();
        foreach ( $this->config->item('i18n_available_languages') as $lang ) {
            $contries[ $this->lang->line('i18n_language_' . $lang ) ] = $lang;
        }

        // Define I18n Language Fields Attributes.
        $attrs = array(
            'active' => array(
                'values' => array(
                    $this->lang->line('yes') => 1,
                    $this->lang->line('no')  => 0,
                ),
            ),
            'default' => array(
                'values' => array(
                    $this->lang->line('yes') => 1,
                    $this->lang->line('no')  => 0,
                ),
            ),
            'country' => array(
                'values' => $contries,
                'attrs'  => array( 'data-flags-path' => $this->config->item('i18n_flags_path') )
            ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

}

/* End of file languages.php */
/* Location: ../applications/gpanel/controllers/html/administration/i18n/languages.php */
