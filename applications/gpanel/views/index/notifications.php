<div class="portlet box grey-cascade" data-jsb-name="notifications" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-bullhorn"></i><?=$title?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" title="<?=$this->lang->line('collapse')?>" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
            <a href="javascript:;" class="reload"   title="<?=$this->lang->line('reload')?>"   data-jsb-name="reload"   data-jsb-class="App.Portlet.Reload"></a>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <button class="btn dropdown-toggle green-meadow" data-toggle="dropdown">
                            <i class="fa fa-cogs"></i>
                            <?=$this->lang->line('operations')?> <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right" data-jsb-name="actions" data-jsb-type="context" data-jsb-class="App.Portlet.Actions">
                            <li>
                                <a href="javascript:;" 
                                   data-text="<?=$this->lang->line('confirm_record')?>" 
                                   data-url="<?=base_url('notifications/read.json')?>"
                                   data-jsb-name="read"
                                   data-jsb-class="App.Portlet.Actions.Read">
                                    <?=$this->lang->line('notifications_mark_as_read')?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?=$this->load->view('tables/datatable.php')?>
    </div>
</div>