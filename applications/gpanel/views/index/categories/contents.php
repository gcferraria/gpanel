<div class="portlet light bordered" data-jsb-name="contents" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption font-green-sharp uppercase">
            <i class="icon-speech font-green-sharp"></i><?=$title?>
        </div>
        <div class="actions">
            <?php if( count( $views ) == 0 ) : ?>
            <a href="javascript:;" class="btn btn-circle btn-icon-only btn-default reload" title="<?=$this->lang->line('reload')?>" data-jsb-name="reload" data-jsb-class="App.Portlet.Reload">
                <i class="icon-reload"></i>
            </a>
            <?php endif ?>
            <?php if( isset( $actions ) ) : ?>
            <div class="btn-group">
                <button class="btn red btn-outline btn-circle" data-toggle="dropdown">
                    <i class="fa fa-cogs"></i>
                    <?=$this->lang->line('actions')?> <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <?php foreach ($actions as $action => $link) : ?>
                    <li>
                        <a href="<?=site_url($link)?>"><?=$action?></a>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php endif ?>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <?php if( count( $views ) == 0 ) : ?>
		<?=$this->load->view('tables/datatable.php')?>
        <?php else: ?>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=$this->lang->line('category_views')?></h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                    <?php foreach ( $views as $view ) : ?>
                    <?php $url = site_url( 'categories/contents/index/' . $view->id ); ?>
                        <li class="list-group-item">
                            <a href="<?=$url?>">
                                <?=$view->name?>
                            </a>
                            <span class="path"><?=implode( ' » ', $view->path_name_array() )?></span>
                            <span class="badge badge-default"><?=$view->contents->count()?> </span>
                        </li>
                    <?php endforeach ?>
                    </ul>
                </div>
            </div>
        <?php endif ?>
	</div>
</div>
