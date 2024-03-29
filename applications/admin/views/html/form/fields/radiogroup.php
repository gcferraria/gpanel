<div class="form-group<?php echo ( !empty( $parent_field ) )  ? ' hidden' : ''; ?>"
    <?php echo ( !empty( $parent_field ) ? 'data-parent="' . $parent_field .'"' : ''); ?>
    <?php echo ( !empty( $parent_field ) ? 'data-parent-values="' . implode(",",$parent) .'"' : ''); ?>
    >
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9" data-jsb-name="<?=$field?>" data-jsb-class="JsB">
        <div class="mt-radio-inline">
            <?php foreach( $values as $name => $option ) : ?>
            <label class="mt-radio">
                <?php $checked = ( isset( $value ) && $value == $option ) ? 'checked' : '' ?>
                <input type="radio" name="<?=$field?>" id="<?=$field?>_<?=$option?>" value="<?=$option?>" <?=$checked?> data-jsb-name="field" data-jsb-class="Input"><?=$name?>
                <span></span>   
            </label>
            <?php endforeach ?>
            <span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
            <?php if( isset( $help ) ) : ?>
            <span class="help-block no-error"><?=$help?></span>
            <?php endif ?>
        </div>
    </div>
</div>