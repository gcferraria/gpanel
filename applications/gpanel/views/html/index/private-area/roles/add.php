<div class="portlet box grey-cascade" data-jsb-name="role" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user"></i> <?=$title?></div>
        <div class="tools">
            <a href="javascript:;" class="collapse" title="<?=$this->lang->line('collapse')?>" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
        </div>
    </div>
    <div class="portlet-body form" data-jsb-name="body" data-jsb-class="JsB">
      	<?=$role->form?>
    </div>
</div>
