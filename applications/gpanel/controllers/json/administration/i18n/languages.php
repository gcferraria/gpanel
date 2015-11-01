<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Languages Class
 *
 * @package    CodeIgniter
 * @subpackage Controllers
 * @uses       JSON_Controller
 * @category   i18n
 * @author     Gonçalo Ferraria <gferraria@gmail.com>
 * @copyright  2014 Gonçalo Ferraria
 * @version    1.0 Languages.php 2014-11-15 gferraria $
 */
class Languages extends JSON_Controller {

    /**
     * index: Get Languages.
     *
     * @access public
     * @return json
    **/
    public function index() {
        $languages = new I18n_Language();

        // Define List Columns.
        $columns = array('code','name','status','default');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $languages->or_like( array(
                    'name' => $search_text,
                    'code' => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) ) {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $languages->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $languages->order_by('name');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  )
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;

        $languages->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $languages as $language ) {
            $data[] = array(
                "DT_RowId" => $language->id,
                0 => $language->code,
                1 => $language->name,
                2 => ( $language->active == 1 )
                        ? '<span class="label label-sm label-success">'. $this->lang->line('active')  .'</span>'
                        : '<span class="label label-sm label-danger">' . $this->lang->line('inactive').'</span>',
                3 => ( $language->default == 1 )
                        ? '<span class="label label-sm label-success">'. $this->lang->line('yes')  .'</span>'
                        : '<span class="label label-sm label-info">' . $this->lang->line('no').'</span>',
                4 => '<a href="'.site_url('/administration/i18n/languages/edit/'. $language->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> '.
                     $this->lang->line('edit') . '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $languages->paged->total_rows,
                "iTotalDisplayRecords" => $languages->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * save: Validate and Save an I18n Language.
     *
     * @access public
     * @param  int $id, Language Id
     * @return json
    **/
    public function save( $id = null ) {
        $language = new I18n_Language();

        if( !is_null( $id ) )
            $language->get_by_id( $id );

        $language->code    = $this->input->post('code');
        $language->name    = $this->input->post('name');
        $language->default = $this->input->post('default');
        $language->active  = $this->input->post('active');
        $language->country = $this->input->post('country');

        if ( $language->save() ) {
            $data = array();
            if ( is_null( $id ) )
                $data['reset'] = 1;

            $data['notification'] = array( 'success', $this->lang->line('save_success_message') );
        }
        else {
            $data = array(
                'show_errors'  => $language->errors->all,
                'notification' => array( 'error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

}

/* End of file languages.php */
/* Location: ./applications/gpanel/controllers/json/administration/i18n/languages.php */
