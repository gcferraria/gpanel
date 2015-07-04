<div class="portlet box grey-cascade tabbable" data-jsb-name="datatable" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-globe"></i><?=$title?>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <div class="portlet-tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_1" data-toggle="tab"><?=$options->own_options?></a>
                </li>
                <li class="">
                    <a href="#tab_2" data-toggle="tab"><?=$options->inherited_options?></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?=$this->load->view('tables/datatable.php', array( 'table' => $options->options_table ) )?>   
                </div>
                <div class="tab-pane" id="tab_2">
                    <?=$this->load->view('tables/table.php', array( 'table' => $options->inherit_table ) )?>
                </div>
            </div>
        </div>
    </div>
</div>