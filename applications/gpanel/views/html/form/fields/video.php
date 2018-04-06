<div class="form-group">
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-6" data-jsb-name="<?=$field?>" data-jsb-class="JsB">
    </div>
</div>