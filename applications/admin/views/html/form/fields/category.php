<?php 
    $primary = isset( $primary );
?>

<div class="form-group">
    <label for="<?=$field?>" class="control-label col-md-3">
        <?=$label?>
        <?php if( $required ) { ?> <span class="required">*</span> <?php } ?>
    </label>
    <div class="col-md-9 multicategory" data-jsb-name="<?=$field?>" data-jsb-type="context" data-jsb-class="JsB">
        <input type="text" 
            <?=((isset($placeholder) and isset($attrs) and ( strpos($attrs, 'placeholder')  === false )) ? 'placeholder="' . $placeholder[0].'"' : '')?> 
            <?=((isset($url)         and isset($attrs) and ( strpos($attrs, 'data-jsb-url') === false )) ? 'data-jsb-url="'. $url[0]        .'"' : '')?>
            <?=$attrs?> 
            class="form-control input-xlarge" data-jsb-class="App.Category.Selector" />
        <?php if ( $primary ) : ?>
        <input type="hidden" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" data-jsb-type="primary" data-jsb-class="App.Category.Field" />
        <?php else : ?>
        <input type="hidden" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>" data-jsb-class="App.Category.Field" />
        <?php endif ?>
        <ul data-jsb-type="reseter" data-jsb-class="App.Category.Results" class="results">
            <li class="template results" data-jsb-class="App.Category.Results.Item">
                <span data-jsb-name="name" data-jsb-class="JsB"></span>
                <span data-jsb-name="path" data-jsb-class="JsB" class="path"></span>
            </li>
        </ul>
        <ul class="fields multicategory" data-jsb-type="appender" data-jsb-class="App.Category.Container">
            <li class="template clearfix fields multicategory" data-jsb-class="App.Category.Container.Item">
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
                <?php if ( $primary ) : ?>
                <span data-jsb-class="App.Category.Primary" class="icon">
                    <i class="star glyphicon glyphicon-star-empty"></i>
                </span>
                <?php endif ?>
            </li>
        </ul>
        <span class="help-block" for="<?=$field?>" data-jsb-name="error" data-jsb-class="JsB"></span>
        <?php if( isset( $help ) ) : ?>
        <span class="help-block no-error"><?=$help?></span>
        <?php endif ?>
    </div>
</div>