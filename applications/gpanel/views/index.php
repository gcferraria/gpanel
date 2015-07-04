<div class="page-container">

    <div class="page-content-wrapper">

        <div class="page-content">

            <h3 class="page-title"><?=$title?></h3>
            <div class="page-bar">
                <ul class="page-breadcrumb breadcrumb">
                    <?=$breadcrumbs?>
                </ul>
                <div class="page-toolbar">
                    <?php if( isset( $actions ) ) : ?>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                            <span>Acções</span> <i class="fa fa-angle-down"></i>
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
            <div class="row <?=$module?>">
                <?php if( empty($sidebar) ) : ?>
                <div class="col-md-12">
                    <?=$content?>
                </div>
                <?php else :?>
                <div class="col-md-3">
                    <?=$sidebar?>
                </div>
                <div class="col-md-9">
                    <?=$content?>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>