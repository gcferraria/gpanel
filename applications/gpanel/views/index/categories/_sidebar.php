<div class="portlet blue-hoki box" data-jsb-name="categories" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i> <?=$category_title?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" title="<?=$this->lang->line('collapse')?>" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
            <a href="javascript:;" class="reload"   title="<?=$this->lang->line('reload')?>"   data-jsb-name="reload"   data-jsb-class="App.Portlet.Reload"></a>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-category="<?=$category_selected?>" data-jsb-class="App.Tree">
    </div>
</div>
