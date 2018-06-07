<div class="form-group">
	<label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-4" data-jsb-name="<?=$field?>" data-jsb-class="JsB">
		<div class="input-group" style="text-align:left">
		<input type="text" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" <?=$attrs?> class="form-control" data-jsb-name="field" data-jsb-class="Input" />
			<span class="input-group-btn">
				<a href="javascript:;" class="btn green" data-jsb-name="checker" data-url="/administration/administrators/check.json" data-jsb-class="Username">
					<i class="fa fa-check"></i> <?=$this->lang->line('check')?>
				</a>
			</span>
		</div>
		<span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
		<?php if( isset( $help ) ) : ?>
		<span class="help-block no-error"><?=$help?></span>
		<?php endif ?>
	</div>
</div>