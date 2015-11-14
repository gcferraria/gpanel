<form method="<?=$method?>" action="<?=$action?>" <?=$attrs?> data-jsb-type="context" data-jsb-name="form" data-jsb-class="App.Form.Multistep" class="form-horizontal">
    <input type="hidden" name="steps" id="steps" value="<?=count( $steps )?>" />

    <div class="form-wizard">
        <div class="form-body" data-jsb-name="fields" data-jsb-class="JsB">

            <ul class="nav nav-pills nav-justified steps">
                <?php for ( $i = 1; $i <= count( $steps ); $i++ ) { ?>
                <li<?=( ( $i==1) ? ' class="active"' : '')?>>
                    <a href="#tab<?=$i?>" data-toggle="tab" class="step">
                        <span class="number"><?=$i?> </span>
                        <span class="desc"><i class="fa fa-check"></i><?=$steps[$i-1]['title']?></span>
                    </a>
                </li>
                <?php } ?>
            </ul>

            <div id="bar" class="progress progress-striped" role="progressbar">
                <div class="progress-bar progress-bar-success"></div>
            </div>

            <div class="tab-content">
                <?php for ( $i = 1; $i <= count( $steps ); $i++ ) { ?>
                <div class="tab-pane<?=($i==1 ? ' active': '')?>" id="tab<?=$i?>">
                    <h3 class="block"><?=$steps[$i-1]['title']?></h3>
                    <?php if( !empty( $steps[$i-1]['fields'] ) ) : ?>
                    <?=$fields[$i-1]?>
                    <?php endif ?>
                </div>
                <?php } ?>
            </div>

        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <a href="javascript:;" data-loading-text="Loading..." class="btn default button-previous hide" data-jsb-name="previous" data-jsb-class="App.Form.Multistep.Navigation">
                        <i class="m-icon-swapleft"></i> <?=$this->lang->line('previous')?>
                    </a>
                    <a href="javascript:;" data-loading-text="Loading..." class="btn blue-madison button-next" data-jsb-name="next" data-jsb-class="App.Form.Multistep.Navigation">
                        <?=$this->lang->line('next')?> <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                    <button type="submit" data-loading-text="Loading..." class="btn green-haze hide" data-jsb-class="App.Form.Multistep.Submit">
                        <?=$lang->line('form_btn_submit')?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
