<?php 
    echo 
        $this->load->view('html/portlets/bordered.php', array(
            'name'       => 'media',
            'icon'       => 'icon-picture',
            'beforeBody' => 
                '<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" data-jsb-name="uploader" data-jsb-url="' . base_url($uploader->url) .'" data-jsb-class="App.PlupUpload">
                    <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow-crusta">
                        <i class="fa fa-plus"></i> ' . $this->lang->line('media_select_files'). '
                    </a>
                    <a id="tab_images_uploader_uploadfiles" href="javascript:;" class="btn green-meadow">
                        <i class="fa fa-share"></i> ' . $this->lang->line('media_upload_files') . '
                    </a>
                </div>
                <div class="row">
                    <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12"></div>
                </div>'
            )
        ,true);
    ;
?>