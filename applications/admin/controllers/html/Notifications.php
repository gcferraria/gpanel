<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends HTML_Controller 
{
    /**
     * __construct: Notifications Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        // Add Breadcrumb for Notifications.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('notification_title'),
                'href' => 'notifications',
            )
        );
    }

    /**
     * index: Add Notifications data and render Notifications list page.
     *
     * @access public
     * @return void
    **/
    public function index( $template = 'index' ) 
    {
        $data = (object) array(
            'showAll' => true,
            'source'  => 'notifications.json',
            'header'  => array(
                $this->lang->line('notification_name'),
                $this->lang->line('notification_source'),
                $this->lang->line('notification_subject'),
                $this->lang->line('notification_creation_date'),
                $this->lang->line('notification_status'),
            ),
        );

        $this->add_data( array(
                'title'         => $this->lang->line('notification_title'),
                'table'         => $data,
                'table_actions' => array(
                    'read' => array(
                        'data-text'      => $this->lang->line('confirm_record'),
                        'url'            => 'notifications/read.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => $this->lang->line('notifications_mark_as_read'),
                        'icon'           => 'fa fa-envelope-o'
                    ),
                    'unread' => array(
                        'data-text'      => $this->lang->line('confirm_record'),
                        'url'            => 'notifications/unread.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => $this->lang->line('notifications_mark_as_unread'),
                        'icon'           => 'fa fa-envelope'
                    ),
                    'separator' => array(),
                    'delete' => array(
                        'data-text'      => $this->lang->line('confirm_record'),
                        'url'            => 'notifications/delete.json',
                        'data-jsb-class' => 'App.Portlet.Actions.Action',
                        'text'           => $this->lang->line('delete'),
                        'icon'           => 'fa fa-trash-o'
                    ),
                ),
            )
        );

        parent::index();
    }

    /**
     * open: Mark Notification as read and show notification body
     *
     * @access public
     * @param int $id, [Required] Notification Identifier.
     * @return void
    **/
    public function open( $id ) 
    {
        $notification = new Notification();

        // Get Notification to be opened.
        $notification->get_by_id( $id );

        if ( ! $notification->exists() )
            return;

        // Add Breadcrumb to open Notification.
        $this->breadcrumb->add( array(
                'text' => $notification->subject,
                'href' => uri_string(),
            )
        );

        // Mark Notification as read;
        $notification->status = 1;
        $notification->save();

        // Extract body only.
        preg_match('/<body>(.*)<\/body>/s', $notification->body, $matches);

        $this->add_data( array(
                'title' => $notification->subject,
                'notification' => (object) array(
                    'subject' => $notification->subject,
                    'body'    => $matches[0],
                )
            )
        );

        parent::index();
    }
}