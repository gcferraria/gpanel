<div class="form-group">
	<label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-4" data-date-format="YYYY-MM-DD" data-jsb-name="<?=$field?>" data-jsb-class="DateRangeInput">
		<div class="input-group date form_datetime">
			<input type="text" readonly="" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" <?=$attrs?> class="form-control" data-jsb-name="field" data-jsb-class="Input" />
			<span class="input-group-btn">
			    <button class="btn default date-range-toggle" type="button"><i class="fa fa-calendar"></i></button>
            </span>
		</div>
		<span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
		<?php if( isset( $help ) ) : ?>
		<span class="help-block no-error"><?=$help?></span>
		<?php endif ?>
	</div>
</div>
