<div class="portlet light" data-jsb-name="category" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption font-red-sunglo">
            <i class="fa fa-globe font-red-sunglo"></i> <?=$title?>
        </div>
    </div>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <div class="form">
            <div class="note note-warning">
                <h4 class="block"><?=$category->warning_title?></h4>
                <ol>
                    <li><?=$category->warning_step1?></li>
                    <li><?=$category->warning_step2?></li>
                    <li><?=$category->warning_step3?></li>
                </ol>
            </div>
            <?=$category->form?>
        </div>
    </div>
</div>

