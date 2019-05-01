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

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="<?=base_url('css/3rdparty.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?=base_url('css/main.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?=base_url('css/theme.css')?>" type="text/css" />

</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo <?=(isset($class) ? $class : '' )?> page-container-bg-solid">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <?php if ( isset( $this->administrator ) ) : ?>
    <header class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
            <div class="page-logo">
                <a href="<?=site_url('dashboard')?>">
                    <img src="<?=base_url('img/logo.png')?>" alt="logo" class="logo-default" />
                </a>
                <div class="menu-toggler sidebar-toggler" data-jsb-name="toggler" data-jsb-class="App.Toogle">
                    <span></span>
                </div>
            </div>

            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>

            <div class="top-menu">

                <ul class="nav navbar-nav pull-right">

                    <?php if( $notifications['number'] > 0  ) : ?>
                    <li class="dropdown dropdown-extended dropdown-notification" data-jsb-name="notification" data-jsb-class="App.Notification.Pulsate">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge badge-default" data-jsb-name="value" data-jsb-class="JsB"><?=$notifications['number']?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>
                                    <span class="bold"><?=sprintf($this->lang->line('notifications_unread'),$notifications['number'])?></span> <?=$this->lang->line('pendents')?>
                                </h3>
                                <a href="<?=site_url('notifications') ?>"><?=$this->lang->line('view_all')?></a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" data-height="250" data-jsb-class="App.Scroll">
                                    <?php foreach ($notifications['list'] as $notification) : ?>
                                    <li>
                                        <a href="<?=site_url('notifications/open/' . $notification->id )?>">
                                            <span class="time">
                                                <?php
                                                $time = new DateTime( date( 'Y-m-d H:i:s', strtotime( $notification->creation_date ) ) );
                                                $now  = new DateTime( date( 'Y-m-d H:i:s') );
                                                $diff = $now->diff( $time );
                                    
                                                if ( $diff->y >= 1 )
                                                    $time = $diff->y . ' ' .$this->lang->line('years');
                                                elseif ( $diff->m >= 1 )
                                                    $time = $diff->m . ' ' .$this->lang->line('months');
                                                elseif ( $diff->d >= 1 )
                                                    $time = $diff->d . ' ' . $this->lang->line('days');
                                                elseif ( $diff->h >= 1 )
                                                    $time = $diff->h . ' ' .$this->lang->line('hours');
                                                elseif ( $diff->i >= 1 )
                                                    $time = $diff->i . ' ' .$this->lang->line('minutes');
                                                else
                                                    $time = $this->lang->line('right_now');
                                                ?>
                                                <?=$time?>
                                            </span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-warning">
                                                    <i class="fa fa-bell-o"></i>
                                                </span>
                                                <?=$notification->subject?>
                                            </span>
                                        </a>
                                    </li>
                                    <?php endforeach?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php endif ?>

                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <?php if( empty($this->administrator->avatar ) ) : ?>
                            <img class="img-circle" src="<?=base_url('img/default_avatar.png')?>" alt="avatar" />
                            <?php else: ?>
                            <img class="img-circle" src="<?=base_url('uploads/".$this->administrator->avatar')?>" alt="avatar" />
                            <?php endif ?>
                            <span class="username username-hide-on-mobile"><?=$this->administrator->name?></span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?=site_url('profile')?>">
                                    <i class="icon-user"></i> <?=$this->lang->line('my_profile')?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?=site_url('logout')?>">
                                    <i class="icon-logout"></i> <?=$this->lang->line('logout')?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="clearfix"></div>

    <?php endif ?>