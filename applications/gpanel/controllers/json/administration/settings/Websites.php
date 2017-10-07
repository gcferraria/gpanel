<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Websites Class
 *
 * @package    CodeIgniter
 * @subpackage Controllers
 * @uses       JSON_Controller
 * @category   Settings
 * @author     Gonçalo Ferraria <gferraria@gmail.com>
 * @copyright  2014 Gonçalo Ferraria
 * @version    1.0 websites.php 2014-11-24 gferraria $
 */
class Websites extends JSON_Controller {

    /**
     * index: Get Websites.
     *
     * @access public
     * @return json
    **/
    public function index( $data = array()) {
        $websites = new Settings_Website();

        // Define List Columns.
        $columns = array('name','domain');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $websites->or_like( array(
                    'name'   => $search_text,
                    'domain' => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) ) {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $websites->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $websites->order_by('name');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  )
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;

        $websites->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $websites as $website ) {
            $category = $website->category->get();
            $data[] = array(
                "DT_RowId" => $website->id,
                0 => $website->name,
                1 => $website->domain,
                2 => '<a href="'.site_url('/categories/contents/index/' . $category->id ) .'">' . $category->name . '</a>',
                3 => '<a href="'.site_url('/administration/settings/websites/edit/'. $website->id).'" class="btn btn-xs green-meadow"><i class="fa fa-edit"></i> '.
                     $this->lang->line('edit') . '</a>',
            );
        }

        parent::index(
            array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $websites->paged->total_rows,
                "iTotalDisplayRecords" => $websites->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            )
        );
    }

    /**
     * save: Validate and Save an Website.
     *
     * @access public
     * @param  int $id, Website Id
     * @return json
    **/
    public function save( $id = null ) {
        $website = new Settings_Website();

        if( !is_null( $id ) )
            $website->get_by_id( $id );

        $website->name        = $this->input->post('name');
        $website->domain      = $this->input->post('domain');
        $website->title       = $this->input->post('title');
        $website->description = $this->input->post('description');
        $website->keywords    = $this->input->post('keywords');

        // Validate Record.
        $website->validate();

        if( $website->valid ) {
            $data = array();

            // If is a new website, create the category for this website.
            if( is_null( $id ) ) {
                $category = new Category();

                // Set Category attributes.
                $category->parent_id    = 1;
                $category->name         = $website->name;
                $category->uriname      = str_replace('.','',extract_domain( $website->domain ));
                $category->description  = $website->description;
                $category->uripath      = '/sites/' . $category->uriname . '/';
                $category->creator_id   = $this->administrator->id;

                // Save Category.
                if ( $category->save() )
                    $website->category_id = $category->id;
                else
                    $data['notification'] = array( 'error', $this->lang->line('save_error_message') );
            }

            $languages = array();
            if( is_array($this->input->post('languages') ) ) {
                foreach ( $this->input->post('languages')  as $language ) {
                    if( !empty($language) )
                        $languages[] = $language;
                }
            }

            // Save website
            if ( $website->save( array('languages' => $languages ) ) && !isset( $data['notification'] ) ) {
                if ( is_null( $id ) )
                    $data['reset'] = 1;

                $data['notification'] = array( 'success', $this->lang->line('save_success_message') );
            }
            else
                $data['notification'] = array( 'error', $this->lang->line('unespected_error') );
        }
        else {
            $data = array(
                'show_errors'  => $website->errors->all,
                'notification' => array( 'error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

}

/* End of file websites.php */
/* Location: ./applications/gpanel/controllers/json/administration/settings/websites.php */
