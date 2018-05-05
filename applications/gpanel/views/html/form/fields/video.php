<?php
    if ( $value ) {
        $data = json_decode( $value );

       $url    = str_replace( $this->config->item('static_url'), '', $value );
        $value = htmlentities(
            json_encode( array( 
                    '$filename' => $url,
                    '$play'     => array('href' => $this->config->item('static_url') . $url)
                )
            )
        );
    }
?>
<div class="form-group">
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-6" data-jsb-name="<?=$field?>" data-jsb-class="JsB">
        <span class="btn btn-success fileinput-button">
            <i class="fa fa-upload"></i>
            <span>Upload</span>
            <input type="hidden" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" data-jsb-name="field" data-jsb-type="<?=isset( $multiple ) ? 'multiple' : ''?>" data-jsb-class="App.Upload.Field">
            <input type="file" name="<?=$field?>_file" id="<?=$field?>_file" value="<?=$value?>" <?=$attrs?> data-jsb-class="Upload" />
        </span>

        <a href="#" class="btn yellow" data-jsb-name="btnModal" data-jsb-type="video" data-jsb-class="App.Modal.Assets.Open">
            <i class="fa fa-plus"></i> <?=$this->lang->line('select_file')?>
        </a>

        <div id="progress" class="progress progress-striped active display-hide" data-jsb-class="App.Upload.Progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" data-jsb-name="bar" data-jsb-class="JsB"></div>
        </div>

        <div id="files" class="files" data-jsb-type="<?=isset( $multiple ) ? 'appender' : 'reseter'?>" data-jsb-class="App.Upload.Files">
            <div class="alert alert-warning added-files template" data-jsb-name="file" data-jsb-class="JsB">
                <span data-jsb-name="filename" data-jsb-class="JsB"></span>
                <a href="#" class="remove pull-right btn btn-sm red" data-jsb-name="delete" data-jsb-class="App.Upload.Files.Delete">
                    <i class="fa fa-times"></i> remover
                </a>
                <a href="javascript:;" class="open pull-right btn btn-sm green" data-jsb-name="play" data-jsb-class="App.Fancybox">
                    <i class="fa fa-play"></i> play
                </a>
            </div>
        </div>

        <span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
        <?php if( isset( $help ) ) : ?>
        <span class="help-block no-error"><?=$help?></span>
        <?php endif ?>
    </div>
</div>