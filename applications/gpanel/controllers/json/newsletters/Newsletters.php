<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletters extends JSON_Controller 
{
    /**
     * __construct: JSON Newsletters Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();
        $this->load->config('newsletter');
    }

    /**
     * index: Get Newsletters.
     *
     * @access public
     * @return json
    **/
    public function index( $data = array() ) 
    {
        $newsletters = new Newsletter();
        $columns = array( 'name','creation_date' );

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) 
        {
            $newsletters->or_like( array(
                    'name' => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) 
            {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) 
                {
                    $newsletters->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else 
        {
            $newsletters->order_by('creation_date', 'desc');
        }

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) 
        {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $newsletters->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $newsletters as $newsletter ) 
        {
            $data[] = array(
                "DT_RowId" => $newsletter->id,
                0 => $newsletter->name,
                1 => $newsletter->creation_date,
                2 => '<a href="'. base_url('newsletters/newsletters/open/'. $newsletter->id).'.json" class="btn btn-xs blue-madison" data-toggle="modal" data-target="#newsletterModal">'
                    .'<i class="fa fa-search"></i> ' . $this->lang->line('open') . '</a> '
                    .'<a href="#" class="btn btn-xs red-sunglo" data-text="' . $this->lang->line('delete_record') . '" data-url="'.base_url('newsletters/newsletters/delete/' . $newsletter->id ).'.json"'
                    .' data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> ' . $this->lang->line('delete') .  '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $newsletters->paged->total_rows,
                "iTotalDisplayRecords" => $newsletters->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * add: Validate and Insert a Newsletter.
     *
     * @access public
     * @return json
    **/
    public function add() 
    {
        $data = array();

        // Inicialize Newsletter Object.
        $newsletter = new Newsletter();

		$types = $this->input->post('content_types');
		$range = $this->input->post('date_range');

        $newsletter->name          = $this->input->post('name');
        $newsletter->from          = $this->input->post('from');
        $newsletter->date_range    = $this->input->post('date_range');
        $newsletter->template      = $this->input->post('template');
        $newsletter->website       = $this->input->post('website');
        $newsletter->content_types = ( !empty( $types ) ) ? implode( ',', $types ) : '';
        $newsletter->body          = $this->input->post('body');
        $newsletter->body          = "<html><head><title>$newsletter->name</title></head><body>$newsletter->body</body></html>";
        $newsletter->creator_id    = $this->administrator->id;

        if ( !empty( $range ) ) 
        {
            $range = explode('/', $range);

            $newsletter->contents_start_date = trim( $range[0] );
            $newsletter->contents_end_date   = trim( $range[1] );
        }

        // Validate Newsletter.
        $newsletter->validate();

        $steps = $this->input->post('steps');
        $step  = $this->input->post('step');

        // If Newsletter is valid insert the data.
        if ( $newsletter->valid && $step == $steps ) {
            if ( $newsletter->save() ) 
            {
                // Find from name.
                $from_name;
                foreach ( $this->config->item('newsletter_from_emails') as $name => $value ) 
                {
                    if ( $value ==  $newsletter->from )
                        $from_name = $name;
                }

                // Get all active contacts.
                $newsletter_contact = new Newsletter_Contact();
                $newsletter_contact->where('active_flag', 1);

                // Send newsletter for all active contacts.
                foreach ( $newsletter_contact->get() as $contact ) 
                {
                    $this->email->send_multipart = FALSE;
                    $this->email->clear(TRUE);
                    $this->email->from( $newsletter->from, $from_name );
                    $this->email->to( $contact->email );
                    $this->email->subject( $newsletter->name );
                    $this->email->message( $newsletter->body );
                    $this->email->send();
                }

                $data = array(
                    'redirect' => array(
                        'url'      => site_url('newsletters/newsletters'),
                        'duration' => 200,
                    ),
                    'notification' => array('success', $this->lang->line('save_success_message') ),
                );
            }
            else 
            {
                $data = array( 'notification' => array('error', $this->lang->line('save_error_message') ) );
            }
        }
        else 
        {
            if ( $step == 1 )
                $fields = array('name','from','template');
            elseif ( $step == 2 )
                $fields = array('date_range','content_types');
            elseif ( $step == 3 )
                $fields = array('body');
            else
                return;

            //Get Fields Error Messages.
            $all    = $newsletter->errors->all;
            $errors = array();
            foreach ( $fields as $field ) 
            {
                if ( isset( $all[ $field ] ) )
                    $errors[ $field ] = strip_tags( $all[ $field ] );
            }

            if ( count( $errors ) > 0 ) 
            {
                $data = array(
                    'show_errors'  => $errors,
                    'notification' => array('error', $this->lang->line('newsletter_validation_errors'))
                );
            }
            elseif ( $step == 2 )
            {
                $data['$fields.$body.$field'] = $this->generate_template( $newsletter );
            }
        }

        parent::index( $data );
    }

    /**
     * open: Show newsletter body
     *
     * @access public
     * @param int $id, [Required] Newsletter Identifier.
     * @return text
    **/
    public function open( $id ) 
    {
        $newsletter = new Newsletter();

        // Get Newsletter to be opened.
        $newsletter->get_by_id( $id );

        if ( ! $newsletter->exists() )
            return;

        preg_match('/<body>(.*)<\/body>/s', $newsletter->body, $matches);

        $html = '
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">' . $newsletter->name . '</h4>
            </div>
            <div class="modal-body newsletter"><div class="te">' . $matches[0] . '</div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">' . $this->lang->line('close') . '</button>
            </div>
        ';

        print $html;
    }

    /**
     * delete: Delete a Newsletter.
     *
     * @access public
     * @param  int $id, Newsletter Id
     * @return json
    **/
    public function delete( $id ) 
    {
        $newsletter = new Newsletter();

        // Find Newsletter to be Deleted.
        $newsletter->get_by_id( $id );

        /*
          If Newslertter has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if ( $newsletter->delete() ) 
        {
            return parent::index(
                array(
                    'result'  => 1,
                    'message' => $this->lang->line('delete_success_message'),
                )
            );
        }
        else 
        {
            return parent::index(
                array(
                    'result'  => 0,
                    'message' => $this->lang->line('delete_error_message'),
                )
            );
        }
    }

    /**
     * generate_template: Generate newsletter body message based on template.
     *
     * @access private
     * @param  object $newsletter, Newsletter Object
     * @return json
    **/

    private function generate_template( $newsletter ) 
    {
        $data = array();

        // Load content based on selected content_types and data.
        if ( !empty( $newsletter->content_types ) ) 
        {
            foreach ( explode( ',', $newsletter->content_types ) as $content_type_id ) 
            {
                $content_type = new Content_Type();
                $content_type->get_by_id( $content_type_id );

                $contents = new Content();
                $contents
                    ->where_in_related( 'content_type', 'id' , $content_type_id )
                    ->where( array(
                            'publish_date >=' => date("Y-m-d H:i:s", strtotime( $newsletter->contents_start_date ) ), 
                            'publish_date <=' => date("Y-m-d H:i:s", strtotime( $newsletter->contents_end_date ) ),
                            'disable_date <'  => date("Y-m-d H:i:s"),
                            'publish_flag'    => 1,
                        )
                    )
                    ->like('uripath', $newsletter->website )
                    ->order_by('publish_date', 'desc');

                // Find website url name.
                $website_url;
                foreach ( $this->config->item('newsletter_websites') as $name => $value ) 
                {
                    if ( $value ==  $newsletter->website )
                        $website_url = $name;
                }

                $contents_data = array();
                foreach ( $contents->get() as $content ) 
                {
                    $temp = $content->__to_array();

                    // Build URL
                    $url  = preg_replace( '/\/sites\/(\w+)\//i', $website_url . '/', $temp['uripath']);
                    $url .= $temp['id'] . '/' . sanitize_string( $temp['title'] );
                    $temp['url'] = $url;

                    $contents_data[] = $temp; 
                }

                $data[ $content_type->uriname ] = $contents_data;
            }
        }

        return $this->load->view(
            $this->config->item('newsletter_templates_path') . '/' . $newsletter->template,
            $data,
            TRUE
        );

    }
}