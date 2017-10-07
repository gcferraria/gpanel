<div class="page-container">

    <div class="page-sidebar-wrapper">
        <?=$this->load->view('html/_mobile_menu', array('data' => $menu_data), true)?>
    </div>

    <div class="page-content-wrapper">

        <div class="page-content" data-jsb-name="<?=$module?>" data-jsb-class="JsB">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <?=$breadcrumbs?>
                </ul>
                <div class="page-toolbar">
                    <?php if( isset( $actions ) ) : ?>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                            <span><?=$this->lang->line('actions')?></span> <i class="fa fa-angle-down"></i>
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
                    <?php if( isset( $date_range ) ) : ?>
                    <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-placement="top" data-jsb-name="daterange" data-jsb-class="DateRange">
                        <i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
                    </div>
                    <?php endif ?>
                </div>
            </div>

            <h3 class="page-title">
                <?=$title?>
                <?php if ( isset ($description) ) : ?>
                <small><?=$description?></small>
                <?php endif ?>
            </h3>
            
            <div class="row <?=$module?>">
                <?php if( empty($sidebar) ) : ?>
                <div class="col-md-12">
                    <?=$content?>
                </div>
                <?php else :?>
                <div class="<?=(isset($sidebarClass) ? $sidebarClass : 'col-md-3' )?>">
                    <?=$sidebar?>
                </div>
                <div class="<?=(isset($contentClass) ? $contentClass : 'col-md-9' )?>">
                    <?=$content?>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
