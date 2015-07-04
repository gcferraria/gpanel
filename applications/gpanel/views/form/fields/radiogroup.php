<div class="form-group">
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9" data-jsb-name="<?=$field?>" data-jsb-class="JsB">
        <div class="radio-list">
            <?php foreach( $values as $name => $option ) : ?>
            <label class="radio-inline">
                <?php $checked = ( isset( $value ) && $value == $option ) ? 'checked' : '' ?>
                <input type="radio" name="<?=$field?>" id="<?=$field?>" value="<?=$option?>" <?=$checked?> data-jsb-name="field" data-jsb-class="Radio"><?=$name?></label>
            </label>
            <?php endforeach ?>
            <span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
            <?php if( isset( $help ) ) : ?>
            <span class="help-block no-error"><?=$help?></span>
            <?php endif ?>
        </div>
    </div>
</div>