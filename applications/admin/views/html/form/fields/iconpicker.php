<div class="form-group">
	<label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9" data-jsb-name="<?=$field?>" data-jsb-class="JsB">
	    <div class="input-group">
	    	<span class="input-group-addon"></span>
	    	<input type="text" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" <?=$attrs?> class="form-control icp icp-auto input-medium" data-placement="bottomLeft" data-jsb-name="field" data-jsb-class="IconPicker" />
		</div>
		<span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
		<?php if( isset( $help ) ) : ?>
		<span class="help-block no-error"><?=$help?></span>
		<?php endif ?>
	</div>
</div>
