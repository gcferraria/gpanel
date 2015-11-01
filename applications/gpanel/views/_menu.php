<div class="hor-menu hidden-sm hidden-xs">
    <ul class="nav navbar-nav">
        <?php foreach ( $data as $l1 ) : ?>
        <li class="classic-menu-dropdown<?=(isset($l1['selected']) && $l1['selected']) ? ' active' : ''?>">

            <?php if ( empty( $l1['children'] ) ) : ?>

            <a href="<?=site_url($l1['url'])?>" title="<?=$l1['title']?>"><?=$l1['title']?></a>

            <?php else: ?>

            <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
                <?=$l1['title']?> <i class="fa fa-angle-down"></i>
            </a>

            <ul class="dropdown-menu pull-left">
                <?php foreach ( $l1['children'] as $l2 ) : ?>
                <li class="<?=( !empty( $l2['children'] ) ? 'dropdown-submenu' : '' )?>">
                    
                    <?php if ( empty( $l2['children'] ) ) : ?>

                    <a href="<?=site_url($l2['url'])?>" title="<?=$l2['title']?>">
                        <?php if ( isset( $l2['icon'] ) && !empty( $l2['icon'] ) ) : ?>
                            <i class="fa fa-<?=$l2['icon']?>"></i>
                        <?php endif ?>
                        <?=$l2['title']?>
                        <?php if ( !isset( $l2['icon'] ) or empty( $l2['icon'] ) ) : ?>
                            <i class="fa fa-link pull-right"></i>
                        <?php endif ?>
                    </a>

                    <?php else : ?>
 
                    <a href="javascript:;">
                        <?php if ( isset( $l2['icon'] ) && !empty( $l2['icon'] ) ) : ?>
                            <i class="fa fa-<?=$l2['icon']?>"></i>
                        <?php endif ?>
                        <?=$l2['title']?>
                    </a>

                    <ul class="dropdown-menu">
                        <?php foreach ( $l2['children'] as $l3 ) : ?>
                        <li>
                            <a href="<?=site_url($l3['url'])?>" title="<?=$l3['title']?>"><?=$l3['title']?></a>
                        </li>
                        <?php endforeach ?>
                    </ul>

                    <?php endif ?>

                </li>
                <?php endforeach ?>
            </ul>

            <?php endif ?>

            <?php if( !empty($l1['selected']) ) : ?>
            <span class="selected"></span>
            <?php endif ?>
        </li>
        <?php endforeach ?>
    </ul>
</div>

<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
