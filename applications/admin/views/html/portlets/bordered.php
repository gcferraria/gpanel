<div class="portlet light" data-jsb-name="<?=$name?>" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption font-green-sharp uppercase">
            <i class="<?=$icon?> font-green-sharp"></i><?=$title?>
        </div>
        <div class="actions">
            <a href="javascript:;" class="btn btn-circle btn-icon-only btn-default reload" title="<?=$this->lang->line('reload')?>" data-jsb-name="reload" data-jsb-class="App.Portlet.Reload">
                <i class="icon-reload"></i>
            </a>
            <?php if( isset( $table_actions ) ) : ?>
            <div class="btn-group">
                <button class="btn red btn-outline btn-circle" data-toggle="dropdown">
                    <i class="fa fa-cogs"></i>
                    <?=$this->lang->line('actions')?> <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right" role="menu" data-jsb-name="actions" data-jsb-type="context" data-jsb-class="App.Portlet.Actions">
                    <?php foreach ( $table_actions as $action => $attrs ) : ?>
                    <li>
                        <a  href="javascript:;" 
                            data-text="<?=$attrs['data-text']?>" 
                            data-url="<?=base_url($attrs['url'])?>"
                            data-jsb-name="<?=$action?>"
                            data-jsb-class="<?=$attrs['data-jsb-class']?>">
                            <?=$attrs['text']?>
                        </a>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php endif ?>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <?php if ( isset( $beforeBody ) ) : ?>
        <?=$beforeBody?>
        <?php endif ?>
        <?php $this->load->view('html/tables/datatable.php')?>
        <?php if ( isset( $afterBody ) ) : ?>
        <?=$afterBody?>
        <?php endif ?>
    </div>
</div>