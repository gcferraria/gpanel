<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Websites Class
 *
 * @package    CodeIgniter
 * @subpackage Controllers
 * @uses       HTML_Controller
 * @category   Settings
 * @author     Gonçalo Ferraria <gferraria@gmail.com>
 * @copyright  2014 Gonçalo Ferraria
 * @version    1.0 Websites.php 2014-11-22 gferraria $
 */

class Websites extends HTML_Controller {

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
        $this->lang->load('settings/websites');

        // Add Default Breadcrumb.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('settings_website_titles'),
                'href' => 'administration/settings/websites',
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
                'title'   => $this->lang->line('settings_website_titles'),
                'table'   =>  (object) array(
                    'source' => 'administration/settings/websites.json',
                    'header' => array(
                        $this->lang->line('settings_website_name'),
                        $this->lang->line('settings_website_domain'),
                        $this->lang->line('settings_website_category'),
                    ),
                ),
                'actions' => array(
                    $this->lang->line('add') => 'administration/settings/websites/add',
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

        // Add Breadcumb to Add Website.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('settings_website_title_add'),
                'href' => uri_string()
            )
        );

        // Build Form.
        $form = new Form();
        $form->builder( 'post', '/administration/settings/websites/save.json' )
             ->add_fields( $this->_fields() );

        $this->add_data( array(
                'title' => $this->lang->line('settings_website_title_add'),
                'form'  => $form->render_form(),
            )
        );

        parent::index();
    }

    /**
     * edit: Build and Render Form.
     *
     * @access public
     * @param  $id, Website Indentifier
     * @return void
    **/
    public function edit( $id ) {
        $website = new Settings_Website();
        $website->get_by_id( $id );

        if ( ! $website->exists() )
            show_404();

        // Add Breadcumb to Edit Website.
        $this->breadcrumb->add( array(
                'text' => sprintf( $this->lang->line('settings_website_title_edit'), $website->name ),
                'href' => uri_string()
            )
        );

         // Get Languages for this Website.
        $languages = array();
        foreach( $website->languages->get() as $language )
            $languages[] = $language->id;

        $website->languages = $languages;

         // Build Form.
        $form = new Form();
        $form->builder( 'post', '/administration/settings/websites/save/' . $website->id . '.json' )
             ->add_fields( $this->_fields(), $website );

        $this->add_data( array(
                'title' => sprintf( $this->lang->line('settings_website_title_edit'), $website->name ),
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
        $website  = new Settings_Website();
        $language = new I18n_Language();

        // Get base fields.
        $fields = $website->validation;

        // Get Available Languages.
        $language->where( 'active', 1 );
        $languages = array();
        foreach ( $language->get() as $object )
            $languages[ $object->name ] = $object->id;

        // Define Website Settings Fields Attributes.
        $attrs = array(
            'title'       => array( 'attrs'  => array( 'maxlength' => 70  ) ),
            'description' => array( 'attrs'  => array( 'maxlength' => 160 ) ),
            'languages'   => array( 'values' => $languages ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

}

/* End of file websites.php */
/* Location: ../applications/gpanel/controllers/html/administration/settings/websites.php */
