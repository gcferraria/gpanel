    
    <?php 
        if ( isset( $_REQUEST['load_media_modal'] ) ) {
            $this->load->view('html/index/categories/contents/_upload', array( 'table' => $table ) );
        }
    ?>

    <?php if ( isset( $this->administrator ) ) : ?>
    <div class="page-footer">
        <div class="page-footer-inner">
            <?=date('Y')?> &copy; gPanel Admin by Gonçalo Ferraria.; <?="Loading Time: " . $this->benchmark->elapsed_time()?>; <?="Memory Use: " . $this->benchmark->memory_usage()?>
        </div>
        <div class="scroll-to-top" data-jsb-name="btnTop" data-jsb-class="Top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <?php endif ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?=base_url('js/vendor/jquery-1.11.3.min.js')?>"><\/script>')</script>

    <!--[if lt IE 10]><script src="http://polyfill.io"></script><![endif]-->
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

    <script src="<?=base_url('js/3rdparty.js')?>"></script>
    <script src="<?=base_url('js/main.js')?>"></script>
    <script src="<?=base_url('js/vendor/ckeditor/ckeditor.js')?>"></script>
    <script src="<?=base_url('js/vendor/ckeditor/adapters/jquery.js')?>"></script>

     <script type="text/javascript">
        JsB.APP_LANGUAGE = 'pt'
        app = new App( document.body );
    </script>

</body>
</html>
