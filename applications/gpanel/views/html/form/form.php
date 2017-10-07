<form method="<?=$method?>" action="<?=$action?>" <?=$attrs?> data-jsb-type="context" data-jsb-class="App.Form.Ajax" class="form-horizontal form-bordered form-row-stripped">
    <div class="form-body" data-jsb-name="fields" data-jsb-class="JsB">
        <?=$fields?>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" data-loading-text="Loading..." class="btn green" data-jsb-class="App.Form.Ajax.Submit">
                    <i class="fa fa-check"></i> <?=$lang->line('form_btn_submit')?>
                </button>
                <button type="button" class="btn default"><?=$this->lang->line('cancel')?></button>
            </div>
        </div>
    </div>
</form>
