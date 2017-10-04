<div class="portlet light bordered" data-jsb-name="options" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title tabbable-line">
        <div class="caption font-green-sharp uppercase">
            <i class="icon-globe font-green-sharp"></i><?=$title?>
        </div>
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1" data-toggle="tab" class="uppercase"><?=$options->own_options?></a>
            </li>
            <li class="">
                <a href="#tab_2" data-toggle="tab" class="uppercase"><?=$options->inherited_options?></a>
            </li>
        </ul>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
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
