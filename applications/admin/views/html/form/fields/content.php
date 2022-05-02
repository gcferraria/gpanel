<?php 
    if( (isset($url) and isset($attrs) and ( strpos($attrs, 'data-jsb-url') === false ) ) ) 
    {
        $url = 'data-jsb-url="'. $url[0];

        if( (isset($content_type) and isset($attrs) ) ) 
        {
            $url .= "?content_type=" . $content_type[0] ;
        }

        $url .= '"';
    }
?>

<div class="form-group<?php echo ( !empty( $parent_field ) )  ? ' hidden' : ''; ?>"
    <?php echo ( !empty( $parent_field ) ? 'data-parent="' . $parent_field .'"' : ''); ?>
    <?php echo ( !empty( $parent_field ) ? 'data-parent-values="' . implode(",",$parent) .'"' : ''); ?>
    >
    <label for="<?php echo $field; ?>" class="control-label col-md-3">
        <?php echo $label; ?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9 multicategory" data-jsb-name="<?php echo $field; ?>" data-jsb-type="context" data-jsb-class="JsB">
        <input type="text" 
            <?php echo ((isset($placeholder) and isset($attrs) and ( strpos($attrs, 'placeholder')  === false )) ? 'placeholder="' . $placeholder[0].'"' : ''); ?>
            <?php echo $url ?> <?php echo $attrs; ?>
            class="form-control input-xlarge" 
            data-jsb-class="App.Category.Selector" 
        />
        <input type="hidden" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $value; ?>" data-jsb-class="App.Category.Field" />
        <ul data-jsb-type="reseter" data-jsb-class="App.Category.Results" class="results">
            <li class="template results" data-jsb-class="App.Category.Results.Item">
                <span data-jsb-name="name" data-jsb-class="JsB"></span>
                <span data-jsb-name="path" data-jsb-class="JsB" class="path"></span>
            </li>
        </ul>
        <div class="fields" data-jsb-type="appender" data-jsb-class="App.Category.Container">
            <div class="template alert alert-info d-flex added-files clearfix" data-jsb-class="App.Category.Container.Item">    
                <div class="pull-left">
                    <span data-jsb-name="name" data-jsb-class="JsB"></span>
                    <span data-jsb-name="path" data-jsb-class="JsB" class="path"></span>
                </div>
        
                <div class="btn-group pull-right">
                    <button class="btn btn-circle green btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <?php echo lang('actions'); ?>
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li>
                            <a href="javascript:;" data-jsb-name="delete" data-jsb-class="App.Category.Delete">
                                <i class="fa fa-times"></i> <?php echo lang('remove'); ?> 
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-jsb-name="up" data-jsb-class="App.Category.Up">
                                <i class="fa fa-arrow-circle-up"></i> <?php echo lang('up'); ?> 
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-jsb-name="down" data-jsb-class="App.Category.Down">
                                <i class="fa fa-arrow-circle-down"></i> <?php echo lang('down'); ?> 
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <span class="help-block" for="<?php echo $field; ?>" data-jsb-name="error" data-jsb-class="JsB"></span>
        <?php if( isset( $help ) ) : ?>
        <span class="help-block no-error"><?php echo $help; ?></span>
        <?php endif ?>
    </div>
</div>