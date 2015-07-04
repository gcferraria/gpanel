<div class="form-group">
	<label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-2" data-jsb-name="<?=$field?>" data-jsb-class="Spinner">
    	<div class="input-group">
			<input type="text" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" <?=$attrs?> class="form-control spinner-input" maxlength="3" readonly="readonly" data-jsb-name="field" data-jsb-class="Input" />
			<div class="spinner-buttons input-group-btn">
				<button type="button" class="btn spinner-up default">
					<i class="fa fa-angle-up"></i>
				</button>
				<button type="button" class="btn spinner-down default">
					<i class="fa fa-angle-down"></i>
				</button>
			</div>
		</div>
		<span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
		<?php if( isset( $help ) ) : ?>
		<span class="help-block no-error"><?=$help?></span>
		<?php endif ?>
	</div>
</div>