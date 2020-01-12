    
    <?php 
        if( isset( $_REQUEST['load_media_modal'] ) ) {
            $this->load->view('html/index/categories/contents/_upload');
        }
    ?>

    <?php if( isset( $this->administrator ) ) : ?>
    <div class="page-footer">
        <div class="page-footer-inner">
            <?php echo date('Y'); ?> &copy; gPanel Admin by <?php echo $this->lang->line('author'); ?>; <?php echo "Loading Time: " . $this->benchmark->elapsed_time(); ?>; 
            <?php echo "Memory Use: " . $this->benchmark->memory_usage(); ?>
        </div>
        <div class="scroll-to-top" data-jsb-name="btnTop" data-jsb-class="Top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <?php endif ?>

    <script src="<?php echo base_url('js/vendor/modernizr-3.8.0.min.js'); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url('js/vendor/jquery-3.4.1.min.js'); ?>"><\/script>')</script>

    <!--[if lt IE 10]><script src="https://polyfill.io"></script><![endif]-->
    <script type="text/javascript" src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

    <script src="<?php echo base_url('js/3rdparty.js'); ?>"></script>
    <script src="<?php echo base_url('js/main.js'); ?>"></script>
    <script src="<?php echo base_url('js/vendor/ckeditor/ckeditor.js'); ?>"></script>
    <script src="<?php echo base_url('js/vendor/ckeditor/adapters/jquery.js'); ?>"></script>

     <script type="text/javascript">
        JsB.APP_LANGUAGE = 'pt'
        app = new App( document.body );
    </script>

</body>
</html>