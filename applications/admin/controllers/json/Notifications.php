<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends JSON_Controller 
{
    /**
     * index: Get Notifications.
     *
     * @access public
     * @return json
    **/
    public function index( $data = array() ) 
    {
        $notifications = new Notification();
        $columns = array( 'id', 'name','source','subject','creation_date','status');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) 
        {
            $notifications->or_like( array(
                    'name'    => $search_text,
                    'email'   => $search_text,
                    'subject' => $search_text,
                    'body'    => $search_text,
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
                    $notifications->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else 
        {
            $notifications->order_by('status');
            $notifications->order_by('creation_date', 'desc');
        }

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) 
        {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $notifications->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $notifications as $notification ) 
        {
            $attach = '';
            if ( $notification->attach ) 
            {
                $file   = explode( '/', $notification->attach);
                $attach = '<a href="' . $this->config->item('download_url') . end( $file ) . '" title="' . lang('download') . '" target="_blank" class="btn default btn-xs black"><i class="fa fa fa-file-pdf-o"></i></a> '; 
            }

            $data[] = array(
                "DT_RowId" => $notification->id,
                0 => 
                    '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" value="'.$notification->id.'" data-jsb-class="CheckBox" />
                        <span></span>
                    </label>',
                1 => '<a href="mailto:'.strtolower($notification->email).'">'.word_limiter( $notification->name, 10 ).'</a>',
                2 => $notification->source,
                3 => word_limiter( $notification->subject, 10 ),
                4 => $notification->creation_date,
                5 => ( $notification->status == 1 )
                        ? '<span class="label label-sm label-success"><i class="fa fa-envelope-o"></i> ' . lang('read')   . '</span>'
                        : '<span class="label label-sm label-warning"><i class="fa fa-envelope"></i> '   . lang('pendent'). '</span>',
                6 => $attach . '
                    <a href="' . site_url('notifications/open/'. $notification->id) . '" class="btn btn-xs blue-madison"><i class="fa fa-search"></i> ' 
                        . lang('open') . 
                    '</a>
                    <a href="#" class="btn btn-xs red-sunglo" data-text="' . lang('delete_record') . '" data-url="'.base_url('notifications/delete/' . $notification->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> ' 
                        . lang('delete') . 
                    '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $notifications->paged->total_rows,
                "iTotalDisplayRecords" => $notifications->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * delete: Delete Notifications.
     *
     * @access public
     * @return json
    **/
    public function delete( $id = null ) 
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

        // Find Notifications to be Deleted.
        $notifications = new Notification();
        $notifications->where_in( 'id', $ids )->get();

        /*
            If the Notifications has been deleted successfully, updates the list,
            otherwise shows an unexpected error.
        */
        if( $notifications->delete_all() ) 
        {
            return parent::index(
                array(
                    'root.$notifications.$notifications.$reload.click' => 1,
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
     * read: Mark notifications as read
     *
     * @access public
     * @return json 
     */  
    public function read()
    {
        $rows = $this->input->post('rows');
        if ( isset($rows) && !empty($rows)) 
        {
            $ids = array();
            foreach ($rows as $row) 
            {
                foreach ($row as $key => $value)
                    $ids[] = $value;
            }

            // Find Notifications to be Marked as Read.
            $notifications = new Notification();
            $notifications->where_in( 'id', $ids )->get();

            /*
                If the Notification(s) has been marked as read with successfully, updates the list,
                otherwise shows an unexpected error.
            */
            if ( $notifications->update_all('status', 1) ) 
            {
                return parent::index(
                    array(
                        'root.$notification.$value.update'  => $notifications->get_unread_messages_number(),
                        'root.$notifications.$notifications.$reload.click' => 1,
                        'notification' => array('success', lang('read_success_message') ),
                    )
                );

                $notifications->refresh_all();
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
     * read: Mark notifications as unread
     *
     * @access public
     * @return json 
     */  
    public function unread()
    {
        $rows = $this->input->post('rows');
        if ( isset($rows) && !empty($rows)) 
        {
            $ids = array();
            foreach ($rows as $row) 
            {
                foreach ($row as $key => $value)
                    $ids[] = $value;
            }

            // Find Notifications to be Marked as Read.
            $notifications = new Notification();
            $notifications->where_in( 'id', $ids )->get();

            /*
                If the Notification(s) has been marked as read with successfully, updates the list,
                otherwise shows an unexpected error.
            */
            if ( $notifications->update_all('status', 0) ) 
            {
                return parent::index(
                    array(
                        'root.$notification.$value.update'  => $notifications->get_unread_messages_number(),
                        'root.$notifications.$notifications.$reload.click' => 1,
                        'notification' => array('success', lang('unread_success_message') ),
                    )
                );

                $notifications->refresh_all();
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