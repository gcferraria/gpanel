<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends JSON_Controller {

    /**
     * index: Get Newsletter Contacts.
     *
     * @access public
     * @return json
    **/
    public function index() {
        $newsletter_contacts = new Newsletter_Contact();
        $columns = array( 'email','name','source','creation_date','active_flag');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $newsletter_contacts->or_like( array(
                    'name'    => $search_text,
                    'email'   => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $newsletter_contacts->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else {
            $newsletter_contacts->order_by('creation_date', 'desc');
        }

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $newsletter_contacts->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $newsletter_contacts as $contact ) {

            $data[] = array(
                "DT_RowId" => $contact->id,
                0 => '<a href="mailto:' . strtolower( $contact->email ) . '">' . word_limiter( $contact->email, 10 ) . '</a>',
                1 => $contact->name,
                2 => $contact->source,
                3 => $contact->creation_date,
                4 => ( $contact->active_flag == 1 )
                     ? '<span class="label label-sm label-success">' . $this->lang->line('active')  . '</span>'
                     : '<span class="label label-sm label-danger">'  . $this->lang->line('inactive'). '</span>',
                5 => '<a href="'.site_url('newsletters/contacts/edit/'. $contact->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> ' . $this->lang->line('edit') .  ' </a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="' . $this->lang->line('delete_record') . '" data-url="'.base_url('newsletters/contacts/delete/' . $contact->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> ' . $this->lang->line('delete') . '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $newsletter_contacts->paged->total_rows,
                "iTotalDisplayRecords" => $newsletter_contacts->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * edit: Validate and Update a Newsletter Contact.
     *
     * @access public
     * @param  int $id, [Required] Newsletter Contact Id
     * @return json
    **/
    public function edit( $id ) {
        $newsletter_contact = new Newsletter_Contact();

        // Find Newsletter Contact to Edit.
        $newsletter_contact->get_by_id( $id );

        $newsletter_contact->name        = $this->input->post('name');
        $newsletter_contact->active_flag = $this->input->post('active_flag');

        // If the Newsletter Contact is valid update the Record.
        if ( $newsletter_contact->save() ) {

            $data = array(
                'show_errors'  => array(),
                'notification' => array('success', $this->lang->line('save_success_message') ),
            );
        }
        else {
            $data = array(
                'show_errors'  => $newsletter_contact->errors->all,
                'notification' => array('error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * delete: Delete a Newsletter Contact.
     *
     * @access public
     * @param  int $id, Newsletter Contact Id
     * @return json
    **/
    public function delete( $id ) {
        $newsletter_contact = new Newsletter_Contact();

        // Find Newsletter Contact to be Deleted.
        $newsletter_contact->get_by_id( $id );

        /*
          If Newslertter Contact has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if ( $newsletter_contact->delete() ) {
            return parent::index(
                array(
                    'result'  => 1,
                    'message' => $this->lang->line('delete_success_message'),
                )
            );
        }
        else {
            return parent::index(
                array(
                    'result'  => 0,
                    'message' => $this->lang->line('delete_error_message'),
                )
            );
        }
    }

}

/* End of file contacts.php */
/* Location: ./applications/gpanel/controllers/json/newsletters/contacts.php */
