<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_Contacts extends JSON_Controller {

    /**
     * __construct: JSON Newsletter Contacts Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct( 'restrict' );
    }

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
                     ? '<span class="label label-success">Activo</span>'
                     : '<span class="label label-danger">Inactivo</span>',
                5 => '<a href="'.site_url('newsletter_contacts/edit/'. $contact->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> Editar</a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="Tem a certeza que pretende apagar o registo?" data-url="'.base_url('newsletter_contacts/delete/' . $contact->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> Apagar</a>',
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
                'notification' => array('success', $this->lang->line('newsletter_contact_update_success_message') ),
            );
        }
        else {
            $data = array(
                'show_errors'  => $newsletter_contact->errors->all,
                'notification' => array('error', $this->lang->line('newsletter_contact_update_error_message') ),
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
                    'message' => 'O Contacto foi apagado com sucesso.',
                )
            );
        }
        else {
            return parent::index(
                array(
                    'result'  => 0,
                    'message' => 'Não foi possível apagar o contacto. Contacte o Administrador do Sistema.',
                )
            );
        }
    }

}

/* End of file newsletter_contacts.php */
/* Location: ./applications/gpanel/controllers/json/newsletter_contacts.php */
