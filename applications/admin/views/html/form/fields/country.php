<div class="form-group<?php echo ( !empty( $parent_field ) )  ? ' hidden' : ''; ?>"
    <?php echo ( !empty( $parent_field ) ? 'data-parent="' . $parent_field .'"' : ''); ?>
    <?php echo ( !empty( $parent_field ) ? 'data-parent-values="' . implode(",",$parent) .'"' : ''); ?>
    >
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9" data-jsb-name="<?=$field?>" data-jsb-class="JsB">
        <select name="<?=$field?>" id="<?=$field?>" <?=$attrs?> class="form-control" data-jsb-name="field" data-jsb-class="Country">
        <?php foreach( $values as $name => $option ) { ?>
        <?php $selected = ( isset( $value ) && $value == $option ) ? 'selected' : '' ?>
            <option <?=$selected?> value="<?=$option?>"><?=$name?></option>
        <?=$name?>
        <?php } ?>
        </select>
        <span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
        <?php if( isset( $help ) ) : ?>
        <span class="help-block no-error"><?=$help?></span>
        <?php endif ?>
    </div>
</div>
