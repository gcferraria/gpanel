<div class="portlet box grey-cascade" data-jsb-name="datatable" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-globe"></i><?=$title?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
            <?php if( count( $views ) == 0 ) : ?>
            <a href="javascript:;" class="reload" data-jsb-name="reload" data-jsb-class="App.Portlet.Reload"></a>
            <?php endif ?>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <?php if( count( $views ) == 0 ) : ?>
		<?=$this->load->view('tables/datatable.php')?>
        <?php else: ?>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Vistas de Categoria</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                    <?php foreach ( $views as $view ) : ?>
                    <?php $url = site_url( 'categories/contents/' . $view->id ); ?>
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