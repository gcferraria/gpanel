<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber extends JSON_Controller {

    /**
     * index: Get subscriber list.
     *
     * @access public
     * @return json
    **/
    public function index( $data = array() ) 
    {
        $subscribers = new Newsletter_Subscriber();
        $columns = array( 'email','name','source','creation_date','active_flag');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if( !empty($search_text) ) 
        {
            $subscribers->or_like( array(
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
                    $subscribers->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else 
        {
            $subscribers->order_by('creation_date', 'desc');
        }

        // Pagination
        $page = 1;
        if( $this->input->post('iDisplayStart') > 0  ) 
        {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $subscribers->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach( $subscribers as $subscriber ) 
        {
            $status = '';
            switch( $subscriber->active_flag ) 
            {
                case 0 : $status = '<a class="label label-sm label-danger"  title="'. lang('activate')   .'" data-jsb-class="Tooltip">' . lang('inactive'). '</a>';
                case 1 : $status = '<a class="label label-sm label-success" title="'. lang('inactivate') .'" data-jsb-class="Tooltip">' . lang('active')  . '</a>';
                default: $status = '<a class="label label-sm label-warning" title="'. lang('pending')    .'" data-jsb-class="Tooltip">' . lang('pending') . '</a>';
            }

            $data[] = array(
                "DT_RowId" => $subscriber->id,
                0 => 
                    '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" value="' . $subscriber->id . '" data-jsb-class="CheckBox" />
                        <span></span>
                    </label>', 
                1 => '<a href="mailto:' . strtolower( $subscriber->email ) . '">' . word_limiter( $subscriber->email, 10 ) . '</a>',
                2 => $subscriber->name,
                3 => $subscriber->source,
                4 => $subscriber->creation_date,
                5 => $status,
                6 => '
                    <a href="'.site_url('newsletters/subscriber/save/' . $subscriber->id) .'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> ' 
                        . lang('edit') .  
                    ' </a>
                    <a href="#" class="btn btn-xs red-sunglo" 
                        data-text="' . lang('delete_record') . '" 
                        data-url="' . base_url('newsletters/subscriber/delete/' . $subscriber->id ) . '.json" 
                        data-jsb-class="App.DataTable.Delete">
                            <i class="fa fa-trash-o"></i> ' . lang('delete') . 
                    '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $subscribers->paged->total_rows,
                "iTotalDisplayRecords" => $subscribers->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * save: Save a subscriber.
     *
     * @access public
     * @param  int $id, [Required] subscriber identifier to be saved
     * @return json
    **/
    public function save( $id ) 
    {
        // Initialize subscriber object.
        $subscriber = new Newsletter_Subscriber();

        // Find subscriber to edit.
        $subscriber->get_by_id( $id );

        // Set subscriber properties
        $subscriber->name        = $this->input->post('name');
        $subscriber->active_flag = $this->input->post('active_flag');

        // If the subscriber is valid and exists, update the record.
        if( $subscriber->save() ) 
        {
            $data = array(
                'show_errors'  => array(),
                'notification' => array('success', lang('save_success_message') ),
            );
        }
        else 
        {
            $data = array(
                'show_errors'  => $subscriber->errors->all,
                'notification' => array('error', lang('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * delete: Delete a subscriber.
     *
     * @access public
     * @param  int $id, [Optional] subscriber identifier to be deleted.
     * @return json
    **/
    public function delete( $id = NULL ) 
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

        // Initialize subscriber object.
        $subscriber = new Newsletter_Subscriber();

        // Find subscribers to be deleted.
        $subscriber->where_in( 'id', $ids )->get();

        /*
          If the subscriber has been deleted successfully updates the list,
          otherwise shows an unexpected error.
        */
        if( $subscriber->delete_all() ) 
        {
            return parent::index(
                array(
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
     * read: Activate Subscriber List
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

            // Find Subscribers to be Activated.
            $subscriber = new Newsletter_Subscriber();
            $subscriber->where_in( 'id', $ids )->get();

            if( $subscriber->update_all('active_flag', 1) ) 
            {
                return parent::index(
                    array(
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
     * read: Inactivate Subscriber list
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

            // Find Subscribers to be Inactivated.
            $subscriber = new Newsletter_Subscriber();
            $subscriber->where_in( 'id', $ids )->get();

            if( $subscriber->update_all('active_flag', 0) ) 
            {
                return parent::index(
                    array(
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