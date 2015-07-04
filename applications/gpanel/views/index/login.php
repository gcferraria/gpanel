<section class="login box">

    <header class="box">
        <h2 class="login box"><?=$login->title?></h2>
    </header>

    <div class="content">

        <form method="post" action="<?=base_url('ajax/login')?>" data-jsb-name="login" data-jsb-type="context" data-jsb-class="App.Form.Ajax" class="login">

            <div class="notification" data-jsb-class="App.Form.Ajax.Notification"></div>

            <label>
                <input id="username" name="username" type="text" placeholder="username" />
            </label>

            <label>
                <input id="password" name="password" type="password" placeholder="password" />
            </label>

            <label>
                <input type="checkbox" id="remember" name="remember" />
                <span><?=$login->remember?></span>
            </label>

            <button type="submit" class="button gray" data-jsb-class="App.Form.Ajax.Button">
                <?=$login->btn?>
            </button>

        </form>

    </div>

</div>