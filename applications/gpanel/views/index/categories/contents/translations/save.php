<div class="portlet box grey-cascade" data-jsb-name="translation" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <img src="<?=$icon?>" alt="" /> <?=$title?></div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
        </div>
    </div>
    <div class="portlet-body form" data-jsb-name="body" data-jsb-class="JsB">
        <?=$form?>
    </div>
</div>

<?=$this->load->view('index/categories/contents/_upload', array( 'table' => $table ) )?>