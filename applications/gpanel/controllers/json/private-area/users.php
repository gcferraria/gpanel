<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends JSON_Controller {

    /**
     * index: Get Users.
     *
     * @access public
     * @return json
    **/
    public function index() {
        // Get all Users.
        $users = new User();

        // Define base columns
        $columns = array('name','email','creation_date','active_flag');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $users->or_like( array(
                    'name'     => $search_text,
                    'email'    => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $users->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $users->order_by('name');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $users->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $users as $user ) {
            $data[] = array(
                "DT_RowId" => $user->id,
                0 => '<a href="mailto:'.$user->email.'">'.$user->name.'</a>',
                1 => $user->email,
                2 => $user->creation_date,
                3 => ( $user->active_flag == 1 )
                        ? '<span class="label label-sm label-success">' . $this->lang->line('active')  . '</span>'
                        : '<span class="label label-sm label-danger">'  . $this->lang->line('inactive'). '</span>',
                4 => '<a href="'.site_url('private-area/users/edit/'. $user->id).'" class="btn default btn-xs green-meadow"><i class="fa fa-edit"></i> ' . $this->lang->line('edit') . '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $users->paged->total_rows,
                "iTotalDisplayRecords" => $users->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * add: Validate and Insert an User.
     *
     * @access public
     * @return json
    **/
    public function add() {

        // Inicialize User Object.
        $user = new User();

        $user->name             = $this->input->post('name');
        $user->email            = $this->input->post('email');
        $user->password         = $this->input->post('password');
        $user->confirm_password = $this->input->post('confirm_password');
        $user->active_flag      = $this->input->post('active_flag');

        // Validate User.
        $user->validate();

        // If User is valid insert the data.
        if ( $user->valid ) {

            $roles = array();
            if( is_array($this->input->post('roles') ) ) {
                foreach ( $this->input->post('roles')  as $role ) {
                    if( !empty($role) )
                        $roles[] = $role;
                }
            }

            // Save user and the related roles.
            if ( $user->save( array( 'roles' => $roles ) ) ) {
                $data = array(
                    'reset'        => 1,
                    'notification' => array('success', $this->lang->line('save_success_message') ),
                );
            }
        }
        else {

            $data = array(
                'show_errors'  => $user->errors->all,
                'notification' => array('error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * edit: Validate and Update User data.
     *
     * @access public
     * @param  int $id, [Required] User Id
     * @return json
    **/
    public function edit( $id ) {

        // Get User to edite.
        $user = new User();

         // Find User to Edit.
        $user->get_by_id( $id );

        $user->name        = $this->input->post('name');
        $user->email       = $this->input->post('email');
        $user->active_flag = $this->input->post('active_flag');

        // Validate User.
        $user->validate();

        // If User is valid updates the data.
        if ( $user->valid ) {

            $roles = array();
            if( is_array($this->input->post('roles') ) ) {
                foreach ( $this->input->post('roles')  as $role ) {
                    if( !empty($role) )
                        $roles[] = $role;
                }
            }

            // Save user and the related roles.
            if ( $user->save( array( 'roles' => $roles ) ) ) {
                $data = array(
                    'show_errors'  => array(),
                    'notification' => array('success', $this->lang->line('save_success_message') ),
                );
            }
        }
        else {
            $data = array(
                'show_errors'  => $user->errors->all,
                'notification' => array('error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * index: Change User Password.
     *
     * @access public
     * @param  int $id, [Required] User Id
     * @return json
    **/
    public function change_password( $id ) {

        // Get User to edit.
        $user = new User();

         // Find User to Edit.
        $user->get_by_id( $id );

        $user->password         = $this->input->post('password');
        $user->confirm_password = $this->input->post('confirm_password');

        // Validate User.
        $user->validate();

        // If User is valid, change the password.
        if ( $user->valid ) {

            if ( $user->save() ) {

                // Send email for user.
                $this->email->send_multipart = FALSE;
                $this->email->from( $this->config->item('noreply_email'), $this->config->item('noreply_name') );
                $this->email->to( $user->email );
                $this->email->subject( $this->lang->line('user_change_password_notif_subject') );
                $this->email->message(
                    $this->load->view('_templates/email/change_password',
                        array('username' => $user->email, 'password' => $this->input->post('password')),
                        true
                    )
                );
                $this->email->send();

                $data = array(
                    'reset' => 1,
                    'notification' => array('success', $this->lang->line('user_change_password_success_message') ),
                );
            }
        }
        else {
            $data = array(
                'show_errors'  => $user->errors->all,
                'notification' => array('error', $this->lang->line('user_change_password_error_message') ),
            );
        }

        parent::index( $data );
    }

}

/* End of file users.php */
/* Location: ./applications/gpanel/controllers/json/private-area/users.php */
