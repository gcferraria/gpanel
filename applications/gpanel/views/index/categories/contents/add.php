<div class="portlet box grey-cascade" data-jsb-name="content" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-globe"></i> <?=$title?></div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
        </div>
    </div>
    <div class="portlet-body form" data-jsb-name="body" data-jsb-class="JsB">
        <?=$content->form?>
    </div>
</div>

<?=$this->load->view('index/categories/contents/_upload', array( 'table' => $table ) )?>