<div class="portlet light profile-sidebar-portlet ">
    <div class="profile-userpic">
        <?php if( empty($administrator->avatar) ) : ?>
        <img src="<?=base_url('img/default_avatar_big.jpg')?>" class="img-responsive" alt="" />
        <?php else: ?>
        <img src="<?=base_url('uploads/$this->administrator->avatar')?>" class="img-responsive" alt="" />
        <?php endif ?>
    </div>
    <div class="profile-usertitle">
        <div class="profile-usertitle-name"><?=$administrator->name?></div>
    </div>
    <div class="profile-userbuttons">
        <a href="mailto:<?=$administrator->email?>" class="btn btn-circle red btn-sm"><?=$this->lang->line('profile_send_email')?></a>
    </div>
    <div class="profile-usermenu">
        <ul class="nav">
            <li class="<?=(!empty($this->uri->segment(2)) ? '' : 'active' )?>">
                <a href="<?=site_url('profile')?>">
                    <i class="icon-home"></i> <?=$this->lang->line('profile_menu_dashboard')?> </a>
            </li>
            <li class="<?= (empty($this->uri->segment(2)) ? '' : 'active' ) ?>">
                <a href="<?=site_url('profile/settings')?>">
                    <i class="icon-settings"></i> <?=$this->lang->line('profile_menu_settings')?> </a>
            </li>
        </ul>
    </div>
</div>
<div class="portlet light ">
    <div class="row list-separated profile-stat">
        <div class="col-md-4 col-sm-4 col-xs-6">
            <div class="uppercase profile-stat-title"> <?=$total_contents?></div>
            <div class="uppercase profile-stat-text"> <?=$this->lang->line('profile_stats_contents')?></div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-6">
            <div class="uppercase profile-stat-title"> <?=$total_categories?> </div>
            <div class="uppercase profile-stat-text"> <?=$this->lang->line('profile_stats_categories')?> </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-6">
            <div class="uppercase profile-stat-title"> <?=$total_media?> </div>
            <div class="uppercase profile-stat-text"> <?=$this->lang->line('profile_stats_uploads')?> </div>
        </div>
    </div>   
    <div>
        <div class="margin-top-20 profile-desc-link">
            <i class="fa fa-globe"></i>
            <a href="<?=site_url()?>"><?=site_url()?></a>
        </div>
        <div class="margin-top-20 profile-desc-link">
            <i class="fa fa-envelope"></i>
            <a href="mailto:<?=$administrator->email?>"><?=$administrator->email?></a>
        </div>
        <div class="margin-top-20 profile-desc-link">
            <i class="fa <?=( $administrator->sex == 'M') ? 'fa-male' : 'female'?>"></i>
            <a href=""><?=( $administrator->sex == 'M') ? $this->lang->line('male') : $this->lang->line('female') ?></a>
        </div>
         <div class="margin-top-20 profile-desc-link">
             <i class="fa fa-calendar"></i> 
             <a href="#"><?=$administrator->creation_date?></a>
        </div>
    </div>                             
</div>