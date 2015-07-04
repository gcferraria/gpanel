    <?php if ( isset( $this->administrator ) ) : ?>
    <div class="page-footer">
        <div class="page-footer-inner">
            <?=date('Y')?> &copy; gPanel <?=VERSION?> Admin by Gonçalo Ferraria.<br />
            <?="Loading Time: " . $this->benchmark->elapsed_time()?>;
            <?="Memory Use: " . $this->benchmark->memory_usage()?>
        </div>
        <div class="page-footer-tools">
            <span class="go-top" data-jsb-name="btnTop" data-jsb-class="Top">
                <i class="fa fa-angle-up"></i>
            </span>
        </div>
    </div>
    <?php endif ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?=base_url('js/vendor/jquery-1.10.2.min.js')?>"><\/script>')</script>

    <!--[if lt IE 10]><script src="http://polyfill.io"></script><![endif]-->
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

    <script src="<?=base_url('js/3rdparty.js')?>?v<?=VERSION?>"></script>
    <script src="<?=base_url('js/main.js')?>?v<?=VERSION?>"></script>
    <script src="<?=base_url('js/vendor/ckeditor/ckeditor.js')?>"></script>
    <script src="<?=base_url('js/vendor/ckeditor/adapters/jquery.js')?>"></script>

     <script type="text/javascript">
        JsB.APP_LANGUAGE = 'pt'
        app = new App( document.body );
    </script>

</body>
</html>
