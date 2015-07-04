<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends JSON_Controller {

    /**
     * __construct: Ajax Roles Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct( 'restrict' );
    }

    /**
     * index: Get Roles.
     *
     * @access public
     * @return json
    **/
    public function index() {

        // Get all Roles.
        $roles = new Role();

        // Define base columns
        $columns = array('name','creation_date','active_flag');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $roles->or_like( array(
                    'name' => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $roles->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $roles->order_by('name');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $roles->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $roles as $role ) {
            $data[] = array(
                "DT_RowId" => $role->id,
                0 => $role->name,
                1 => $role->creation_date,
                2 => ( $role->active_flag == 1 )
                        ? '<span class="label label-success">Activo</span>'
                        : '<span class="label label-danger">Inactivo</span>',
                3 => '<a href="'.site_url('roles/edit/' . $role->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> Editar</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $roles->paged->total_rows,
                "iTotalDisplayRecords" => $roles->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * add: Validate and Insert a Role.
     *
     * @access public
     * @return json
    **/
    public function add() {

        // Inicialize Role Object.
        $role = new Role();

        $role->name        = $this->input->post('name');
        $role->key_match   = $this->input->post('key_match');
        $role->active_flag = $this->input->post('active_flag');

        // If Role is valid insert the data.
        if ( $role->save() ) {

            $data = array(
                'reset'        => 1,
                'notification' => array('success', $this->lang->line('role_insert_success_message') ),
            );
        }
        else {

            $data = array(
                'show_errors'  => $role->errors->all,
                'notification' => array('error', $this->lang->line('role_insert_error_message') ),
            );
        }

        parent::index( $data );
    }

    /**
     * edit: Validate and Update a Role.
     *
     * @access public
     * @param  int $id, [Required] Role Id
     * @return json
    **/
    public function edit( $id ) {

        // Get Role to edite.
        $role = new Role();

         // Find Role to Edit.
        $role->get_by_id( $id );

        $role->name        = $this->input->post('name');
        $role->key_match   = $this->input->post('key_match');
        $role->active_flag = $this->input->post('active_flag');

        // If Role is valid updates the data.
        if ( $role->save() ) {
            $data = array(
                'show_errors'  => array(),
                'notification' => array('success', $this->lang->line('role_update_success_message') ),
            );
        }
        else {
            $data = array(
                'show_errors'  => $role->errors->all,
                'notification' => array( 'error', $this->lang->line('role_update_error_message') ),
            );
        }

        parent::index( $data );
    }

}

/* End of file users.php */
/* Location: ./applications/gpanel/controllers/json/users.php */
