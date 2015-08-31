<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends HTML_Controller {

    /**
     * __construct: Media Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {

        // Call parent constructor.
        parent::__construct( 'restrict' );

        // Add Media Breadcrumb.
        $this->breadcrumb->add( array(
                    'text' => $this->lang->line('media_breadcrumb'),
                    'href' => 'media',
                )
            );
    }

    /**
     * index: Add Media data, define media actions and render Media List page.
     *
     * @access public
     * @return void
    **/
    public function index() {

        $data = (object) array(
                'source' => 'media.json',
                'header' => array(
                    $this->lang->line('file_file'),
                    $this->lang->line('file_name'),
                    $this->lang->line('file_filename'),
                    $this->lang->line('file_filetype'),
                    $this->lang->line('file_extension'),
                    $this->lang->line('file_filesize'),
                    $this->lang->line('file_creation_date'),
                ),
            );

        $this->add_data( array(
                    'title' => $this->lang->line('media_title'),
                    'uploader' => (object) array(
                        'url' => 'media/upload.json'
                    ),
                    'table' => $data,
                )
            );

        parent::index();
    }
}

/* End of file media.php */
/* Location: ../applications/gpanel/controllers/media.php */