<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Translations Class
 *
 * @package    CodeIgniter
 * @subpackage Controllers
 * @uses       Categories
 * @category   Categories
 * @author     Gonçalo Ferraria <gferraria@gmail.com>
 * @copyright  2015 Gonçalo Ferraria
 * @version    1.0 translations.php 2015-01-11 gferraria $
 */

include APPPATH . "controllers/html/Categories.php";

class Translations extends Categories {

    /**
     * @var Object, Content Object.
     * @access public
    **/
    public $content;

    /**
     * __construct: Class contruct.
     *              Load Language File.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();

        $this->config->load('i18n');

        // Get Content Object.
        $this->content  = new Content();
        $this->content->get_by_id( $this->uri->segment(6));

         if ( !$this->content->exists() )
            show_404();

        // Add upload modal data.
        $this->add_data( array(
                'table' => (object) array(
                    'source' => 'media/modal.json',
                    'header' => array(
                        $this->lang->line('file_name'),
                        $this->lang->line('file_filename'),
                        $this->lang->line('file_filetype'),
                        $this->lang->line('file_extension'),
                        $this->lang->line('file_filesize'),
                    ),
                    'showAll'   => 1,
                    'noActions' => 1,
                )
            )
        );
    }

    /**
     * index: Function not allowed.
     *
     * @access public
     * @return void
    **/
    public function index( $id ) {
        show_404();
    }

    /**
     * save: Build and Render Form.
     *
     * @access public
     * @return void
    **/
    public function save() {
        $language = new I18n_Language();
        $language->get_by_id( $this->uri->segment(7));

        if ( !$language->exists() )
            show_404();

        // Add Breadcumb to Add Content Translation.
        $this->breadcrumb->add( array(
                'text' => sprintf( $this->lang->line('content_translation_title_add'), $language->name, $this->content->name ),
                'href' => uri_string()
            )
        );

        // Build Translation Form.
        $form = new Form();
        $form->builder( 'post', '/categories/contents/translations/save/' . $this->content->id . '/' . $language->id .'.json' )
             ->add_fields( $this->_fields( $language ) );

        $this->add_data( array(
                'title' => sprintf( $this->lang->line('content_translation_title_add'), $language->name, $this->content->name ),
                'icon'  => base_url($this->config->item('i18n_flags_path') . $language->country .'.png'),
                'form'  => $form->render_form(),
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

        // Gets associated content type.
        $content_type = $this->content->content_type->get();

        // Content name is always translatable.
        $fields = array( 'name' => $this->content->validation['name'] );

        // Gets translatable fields for this content type.
        $fields = $fields + $content_type->translatable_fields();

        // Get content translatable values.
        $values = array();
        if ( !is_null( $lang ) )
            $values = $this->content->translatable_values( $lang );

        // Sort Firlds Array by Position.
        array_sort( $fields, 'position' );

        // Add Values to Fields if exist.
        if ( !empty ( $values ) ) {
            foreach ( $values as $name => $value )
                $fields[$name]['value'] =  $value;
        }

        return $fields;
    }

}

/* End of file  translations.php */
/* Location: ../applications/gpanel/controllers/html/categories/contents/translations.php */
