<div class="page-sidebar navbar-collapse collapse">

    <ul class="page-sidebar-menu page-header-fixed page-sidebar-menu-light" data-jsb-name="sidebar" data-jsb-class="App.Sidebar" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px;">

        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler"></div>
        </li>

        <li class="sidebar-search-wrapper">
            <form class="sidebar-search" action="extra_search.html" method="POST">
                <a href="javascript:;" class="remove">
                    <i class="icon-close"></i>
                </a>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="<?=$this->lang->line('search')?>" />
                    <span class="input-group-btn">
                        <button class="btn submit">
                            <i class="icon-magnifier"></i>
                        </button>
                    </span>
                </div>
            </form>
        </li>

        <?php $i = 0;?>
        <?php foreach ( $data as $l1 ) : ?>
        <li class="nav-item <?=($i==0) ? 'start': ''?> <?=(isset($l1['selected']) && $l1['selected']) ? 'active' : ''?>">

            <?php if ( empty( $l1['children'] ) ) : ?>

            <a href="<?=site_url($l1['url'])?>" class="nav-link"> 
                <i class="icon-<?=$l1['icon']?>"></i>
                <span class="title"><?=$l1['title']?></span>

                <?php if( !empty($l1['selected']) ) : ?>
                <span class="selected"></span>
                <?php endif ?>

                <?php if( !empty($l1['badges']) ) : ?>
                <span class="badge badge-warning"><?php echo $l1['badges'] ?></span>
                <?php endif ?>
            </a>

            <?php else : ?>

            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-<?=$l1['icon']?>"></i>
                <span class="title"><?=$l1['title']?></span>

                <?php if( !empty($l1['selected']) ) : ?>
                <span class="selected"></span>
                <?php endif ?>
                
                <span class="arrow"> </span>
            </a>

            <ul class="sub-menu">
            <?php foreach ( $l1['children'] as $l2 ) : ?>
                <li class="nav-item <?=(isset($l2['selected']) && $l2['selected']) ? 'active' : ''?>">

                    <?php if ( empty( $l2['children'] ) ) : ?>

                    <a href="<?=site_url($l2['url'])?>" class="nav-link">
                        
                        <?php if ( isset( $l2['icon'] ) && !empty( $l2['icon'] ) ) : ?>
                        <i class="icon-<?=$l2['icon']?>"></i>
                        <?php endif ?>

                        <?=$l2['title']?>

                        <?php if( !empty($l2['badges']) ) : ?>
                        <span class="badge badge-warning"><?php echo $l2['badges'] ?></span>
                        <?php endif ?>

                        <i class="fa fa-link pull-right"></i>
                    </a>

                    <?php else : ?>

                    <a href="javascript:;" class="nav-link"> 
                        <?php if ( isset( $l2['icon'] ) && !empty( $l2['icon'] ) ) : ?>
                        <i class="icon-<?=$l2['icon']?>"></i>
                        <?php endif ?>

                        <?=$l2['title']?>

                        <?php if( !empty($l2['selected']) ) : ?>
                        <span class="selected"></span>
                        <?php endif ?>
                        <span class="arrow nav-toggle"> </span>
                    </a>

                    <ul class="sub-menu">
                    <?php foreach ( $l2['children'] as $l3 ) : ?>
                        <li class="nav-item">
                            <a href="<?=site_url($l3['url'])?>" class="nav-link">
                                <?php if ( isset( $l3['icon'] ) && !empty( $l3['icon'] ) ) : ?>
                                <i class="icon-<?=$l3['icon']?>"></i>
                                <?php endif ?>

                                <?=$l3['title']?>

                                <?php if( !empty($l3['badges']) ) : ?>
                                <span class="badge badge-warning"><?php echo $l3['badges'] ?></span>
                                <?php endif ?>
                            </a>
                        </li>
                    <?php endforeach ?>    
                    </ul>
                    <?php endif ?>

                </li>
            <?php endforeach ?>
            </ul>
            <?php endif ?>

        </li>
        <?php $i++;?>
        <?php endforeach ?>
    </ul>
</div>