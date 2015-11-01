<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrators extends JSON_Controller {

    /**
     * index: Get Administrators.
     *
     * @access public
     * @return json
    **/
    public function index() {

        // Get All Administrators.
        $administrators = new Administrator();

        // Define List Columns.
        $columns = array( 'name','username','creation_date','status');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $administrators->or_like( array(
                    'name'     => $search_text,
                    'username' => $search_text,
                    'email'    => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $administrators->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $administrators->order_by('name');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $administrators->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $administrators as $administrator ) {
            $data[] = array(
                "DT_RowId" => $administrator->id,
                0 => '<a href="mailto:'.$administrator->email.'">'.$administrator->name.'</a>',
                1 => $administrator->username,
                2 => $administrator->creation_date,
                3 => ( $administrator->active_flag == 1 )
                        ? '<span class="label label-sm label-success">' . $this->lang->line('active')   .'</span>'
                        : '<span class="label label-sm label-danger">'  . $this->lang->line('inactive') .'</span>',
                4 => '<a href="'.site_url('administration/administrators/edit/'. $administrator->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> ' . $this->lang->line('edit') . '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $administrators->paged->total_rows,
                "iTotalDisplayRecords" => $administrators->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * add: Validate and Insert Administrator.
     *
     * @access public
     * @return json
    **/
    public function add() {

        // Inicialize Administrator Object.
        $administrator = new Administrator;

        $administrator->name             = $this->input->post('name');
        $administrator->username         = $this->input->post('username');
        $administrator->password         = $this->input->post('password');
        $administrator->confirm_password = $this->input->post('confirm_password');
        $administrator->email            = $this->input->post('email');
        $administrator->sex              = $this->input->post('sex');
        $administrator->super_admin_flag = $this->input->post('super_admin_flag');
        $administrator->active_flag      = $this->input->post('active_flag');

        // If the Administrator is valid insert the data.
        if ( $administrator->save() ) {

            $data = array(
                'reset'        => 1,
                'notification' => array( 'success', $this->lang->line('save_success_message') ),
            );
        }
        else {

            $data = array(
                'show_errors'  => $administrator->errors->all,
                'notification' => array( 'error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * edit: Validate and Update Administrator.
     *
     * @access public
     * @param  int $id, [Required] Administrator Id
     * @return json
    **/
    public function edit( $id ) {

        // Inicialize Administrator Object.
        $administrator = new Administrator();

        // Find Administrator to Edit.
        $administrator->get_by_id( $id );

        $administrator->name             = $this->input->post('name');
        $administrator->username         = $this->input->post('username');
        $administrator->email            = $this->input->post('email');
        $administrator->sex              = $this->input->post('sex');
        $administrator->super_admin_flag = $this->input->post('super_admin_flag');
        $administrator->active_flag      = $this->input->post('active_flag');

        // If the Administrator is valid update the Administrator.
        if ( $administrator->save() ) {
            $data = array(
                'show_errors'  => array(),
                'notification' => array( 'success', $this->lang->line('save_success_message') ),
            );
        }
        else {

            $data = array(
                'show_errors' => $administrator->errors->all,
                'notification' => array( 'error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }
}

/* End of file administrators.php */
/* Location: ./applications/gpanel/controllers/json/administration/administrators.php */
