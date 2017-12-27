<div class="login logo">
    <a href="<?=site_url()?>">
        <img src="<?=base_url('img/logo-big.png')?>" alt="logo" />
    </a>
</div>
<div class="login content" data-jsb-name="login" data-jsb-class="App.Login">

    <form action="/login.json" method="post" data-jsb-name="login" data-jsb-type="context" data-jsb-class="App.Form.Ajax.Login" class="login-form" autocomplete="false">
        <h3 class="form-title font-green"><?=$this->lang->line('login_title')?></h3>

        <fieldset data-jsb-name="fields" data-jsb-class="JsB">
            <div class="form-group" data-jsb-name="username" data-jsb-class="JsB">
                <label class="control-label visible-ie8 visible-ie9"><?=$this->lang->line('login_user')?></label>
                <div class="input-icon input-icon-lg right">
                    <i class="fa fa-envelope" data-jsb-name="error" data-jsb-class="Icon"></i>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="false" placeholder="<?=$this->lang->line('login_user')?>" name="username" data-jsb-name="field" data-jsb-class="Input" />
                </div>
            </div>
            <div class="form-group" data-jsb-name="password" data-jsb-class="JsB">
                <label class="control-label visible-ie8 visible-ie9"><?=$this->lang->line('login_password')?></label>
                <div class="input-icon input-icon-lg right">
                    <i class="fa fa-user" data-jsb-name="error" data-jsb-class="Icon"></i>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="false" placeholder="<?=$this->lang->line('login_password')?>" name="password"  data-jsb-name="field" data-jsb-class="Input" />
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" data-loading-text="Loading..." class="btn green uppercase" data-jsb-class="App.Form.Ajax.Submit">
                    <?=$this->lang->line('login_btn')?>
                </button>
                <label class="rememberme check">
                    <input type="checkbox" name="remember" data-jsb-name="field" data-jsb-class="CheckBox" /><?=$this->lang->line('login_remember')?>
                </label>
                <a href="javascript:;" class="forget-password" data-jsb-name="forget-password" data-jsb-class="App.Login.Navigation">
                    <?=$this->lang->line('login_recoverr')?>
                </a>
            </div>
        </fieldset>
    </form>

    <form action="/login/forget.json" method="post" data-jsb-name="forget" data-jsb-type="context" data-jsb-class="App.Form.Ajax" class="forget-form">
        <h3 class="font-green"><?=$this->lang->line('forget_title')?></h3>
        <p><?=$this->lang->line('forget_instructions')?></p>
        
        <fieldset data-jsb-name="fields" data-jsb-class="JsB">
            <div class="form-group" data-jsb-name="email" data-jsb-class="JsB">
                <div class="input-icon input-icon-lg">
                    <i class="fa fa-envelope" data-jsb-name="error" data-jsb-class="Icon"></i>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="false" placeholder="<?=$this->lang->line('forget_email')?>" name="email" data-jsb-name="field" data-jsb-class="Email" /> 
                </div>
            </div>
        </fieldset>
        <div class="form-actions">
            <button type="button" class="btn btn-default" data-jsb-name="back" data-jsb-class="App.Login.Navigation">
                <?=$this->lang->line('forget_btn_back')?>    
            </button>
            <button type="submit" data-loading-text="Loading..." class="btn btn-success uppercase pull-right" data-jsb-class="App.Form.Ajax.Submit">
                <?=$this->lang->line('forget_btn_submit')?>
            </button>
        </div>
    </form>
</div>
<div class="login copyright">
    <?=date('Y')?> &copy; gPanel Admin.
</div>