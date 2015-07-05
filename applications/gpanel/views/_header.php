<!DOCTYPE html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?=$title?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <link rel="shortcut icon" href="<?=base_url('favicon.ico')?>">
    <link rel="apple-touch-icon" href="<?=base_url('apple-touch-icon.png')?>">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="<?=base_url('css/3rdparty.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?=base_url('css/main.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?=base_url('css/theme.css')?>" type="text/css" />

</head>
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <?php if ( isset( $this->administrator ) ) : ?>
    <header class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
            <div class="page-logo">
                <a href="<?=site_url('dashboard')?>">
                    <img src="<?=base_url('images/logo.png')?>" alt="logo" class="logo-default" />
                </a>
            </div>

            <?=$this->load->view('_menu')?>

            <div class="top-menu">

                <ul class="nav navbar-nav pull-right">

                    <?php if( $notifications['number'] > 0  ) : ?>
                    <li class="dropdown dropdown-extended dropdown-notification" data-jsb-class="App.Notification.Pulsate">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="fa fa-warning"></i>
                            <span class="badge"><?=$notifications['number']?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <p>Existem <?=$notifications['number']?> notificações por ler.</p>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" data-height="250" data-jsb-class="App.Scroll">
                                    <?php foreach ($notifications['list'] as $notification) : ?>
                                    <li>
                                        <a href="<?=site_url('notifications/open/' . $notification->id )?>">
                                            <span class="label label-warning"><i class="icon-bell"></i></span>
                                            <?=$notification->subject?>
                                            <span class="time">
                                                <?php
                                                $diff = get_spent_hours( $notification->creation_date);
                                                $diff = ( $diff->d > 0 ) ? $diff->format('%d') . ' dia(s)' : $diff->format('%h') . ' hora(s)'; 
                                                ?>
                                                <?=$diff?>
                                            </span>
                                        </a>
                                    </li>
                                    <?php endforeach?>
                                </ul>
                            </li>
                            <li class="external">
                                <a href="<?=site_url('notifications') ?>">Ver todas as notificações <i class="m-icon-swapright"></i></a>
                            </li>
                        </ul>
                    </li>
                    <?php endif ?>

                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <?php if( empty($this->administrator->avatar ) ) : ?>
                            <img class="img-circle" src="<?=base_url('images/default_avatar.png')?>" alt="avatar" />
                            <?php else: ?>
                            <img class="img-circle" src="<?=base_url('uploads/".$this->administrator->avatar')?>" alt="avatar" />
                            <?php endif ?>
                            <span class="username username-hide-on-mobile"><?=$this->administrator->name?></span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=site_url('profile')?>"><i class="fa fa-user"></i> O meu Perfil</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=site_url('logout')?>"><i class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="clearfix"></div>

    <?php endif ?>
