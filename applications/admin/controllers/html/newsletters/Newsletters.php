<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletters extends HTML_Controller 
{
    /**
     * __construct: Newsletters Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        // Load Configuration File.
        $this->load->config('newsletter');

        // Add Breadcrumb for Newsletters.
        $this->breadcrumb->add( array(
                'text' => lang('newsletter_title'),
                'href' => 'newsletters/newsletters',
            )
        );
    }

    /**
     * index: Add Newsletters data and render Newslettes list page.
     *
     * @access public
     * @return void
    **/
    public function index( $template = 'index' ) 
    {
        $data = (object) array(
            'source' => 'newsletters/newsletters.json',
            'header' => array(
                lang('newsletter_name'),
                lang('newsletter_creation_date'),
            )
        );

        $this->add_data( array(
                'title'   => lang('newsletter_title'),
                'table'   => $data,
                'actions' => array(
                    lang('newsletter_title_add') => 'newsletters/newsletters/add',
                )
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render Newsletter Form based on step.
     *
     * @access public
     * @param  int step_number, Step Number 
     * @return void
    **/
    public function step( $step_number = 1 ) 
    {
        // Add Breadcumb to Add Newsletter.
        $this->breadcrumb->add( array(
                'text' => lang('newsletter_title_add'),
                'href' => uri_string()
            )
        );

        // Inicialize Newsletter Object.
        $newsletter = new Newsletter();

        // Initialize Multistep Form Object.
        $newsletter_form = new Multistep();

        // Build Newsletter Form with 3 steps.
        $newsletter_form
            ->builder( 'post', '/newsletters/newsletters/add.json' )
            ->add_fields( array(
                    array(
                        'title'  => lang('newsletter_step1'),
                        'fields' => $this->_general_information_fields( $newsletter ),
                    ),
                    array(
                        'title'  => lang('newsletter_step2'),
                        'fields' => $this->_contents_fields( $newsletter ),
                    ),
                    array(
                        'title'  => lang('newsletter_step3'),
                        'fields' => $this->_confirmation_fields( $newsletter ),
                    ),
                    array(
                        'title'  => lang('newsletter_step4'),
                        'fields' => array(),
                    )
                )
            );

        $this->add_data( array(
                'title'      => lang('newsletter_title_add'),
                'newsletter' => (object) array(
                    'form' => $newsletter_form->render_form(),
                )
            )
        );

        parent::index();
    }

    /**
     * _general_information_fields: Define the fields to be displayed in step 1 of newsletter form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $newsletter, [Required] Newsletter Object.
     * @return array
    **/
    private function _general_information_fields( $newsletter ) 
    {
        // Get Newsletter base fields.
        $fields = $newsletter->validation;

        // Select only the fields for 1st step.
        $step_fields = array();
        foreach ( array( 'name', 'from', 'template' ) as $name )
            $step_fields[ $name ] = $fields[ $name ];

        $attrs = array(
            'name' => array(
                'help' => lang('newsletter_name_help'),
            ),
            'from' => array(
                'values' => $this->config->item('newsletter_from_emails'),
                'help'   => lang('newsletter_from_help'),
            ),
            'template' => array(
                'values' => $this->config->item('newsletter_templates'),
                'help'   => lang('newsletter_template_help'),
            )
        );

        return array_replace_recursive( $step_fields, $attrs );
    }

    /**
     * _contents_fields: Define the fields to be displayed in step 2 of newsletter form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $newsletter, [Required] Newsletter Object.
     * @return array
    **/
    private function _contents_fields( $newsletter ) 
    {
        // Get Newsletter base fields.
        $fields = $newsletter->validation;

        // Get available Content Types.
        $content_types = new Content_Type();
        $content_types
            ->where('active_flag', 1)
            ->where_in('uriname', $this->config->item('newsletter_content_types'));

        // Load available content types.
        $values = array();
        foreach ( $content_types->get() as $object )
            $values[ $object->name ] = $object->id;

        // Select only the fields for 2st step.
        $step_fields = array();
        foreach ( array( 'website','date_range', 'content_types' ) as $name )
            $step_fields[ $name ] = $fields[ $name ];

        $attrs = array(
            'website' => array(
                'values' => $this->config->item('newsletter_websites'),
                'help'   => lang('newsletter_website_help'),
            ),
            'date_range' => array(
                'help' => lang('newsletter_date_range_help'),
            ),
            'content_types' => array(
                'values' => $values,
                'help' => lang('newsletter_content_types_help'),
            )
        );

        return array_replace_recursive( $step_fields, $attrs );
    }

    /**
     * _confirmation_fields: Define the fields to be displayed in step 3 of newsletter form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $newsletter, [Required] Newsletter Object.
     * @return array
    **/
    private function _confirmation_fields( $newsletter ) 
    {
        // Get Newsletter base fields.
        $fields = $newsletter->validation;

        // Select only the fields for 3st step.
        $step_fields = array();
        foreach ( array( 'body' ) as $name )
            $step_fields[ $name ] = $fields[ $name ];

        $attrs = array();

        return array_replace_recursive( $step_fields, $attrs );
    }

}