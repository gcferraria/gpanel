<div class="portlet box grey-cascade" data-jsb-name="newsletter" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-envelope"></i><?=$title?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" title="<?=$this->lang->line('collapse')?>" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
            <a href="javascript:;" class="reload"   title="<?=$this->lang->line('reload')?>"   data-jsb-name="reload" data-jsb-class="App.Portlet.Reload"></a>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <?=$this->load->view('tables/datatable.php')?>
    </div>
</div>
<div class="modal fade" id="newsletterModal" tabindex="-1" role="dialog" aria-labelledby="NewsletterModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
