<div class="portlet box grey-cascade" data-jsb-name="media" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-files-o"></i><?=$title?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
            <a href="javascript:;" class="reload" data-jsb-name="reload" data-jsb-class="App.Portlet.Reload"></a>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" data-jsb-name="uploader" data-jsb-url="<?=base_url($uploader->url)?>" data-jsb-class="App.PlupUpload">
            <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow-crusta">
                <i class="fa fa-plus"></i> Seleccionar Ficheiros
            </a>
            <a id="tab_images_uploader_uploadfiles" href="javascript:;" class="btn green-meadow">
                <i class="fa fa-share"></i> Upload dos Ficheiros
            </a>
        </div>
        <div class="row">
            <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12"></div>
        </div>
        <?=$this->load->view('tables/datatable.php')?>
    </div>
</div>