<?php
    if ( $value ) {
        $data = json_decode( $value );

        if ( isset( $data ) && is_array( $data ) ) {
            $temp = array();
            foreach ( $data as $item ) {
                $item = str_replace( $this->config->item('static_url'), '', $item );
                array_push( $temp, array( 
                        '$filename' => $item,
                        '$open'     => array(
                            'href' => $this->config->item('static_url') . $item,
                        )
                    )
                );
            }

            $value = htmlentities( json_encode( $temp ) );
        }
        else {
            $url   = str_replace( $this->config->item('static_url'), '', $value );
            $value = htmlentities(
                json_encode( array( 
                        '$filename' => $url,
                        '$open'     => array(
                            'href' => $this->config->item('static_url') . $url,
                        )
                    )
                )
            );
        }
    }
?>

<div class="form-group">
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9" data-jsb-name="<?=$field?>" data-jsb-type="<?= (isset($multiple) ? 'multiple' : 'sigular' ) ?>" data-jsb-class="JsB">

        <div class="fileinput fileinput-<?=( isset($value) && !empty($value) ) ? 'exists' : 'new'?>" data-provides="fileinput">
            <?php if ( !isset( $multiple ) ) : ?>
            <div class="fileinput-new thumbnail hidden" style="width: 200px;">
                <img src="http://www.placehold.it/200x100/EFEFEF/AAAAAA&amp;text=sem+imagem" alt="" />
            </div>

            <div class="fileinput-preview fileinput-exists thumbnail hidden" style="max-width: 200px;"> 
                <?php if ( isset($value) && !empty($value) ) : ?>
                <img src="<?= $this->config->item('static_url') . $url?>" alt="" /> 
                <?php endif ?>
            </div>
            <?php endif ?>

            <div class="actions">
                <span class="btn btn-success fileinput-button">
                    
                    <?php if ( !isset( $multiple ) ) : ?>
                    <span class="fileinput-new"><i class="fa fa-upload"></i> <?=$this->lang->line('upload')?> </span>
                    <span class="fileinput-exists"><i class="fa fa-edit"></i> <?=$this->lang->line('change')?>  </span>
                    <span class="fileinput-filename"><?=isset($url) ? $url :''?></span>
                    <?php else : ?>
                    <i class="fa fa-upload"></i> <span><?=$this->lang->line('upload')?></span>
                    <?php endif ?>

                    <input type="hidden" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" data-jsb-name="field" data-jsb-type="<?=isset( $multiple ) ? 'multiple' : ''?>" data-jsb-class="App.Upload.Field">
                    <input type="file" name="<?=$field?>_file" id="<?=$field?>_file" value="<?=$value?>" <?=$attrs?> data-jsb-class="Upload" />
                </span>
                
                <?php if ( !isset( $multiple ) ) : ?>
                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" data-jsb-class="App.Upload.Delete">
                    <i class="fa fa-times"></i> <?=$this->lang->line('remove')?> 
                </a>
                <?php endif ?>

                <a href="#" class="btn yellow" data-jsb-name="btnModal" data-jsb-type="image" data-jsb-class="App.Modal.Assets.Open">
                    <i class="fa fa-plus"></i> <?=$this->lang->line('select_image')?>
                </a>
            </div>

            <div id="progress" class="progress progress-striped active display-hide" data-jsb-class="App.Upload.Progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" data-jsb-name="bar" data-jsb-class="JsB"></div>
            </div>

            <div id="files" class="files image <?=isset( $multiple ) ? 'appender' : 'reseter'?>" data-jsb-type="<?=isset( $multiple ) ? 'appender' : 'reseter'?>" data-jsb-class="App.Upload.Files">
                <div class="alert alert-warning added-files template" data-jsb-name="file" data-jsb-class="JsB">
                    <span data-jsb-name="filename" data-jsb-class="JsB"></span>
                    <a href="#" class="remove pull-right btn btn-sm red" data-jsb-name="delete" data-jsb-class="App.Upload.Files.Delete">
                        <i class="fa fa-times"></i> <?=$this->lang->line('remove')?> 
                    </a>
                    <a href="javascript:;" class="open pull-right btn btn-sm blue" data-jsb-name="open" data-jsb-class="App.Fancybox">
                        <i class="fa fa-search"></i> <?=$this->lang->line('open')?> 
                    </a>
                    <a href="javascript:;" class="open pull-right btn btn-sm yellow" data-jsb-name="down" data-jsb-class="App.Category.Down">
                        <i class="fa fa-arrow-circle-down"></i>
                    </a>
                    <a href="javascript:;" class="open pull-right btn btn-sm yellow" data-jsb-name="up" data-jsb-class="App.Category.Up">
                        <i class="fa fa-arrow-circle-up"></i>
                    </a>
                </div>
            </div>

        </div>
        <span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
        <?php if( isset( $help ) ) : ?>
        <span class="help-block no-error"><?=$help?></span>
        <?php endif ?>
    </div>
</div>