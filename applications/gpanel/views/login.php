<div class="login logo">
    <a href="<?=site_url()?>">
        <img src="<?=base_url('images/logo-big.png')?>" alt="logo" />
    </a>
</div>
<div class="login content">

    <form action="/login.json" method="post" data-jsb-name="login" data-jsb-type="context" data-jsb-class="App.Form.Ajax" class="login-form">
        <h3 class="form-title"><?=$this->lang->line('login_title')?></h3>

        <fieldset data-jsb-name="fields" data-jsb-class="JsB">
            <div class="form-group" data-jsb-name="username" data-jsb-class="JsB">
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" data-jsb-name="field" data-jsb-class="Input" />
            </div>
            <div class="form-group" data-jsb-name="password" data-jsb-class="JsB">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"  data-jsb-name="field" data-jsb-class="Input" />
            </div>
            <div class="form-actions">
                <label class="checkbox">
                    <input type="checkbox" name="remember" data-jsb-name="field" data-jsb-class="CheckBox" /> Relembrar Login
                </label>
            </div>
        </fieldset>
        <button type="submit" data-loading-text="Loading..." class="btn btn-success uppercase pull-right" data-jsb-class="App.Form.Ajax.Submit">
            <?=$this->lang->line('login_btn')?>
        </button>
    </form>
</div>
<div class="login copyright">
    <?=date('Y')?> &copy; gPanel Admin.
</div>
