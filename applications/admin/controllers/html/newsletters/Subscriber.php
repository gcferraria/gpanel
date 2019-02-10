<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber extends HTML_Controller {
    /**
     * __construct: Newsletter subscriber class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        // Add Breadcrumb for Newsletter Contacts.
        $this->breadcrumb->add( array(
                'text' => lang('newsletter_subscriber_title'),
                'href' => 'newsletters/subscriber',
            )
        );
    }

    /**
     * index: Newsletter subscribers list page.
     *
     * @access public
     * @param  string $template, [Required] Page template
     * @return void
    **/
    public function index( $template = 'index' ) 
    {
        $data = (object) array(
            'source'  => 'newsletters/subscriber.json',
            'showAll' => TRUE,
            'header'  => array(
                lang('newsletter_subscriber_email'),
                lang('newsletter_subscriber_name'),
                lang('newsletter_subscriber_source'),
                lang('newsletter_subscriber_creation_date'),
                lang('newsletter_subscriber_status'),
            )
        );

        $this->add_data( array(
                'title' => lang('newsletter_subscriber_title'),
                'table' => $data,
                'table_actions' => array(
                    'activate' => array(
                        'data-text'      => lang('confirm_record'),
                        'url'            => 'newsletters/subscriber/activate.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => lang('activate'),
                        'icon'           => 'fa fa-check-square-o',
                    ),
                    'inactivate' => array(
                        'data-text'      => lang('confirm_record'),
                        'url'            => 'newsletters/subscriber/inactivate.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => lang('inactivate'),
                        'icon'           => 'fa fa-power-off',
                    ),
                    'separator' => array(),
                    'delete' => array(
                        'data-text'      => lang('confirm_record'),
                        'url'            => 'newsletters/subscriber/delete.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => lang('delete'),
                        'icon'           => 'fa fa-trash-o',
                    )
                )
            )
        );

        parent::index();
    }

   /**
     * save: Save a newsletter subscriber
     *
     * @access public
     * @param  int $id, [Required] Subsriber Identifier 
     * @return void
    **/
    public function save( $id ) 
    {
        $subscriber = new Newsletter_Subscriber();

        // Find subscriber to save.
        $subscriber->get_by_id( $id );

        // Check if subscriber exists.
        if( ! $subscriber->exists() ) 
        {
            show_404();
        }

        // Add Breadcrumb to edit subscriber.
        $this->breadcrumb->add( array(
                'text' => sprintf( lang('newsletter_subscriber_title_edit'), $subscriber->email),
                'href' => uri_string()
            )
        );

        // Inicialize subscriber form object.
        $newsletter_subscriber_form = new Form();

        // Build the subscriber form.
        $newsletter_subscriber_form
            ->builder('post', '/newsletters/subscriber/save/' . $subscriber->id . '.json')
            ->add_fields( $this->_fields( $subscriber ), $subscriber );

        $this->add_data( array(
                'title' => sprintf( lang('newsletter_subscriber_title_edit'), $subscriber->email ),
                'subscriber' => (object) array(
                    'form' => $newsletter_subscriber_form->render_form()
                )
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in subscriber form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $subscriber, [Required] Subscriber Object for fields definition.
     * @return array
    **/
    private function _fields( $subscriber ) 
    {
        // Get subscriber base fields.
        $fields = $subscriber->validation;

        // Extend subscriber field attributes.
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
                'values' => array( lang('active') => 1, lang('inactive')  => 0 ),
            ),
            'activation_token' => array(
                'attrs' => array(
                    'readonly' => 'readonly',
                )
            )
        );

        if ( $subscriber->active_flag = -1 ) {
            unset( $fields['active_flag'] );
            unset( $attrs['active_flag'] );
        }

        return array_replace_recursive( $fields, $attrs );
    }

}
