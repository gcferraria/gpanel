<div class="page-sidebar navbar-collapse collapse">
    <div class="page-sidebar-wrapper">
        <ul class="page-sidebar-menu visible-sm visible-xs page-header-fixed">

            <li class="sidebar-search-wrapper">
                <form class="sidebar-search sidebar-search-bordered" action="extra_search.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn submit">
                                <i class="icon-magnifier"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </li>

            <?php foreach ( $data as $l1 ) : ?>
            <li class="nav-item start <?=(isset($l1['selected']) && $l1['selected']) ? ' active' : ''?>">

                <?php if ( empty( $l1['children'] ) ) : ?>
                <a href="<?=site_url($l1['url'])?>" class="nav-link"> <?=$l1['title']?>
                    <?php if( !empty($l1['selected']) ) : ?>
                    <span class="selected"></span>
                    <?php endif ?>
                </a>
                <?php else : ?>
                <a href="javascript:;" class="nav-link nav-toggle"> <?=$l1['title']?>
                    <?php if( !empty($l1['selected']) ) : ?>
                    <span class="selected"></span>
                    <?php endif ?>
                    <span class="arrow open"> </span>
                </a>
                <ul class="sub-menu">
                <?php foreach ( $l1['children'] as $l2 ) : ?>
                    <li class="nav-item start ">

                        <?php if ( empty( $l2['children'] ) ) : ?>
                        <a href="<?=site_url($l2['url'])?>" class="nav-link">
                            <?php if ( isset( $l2['icon'] ) && !empty( $l2['icon'] ) ) : ?>
                            <i class="fa fa-<?=$l2['icon']?>"></i>
                            <?php endif ?>
                            <span class="title"><?=$l2['title']?></span>
                            <?php if ( !isset( $l2['icon'] ) or empty( $l2['icon'] ) ) : ?>
                            <i class="fa fa-link pull-right"></i>
                            <?php endif ?>
                        </a>
                        <?php else : ?>
                        <a href="javascript:;" class="nav-link nav-toggle"> <?=$l2['title']?>
                            <?php if ( isset( $l2['icon'] ) && !empty( $l2['icon'] ) ) : ?>
                            <i class="fa fa-<?=$l2['icon']?>"></i>
                            <?php endif ?>

                            <?php if( !empty($l2['selected']) ) : ?>
                            <span class="selected"></span>
                            <?php endif ?>
                            <span class="arrow open"> </span>

                            <ul class="sub-menu">
                            <?php foreach ( $l2['children'] as $l3 ) : ?>    
                            <a href="<?=site_url($l3['url'])?>" class="nav-link"><?=$l3['title']?></a>
                            <?php endforeach ?>    
                            </ul>
                        </a>
                        <?php endif ?>

                    </li>
                <?php endforeach ?>
                </ul>
                <?php endif ?>

            </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>