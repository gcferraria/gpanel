<form method="<?=$method?>" action="<?=$action?>" <?=$attrs?> data-jsb-type="context" data-jsb-class="App.Form.Ajax" class="form-horizontal form-bordered form-row-stripped">
    <div class="form-body" data-jsb-name="fields" data-jsb-class="JsB">
        <?=$fields?>
    </div>
    <div class="form-actions fluid">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" data-loading-text="Loading..." class="btn green-haze" data-jsb-class="App.Form.Ajax.Submit">
                <?=$lang->line('form_btn_submit')?>
            </button>
        </div>
    </div>
</form>