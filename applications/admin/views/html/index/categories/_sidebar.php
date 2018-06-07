<div class="portlet light" data-jsb-name="categories" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption font-blue-sharp uppercase">
            <i class="icon-settings font-blue-sharp"></i> <?=$category_title?>
        </div>
        <div class="actions">
            <a href="javascript:;" class="btn btn-circle btn-icon-only btn-default reload" title="<?=$this->lang->line('reload')?>" data-jsb-name="reload" data-jsb-class="App.Portlet.Reload">
                <i class="icon-reload"></i>
            </a>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-category="<?=$category_selected?>" data-jsb-class="App.Tree">
    </div>
</div>
