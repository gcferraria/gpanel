<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_Contacts extends HTML_Controller {

    /**
     * __construct: Newsletter Contacts Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {

        // Call parent constructor.
        parent::__construct( 'restrict' );

        // Add Breadcrumb for Newsletter Contacts.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('newsletter_contact_title'),
                'href' => 'newsletter_contacts',
            )
        );
    }

    /**
     * index: Add Newsletter Contacts data and render Newsletter Contacts list page.
     *
     * @access public
     * @return void
    **/
    public function index() {

        $data = (object) array(
            'source' => 'newsletter_contacts.json',
            'header' => array(
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
            )
        );

        parent::index();
    }

    /**
     * edit: Build and Render Newsletter Contact Form with data to edit.
     *
     * @access public
     * @return void
    **/
    public function edit( $id ) {
        $newsletter_contact = new Newsletter_Contact();

        // Find Newsletter Contact to Edit.
        $newsletter_contact->get_by_id( $id );

        // Check if Newsletter Contact exists.
        if ( ! $newsletter_contact->exists() )
            return;

        // Add Breadcrumb to edit Newsletter Contact.
        $this->breadcrumb->add( array(
                'text' => sprintf(
                    $this->lang->line('newsletter_contact_title_edit'),
                    $newsletter_contact->email
                ),
                'href' => uri_string(),
            )
        );

        // Inicialize Newsletter Contact Form Object.
        $newsletter_contact_form = new Form();

        // Build Newsletter Contact Form.
        $newsletter_contact_form
            ->builder('post', '/newsletter_contacts/edit/' . $newsletter_contact->id . '.json')
            ->add_fields(
                $this->_fields( $newsletter_contact ),
                $newsletter_contact
            );

            $this->add_data( array(
                'title' => sprintf(
                    $this->lang->line('newsletter_contact_title_edit'),
                    $newsletter_contact->email
                ),
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
     * @param  object $newsletter_contact, [Required] Newsletter Contact Object.
     * @return array
    **/
    private function _fields( $newsletter_contact ) {

        // Get Newsletter Contact base fields.
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

/* End of file newsletter_contacts.php */
/* Location: ../applications/gpanel/controllers/newsletter_contacts.php */