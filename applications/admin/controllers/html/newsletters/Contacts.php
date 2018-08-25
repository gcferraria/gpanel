<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends HTML_Controller 
{
    /**
     * __construct: Newsletter Contacts Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        // Add Breadcrumb for Newsletter Contacts.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('newsletter_contact_title'),
                'href' => 'newsletters/contacts',
            )
        );
    }

    /**
     * index: Add Newsletter Contacts data and render Newsletter Contacts list page.
     *
     * @access public
     * @return void
    **/
    public function index( $template = 'index' ) 
    {
        $data = (object) array(
            'source'  => 'newsletters/contacts.json',
            'showAll' => TRUE,
            'header'  => array(
                $this->lang->line('newsletter_contact_email'),
                $this->lang->line('newsletter_contact_name'),
                $this->lang->line('newsletter_contact_source'),
                $this->lang->line('newsletter_contact_creation_date'),
                $this->lang->line('newsletter_contact_status'),
            ),
        );

        $this->add_data( array(
                'title' => $this->lang->line('newsletter_contact_title'),
                'table' => $data,
                'table_actions' => array(
                    'activate' => array(
                        'data-text'      => $this->lang->line('confirm_record'),
                        'url'            => 'newsletters/contacts/activate.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => $this->lang->line('activate'),
                        'icon'           => 'fa fa-check-square-o',
                    ),
                    'inactivate' => array(
                        'data-text'      => $this->lang->line('confirm_record'),
                        'url'            => 'newsletters/contacts/inactivate.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => $this->lang->line('inactivate'),
                        'icon'           => 'fa fa-power-off',
                    ),
                    'separator' => array(),
                    'delete' => array(
                        'data-text'      => $this->lang->line('confirm_record'),
                        'url'            => 'newsletters/contacts/delete.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => $this->lang->line('delete'),
                        'icon'           => 'fa fa-trash-o',
                    ),
                ),
            )
        );

        parent::index();
    }

   /**
     * save: Save a contact for newsletter
     *
     * @access public
     * @return void
    **/
    public function save( $id ) 
    {
        $newsletter_contact = new Newsletter_Contact();

        // Find contact to Edit.
        $newsletter_contact->get_by_id( $id );

        // Check if contact exists.
        if ( ! $newsletter_contact->exists() )
            show_404();

        // Add Breadcrumb to edit Contact.
        $this->breadcrumb->add( array(
                'text' => sprintf( $this->lang->line('newsletter_contact_title_edit'), $newsletter_contact->email),
                'href' => uri_string()
            )
        );

        // Inicialize Newsletter Contact Form Object.
        $newsletter_contact_form = new Form();

        // Build Newsletter Contact Form.
        $newsletter_contact_form
            ->builder('post', '/newsletters/contacts/save/' . $newsletter_contact->id . '.json')
            ->add_fields( $this->_fields( $newsletter_contact ), $newsletter_contact );

        $this->add_data( array(
                'title' => sprintf( $this->lang->line('newsletter_contact_title_edit'), $newsletter_contact->email ),
                'newsletter_contact' => (object) array(
                    'form' => $newsletter_contact_form->render_form()
                )
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in newsletter contact form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $newsletter_contact, [Required] Newsletter Contact Object for fields definition.
     * @return array
    **/
    private function _fields( $newsletter_contact ) 
    {
        // Get newsletter contact base fields.
        $fields = $newsletter_contact->validation;

        // Define Newsletter Contact Fields Attributes.
        $attrs = array(
            'email' => array(
                'attrs' => array(
                    'readonly' => 'readonly',
                )
            ),
            'source' => array(
                'attrs' => array(
                    'readonly' => 'readonly',
                )
            ),
            'active_flag' => array(
                'values' => array(
                    $this->lang->line('yes') => 1,
                    $this->lang->line('no')  => 0,
                ),
            ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

}