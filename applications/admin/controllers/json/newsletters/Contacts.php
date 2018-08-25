<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends JSON_Controller {

    /**
     * index: Get Newsletter Contacts.
     *
     * @access public
     * @return json
    **/
    public function index( $data = array() ) 
    {
        $newsletter_contacts = new Newsletter_Contact();
        $columns = array( 'email','name','source','creation_date','active_flag');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if( !empty($search_text) ) 
        {
            $newsletter_contacts->or_like( array(
                    'name'    => $search_text,
                    'email'   => $search_text,
                )
            );
        }

        // Order By.
        if( isset($_POST['iSortCol_0']) )
        {
            for( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) 
            {
                if( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) 
                {
                    $newsletter_contacts->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else 
        {
            $newsletter_contacts->order_by('creation_date', 'desc');
        }

        // Pagination
        $page = 1;
        if( $this->input->post('iDisplayStart') > 0  ) 
        {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $newsletter_contacts->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach( $newsletter_contacts as $contact ) 
        {
            $data[] = array(
                "DT_RowId" => $contact->id,
                0 => 
                    '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" value="'.$contact->id.'" data-jsb-class="CheckBox" />
                        <span></span>
                    </label>', 
                1 => '<a href="mailto:' . strtolower( $contact->email ) . '">' . word_limiter( $contact->email, 10 ) . '</a>',
                2 => $contact->name,
                3 => $contact->source,
                4 => $contact->creation_date,
                5 => ( $contact->active_flag == 1 )
                    ? '<a class="label label-sm label-success" title="'. lang('inactivate') .'" data-jsb-class="Tooltip">' . lang('active')  . '</a>'
                    : '<a class="label label-sm label-danger"  title="'. lang('activate')   .'" data-jsb-class="Tooltip">' . lang('inactive'). '</a>',
                6 => '
                    <a href="'.site_url('newsletters/contacts/save/' . $contact->id) .'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> ' 
                        . lang('edit') .  
                    ' </a>
                    <a href="#" class="btn btn-xs red-sunglo" 
                        data-text="' . lang('delete_record') . '" 
                        data-url="' . base_url('newsletters/contacts/delete/' . $contact->id ) . '.json" 
                        data-jsb-class="App.DataTable.Delete">
                            <i class="fa fa-trash-o"></i> ' . lang('delete') . 
                    '</a>',
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
    public function save( $id ) 
    {
        // Initialize newsletter contact object.
        $newsletter_contact = new Newsletter_Contact();

        // Find contact to edit.
        $newsletter_contact->get_by_id( $id );

        // Set contact properties
        $newsletter_contact->name        = $this->input->post('name');
        $newsletter_contact->active_flag = $this->input->post('active_flag');

        // If the contact is valid and exists, update the record.
        if( $newsletter_contact->save() ) 
        {
            $data = array(
                'show_errors'  => array(),
                'notification' => array('success', lang('save_success_message') ),
            );
        }
        else 
        {
            $data = array(
                'show_errors'  => $newsletter_contact->errors->all,
                'notification' => array('error', lang('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * delete: Delete a newsletter contacts.
     *
     * @access public
     * @param  int $id, Contact identifier to be deleted.
     * @return json
    **/
    public function delete( $id = NULL) 
    {
        $ids = array();
        $rows = $this->input->post('rows');
        if( isset($rows) && !empty($rows) ) 
        {
            foreach( $rows as $row ) 
            {
                foreach( $row as $key => $value )
                {
                    $ids[] = $value;
                }
            }
        } 
        else 
        {
            $ids[] = $id;
        }

        // Initialize newsletter contact object.
        $newsletter_contact = new Newsletter_Contact();

        // Find contact to be deleted.
        $newsletter_contact->where_in( 'id', $ids )->get();

        /*
          If the contact has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if( $newsletter_contact->delete_all() ) 
        {
            return parent::index(
                array(
                    'root.$newsletters.$contacts.$reload.click' => 1,
                    'notification' => array('success', lang('delete_success_message') ),
                )
            );
        }
        else
        {
            return parent::index(
                array(
                    'notification' => array('error', lang('delete_error_message') ),
                )
            );
        }
    }

    /**
     * read: Activate Newsletter Contacts
     *
     * @access public
     * @return json 
     */  
    public function activate()
    {
        $rows = $this->input->post('rows');
        if( isset($rows) && !empty($rows)) 
        {
            $ids = array();
            foreach($rows as $row) 
            {
                foreach ($row as $key => $value)
                    $ids[] = $value;
            }

            // Find Contacts to be Activated.
            $newsletter_contact = new Newsletter_Contact();
            $newsletter_contact->where_in( 'id', $ids )->get();

            if( $newsletter_contact->update_all('active_flag', 1) ) 
            {
                return parent::index(
                    array(
                        'root.$newsletters.$contacts.$reload.click' => 1,
                        'notification' => array('success', lang('activate_success_message') ),
                    )
                );
            }
            else 
            {
                return parent::index(
                    array(
                        'notification' => array('error', lang('unespected_error') ),
                    )
                );
            }
        }
        else 
        {
            return parent::index(
                array(
                    'notification' => array('error', lang('please_select_record') ),
                )
            );
        }
    }

    /**
     * read: Inactivate Newsletter Contacts
     *
     * @access public
     * @return json 
     */  
    public function inactivate()
    {
        $rows = $this->input->post('rows');
        if( isset($rows) && !empty($rows)) 
        {
            $ids = array();
            foreach($rows as $row) 
            {
                foreach ($row as $key => $value)
                    $ids[] = $value;
            }

            // Find Contacts to be Activated.
            $newsletter_contact = new Newsletter_Contact();
            $newsletter_contact->where_in( 'id', $ids )->get();

            if( $newsletter_contact->update_all('active_flag', 0) ) 
            {
                return parent::index(
                    array(
                        'root.$newsletters.$contacts.$reload.click' => 1,
                        'notification' => array('success', lang('inactivate_success_message') ),
                    )
                );
            }
            else 
            {
                return parent::index(
                    array(
                        'notification' => array('error', lang('unespected_error') ),
                    )
                );
            }
        }
        else 
        {
            return parent::index(
                array(
                    'notification' => array('error', lang('please_select_record') ),
                )
            );
        }
    }

}