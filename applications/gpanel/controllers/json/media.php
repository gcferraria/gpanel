<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends GP_Controller {

    /**
     * index: Get Media Files.
     *
     * @access public
     * @return json
    **/
    public function index() {

        // Check if is an ajax request.
        if ( ! $this->input->is_ajax_request() ) {

            log_message(
                'error',
                'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                'Access not allowed.'
            );

            show_error('Access not allowed', 500);
        }

        $this->load->helper('number');

        // Get Static URL.
        $static_url = $this->config->item('static_url');

        $files = new File();
        $columns = array( 'name','name','filename','filetype','extension', 'filesize', 'creation_date');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $files->or_like( array(
                    'name'     => $search_text,
                    'filename' => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $files->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $files->order_by('id DESC');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $files->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $files as $file ) {
            $filetype = $file->filetype;
            $filetype = str_replace( '/', '_', $filetype );

            // Define target for link
            $target = ( $file->is_image ) ? '' : 'target="_blank"';

            // If is image show the image, otherwise show default image based on extension.
            $image = $file->is_image
                ? $static_url . $file->filename
                : base_url('/images/default_' . $filetype . '.png');

            $data[] = array(
                "DT_RowId" => $file->id,
                0 => '<a href="'.$static_url . $file->filename.'" '.$target.' data-jsb-class="App.Fancybox" class="file"><img src="'.$image.'" alt="'.$file->filename.'"  class="img-responsive" /></a>',
                1 => $file->name,
                2 => $file->filename,
                3 => $file->filetype,
                4 => $file->extension,
                5 => byte_format( $file->filesize * 1000 ),
                6 => $file->creation_date,
                7 => '<a href="'.$static_url . $file->filename.'" '.$target.' data-jsb-class="App.Fancybox" class="btn btn-xs blue-madison"><i class="fa fa-search"></i> ' . $this->lang->line('open') . '</a>
                      <a href="#" class="btn btn-xs red-sunglo" data-text="' . $this->lang->line('delete_record') . '" data-url="'.base_url('media/delete/' . $file->id ).'.json" data-jsb-class="App.DataTable.Delete"><i class="fa fa-trash-o"></i> ' . $this->lang->line('delete') . '</a>',
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output( json_encode( array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $files->paged->total_rows,
                "iTotalDisplayRecords" => $files->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            ) ) );
    }

    /**
     * index: Get Media Files for list in Modal Selection Files.
     *
     * @access public
     * @return json
    **/
    public function modal() {

        // Check if is an ajax request.
        if ( ! $this->input->is_ajax_request() ) {

            log_message(
                'error',
                'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                'Access not allowed.'
            );

            show_error('Access not allowed', 500);
        }

        $this->load->helper('number');

        // Get Static URL.
        $static_url = $this->config->item('static_url');

        $files = new File();
        $columns = array( 'name','filename','filetype','extension', 'filesize');

        // Add Search Text if defined.
        $search_text = $this->input->post('sSearch');
        if ( !empty( $search_text ) ) {
            $files->or_like( array(
                    'name'     => $search_text,
                    'filename' => $search_text,
                )
            );
        }

        // Order By.
        if ( isset( $_POST['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i < intval( $this->input->post('iSortingCols') ) ; $i++ ) {
                if ( $this->input->post('bSortable_' . $this->input->post('iSortCol_' . $i) ) == "true" ) {
                    $files->order_by($columns[ intval( $this->input->post('iSortCol_'.$i) ) ], $this->input->post('sSortDir_'.$i) );
                }
            }
        }
        else
            $files->order_by('id DESC');

        // Pagination
        $page = 1;
        if ( $this->input->post('iDisplayStart') > 0  ) {
            $page = ceil( $this->input->post('iDisplayStart') / $this->input->post('iDisplayLength')  ) + 1;
        }

        $files->get_paged( $page, $this->input->post('iDisplayLength') );

        $data = array();
        foreach ( $files as $file ) {

            $filetype = $file->filetype;
            $filetype = str_replace( '/', '_', $filetype );

            $data[] = array(
                "DT_RowId" => $file->id,
                0 => '<input type="checkbox" name="id[]" data-url="'.$static_url . $file->filename.'" value="'. $file->filename .'" data-jsb-class="CheckBox" />',
                1 => $file->name,
                2 => $file->filename,
                3 => $file->filetype,
                4 => $file->extension,
                5 => byte_format( $file->filesize * 1000 ),
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output( json_encode( array(
                "sEcho"                => $this->input->post('sEcho'),
                "iTotalRecords"        => $files->paged->total_rows,
                "iTotalDisplayRecords" => $files->paged->total_rows,
                "aaData"               => $data,
                "page"                 => $page
            ) ) );
    }

    /**
     * upload: Validate and Insert Media Files.
     *
     * @access public
     * @return json
    **/
    public function upload() {

        // Inicialize Media File Object.
        $file = new File();

        $filename = isset( $_POST['element'] )
            ? $this->input->post('element')
            : 'file';

        // Validate the File.
        $this->upload->do_upload( $filename );

        // If the File is valid insert the data.
        if ( sizeof ( $this->upload->error_msg ) == 0 ) {

            // Get Upload Data.
            $upload = $this->upload->data();

            $name = sizeof( $this->input->post('name') == 0 )
                ? $upload['raw_name']
                : $this->input->post('name');

            // Set file Attributes
            $file->name          = $name;
            $file->filename      = $upload['file_name'];
            $file->filetype      = $upload['file_type'];
            $file->filepath      = $upload['file_path'];
            $file->fullpath      = $upload['full_path'];
            $file->raw_name      = $upload['raw_name'];
            $file->original_name = $upload['orig_name'];
            $file->client_name   = $upload['client_name'];
            $file->extension     = $upload['file_ext'];
            $file->filesize      = $upload['file_size'];
            $file->is_image      = $upload['is_image'];
            $file->image_width   = $upload['image_width'];
            $file->image_height  = $upload['image_height'];
            $file->image_type    = $upload['image_type'];

            // Save File.
            if ( $file->save() ) {
                $data = array(
                    'result'   => 1,
                    'filename' => $file->filename,
                    'url'      => $this->config->item('static_url') . $file->filename,
                );
            }
            else
                $data = array( 'result' => 0, 'error' => $this->lang->line('unespected_error') );
        }
        else {
            if ( sizeof ( $this->upload->error_msg ) > 0 )
                $error = $this->upload->error_msg[0];

            $data = array( 'result' => 0, 'error' => $error );
        }

        $this->output->set_output( json_encode( $data ) );
    }

    /**
     * delete: Delete an Media File.
     *
     * @access public
     * @param  int $id, Media File id
     * @return json
    **/
    public function delete( $id ) {
         // Check if is an ajax request.
        if ( ! $this->input->is_ajax_request() ) {

            log_message(
                'error',
                'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                'Access not allowed.'
            );

            show_error('Access not allowed', 500);
        }

        $this->load->helper('file');

        // Inicialize File Object.
        $file = new File();

        // Find File to Delete.
        $file->get_by_id( $id );

        // Get File FullPath to delete from the filesystem.
        $fullpath = $file->fullpath;

        /*
          If File has been deleted successfully updates the list and delete file
          from filesystem, otherwise shows an unexpected error.
        */
        $data = array();
        if ( $file->delete() ) {

            // Delete file from the filesystem if exists.
            if( get_file_info( $fullpath ) != FALSE )
                delete_files( $fullpath );

            $data =  array(
                'result'  => 1,
                'message' => $this->lang->line('delete_success_message'),
            );
        }
        else {
            $data = array(
                'result'  => 0,
                'message' => $this->lang->line('delete_error_message'),
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output( json_encode( $data ) );
    }

}

/* End of file media.php */
/* Location: ./applications/gpanel/controllers/json/media.php */
