<div class="form-group">
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9 multicategory" data-jsb-name="<?=$field?>" data-jsb-type="context" data-jsb-class="JsB">
        <input type="text" <?=$attrs?> class="form-control input-xlarge" data-jsb-class="App.Category.Selector" />
        <input type="hidden" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" data-jsb-class="App.Category.Field" />
        <ul data-jsb-type="reseter" data-jsb-class="App.Category.Results" class="results">
            <li class="template results" data-jsb-class="App.Category.Results.Item">
                <span data-jsb-name="name" data-jsb-class="JsB"></span>
                <span data-jsb-name="path" data-jsb-class="JsB" class="path"></span>
            </li>
        </ul>
        <ul class="fields multicategory" data-jsb-type="appender" data-jsb-class="App.Category.Container">
            <li class="template clearfix fields multicategory" data-jsb-class="JsB">
                <span data-jsb-name="name" data-jsb-class="JsB"></span>
                <span data-jsb-name="path" data-jsb-class="JsB" class="path"></span>
                <span data-jsb-class="App.Category.Delete" class="icon">
                    <i class="fa fa-trash-o"></i>
                </span>
                <span data-jsb-class="App.Category.Down" class="icon">
                    <i class="fa fa-arrow-circle-down"></i>
                </span>
                <span data-jsb-class="App.Category.Up" class="icon">
                    <i class="fa fa-arrow-circle-up"></i>
                </span>
            </li>
        </ul>
        <span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
        <?php if( isset( $help ) ) : ?>
        <span class="help-block no-error"><?=$help?></span>
        <?php endif ?>
    </div>
</div>