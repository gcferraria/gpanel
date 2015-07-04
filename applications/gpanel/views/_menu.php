<div class="hor-menu hidden-sm hidden-xs">
    <ul class="nav navbar-nav">
        <?php if( $this->administrator->isAdmin() ) : ?>
        <li class="mega-menu-dropdown">
            <a data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                <?=$this->lang->line('menu_administration')?> <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <div class="mega-menu-content">
                        <div class="row">
                            <div class="col-md-3">
                                <ul class="mega-menu-submenu">
                                    <li><h3>Acesso</h3></li>
                                    <li><a href="<?=site_url('administrators')?>">Administradores</a></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="mega-menu-submenu">
                                    <li><h3>Conteúdos</h3></li>
                                    <li><a href="<?=site_url('content_types')?>">Tipos de Conteúdo</a></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="mega-menu-submenu">
                                    <li><h3>i18n</h3></li>
                                    <li><a href="<?=site_url('i18n/languages')?>">Línguas</a></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="mega-menu-submenu">
                                    <li><h3>Definições</h3></li>
                                    <li><a href="<?=site_url('settings/websites')?>">Websites</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
        <?php endif ?>
        <li>
            <a href="<?=site_url('categories/contents/index/1')?>">Gestão de Conteúdos</a>
        </li>
        <li>
            <a href="<?=site_url('media')?>">Multimédia</a>
        </li>
        <li>
            <a href="<?=site_url('notifications')?>">Notificações</a>
        </li>
        <li class="classic-menu-dropdown">
            <a data-toggle="dropdown" href="javascript:;">
                Área Privada <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu pull-left">
                <li>
                    <a href="<?=site_url('users')?>"><i class="fa fa-user"></i> Utilizadores</a>
                </li>
                <?php if( $this->administrator->isAdmin() ) : ?>
                <li>
                    <a href="<?=site_url('roles')?>"><i class="fa fa-puzzle-piece"></i> Funções</a>
                </li>
                <?php endif ?>
            </ul>
        </li>
        <li class="classic-menu-dropdown">
            <a data-toggle="dropdown" href="javascript:;">
                Newsletters <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu pull-left">
                <li>
                    <a href="<?=site_url('newsletter_contacts')?>"><i class="fa fa-male"></i> Contactos</a>
                </li>
                <li>
                    <a href="<?=site_url('newsletters')?>"><i class="fa fa-envelope"></i> Newsletters</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    <img src="<?=base_url('images/menu-toggler.png')?>" alt="" />
</a>
