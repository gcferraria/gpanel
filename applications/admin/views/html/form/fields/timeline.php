<div class="form-group<?php echo ( !empty( $parent_field ) )  ? ' hidden' : ''; ?>"
    <?php echo ( !empty( $parent_field ) ? 'data-parent="' . $parent_field .'"' : ''); ?>
    <?php echo ( !empty( $parent_field ) ? 'data-parent-values="' . implode(",",$parent) .'"' : ''); ?>
    >
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9" data-jsb-name="<?=$field?>" data-jsb-type="context" data-jsb-class="JsB">
        <input type="hidden" name="<?=$field?>" id="<?=$field?>" value='<?=$value?>' data-jsb-name="field" data-jsb-type="multiple" data-jsb-class="App.Timeline.Field" />

        <div class="form-inline">
            <div class="form-group">
                <input type="text" value="" data-jsb-name="time" class="form-control input-xsmall" placeholder="Hora" data-jsb-class="Input" />
            </div>
            <div class="form-group">
                <input type="text" value="" data-jsb-name="duration" class="form-control input-small" placeholder="Duração" data-jsb-class="Input" />
            </div>
            <div class="form-group">
                <input type="text" value="" data-jsb-name="plan" class="form-control input-xlarge" placeholder="Descrição" data-jsb-class="Input" />
            </div>
            <button type="button" class="btn default" data-jsb-name="save" data-jsb-class="App.Timeline.Save">
                <i class="fa fa-save"></i>
            </button>
        </div>

        <div class="timeline appender" data-jsb-name="items" data-jsb-type="appender" data-jsb-class="App.Timeline.Items">
            <div class="timeline-item template" data-jsb-name="item" data-jsb-class="JsB">
                <div class="timeline-time">
                    <strong data-jsb-name="time" data-jsb-class="JsB" ></strong>
                </div>
                <div class="timeline-body">
                    <div class="timeline-body-arrow"></div>
                    <div class="timeline-body-head">
                        <div class="timeline-body-head-caption">
                            Duração: <span class="timeline-body-time font-grey-cascade" data-jsb-name="duration" data-jsb-class="JsB"></span>
                        </div>
                        <div class="timeline-body-head-actions">
                            <div class="btn-group">
                                <button class="btn btn-circle green btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <?=$this->lang->line('actions')?> 
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a href="javascript:;" data-jsb-name="delete" data-jsb-class="App.Timeline.Items.Delete">
                                            <i class="fa fa-times"></i> <?=$this->lang->line('remove')?> 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-jsb-name="up" data-jsb-class="App.Timeline.Up">
                                            <i class="fa fa-arrow-circle-up"></i> <?=$this->lang->line('up')?> 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-jsb-name="down" data-jsb-class="App.Timeline.Down">
                                            <i class="fa fa-arrow-circle-down"></i> <?=$this->lang->line('down')?> 
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-body-content">
                        <p data-jsb-name="plan" data-jsb-class="JsB"></p>
                    </div>
                </div>
            </div>
        </div>

        <span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
		<?php if( isset( $help ) ) : ?>
		<span class="help-block no-error"><?=$help?></span>
		<?php endif ?>

    </div>
</div>


