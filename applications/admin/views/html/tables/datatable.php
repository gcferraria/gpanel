<table 
        class="table table-striped table-bordered table-hover <?=( isset( $table->showAll ) ? 'table-checkable' : '') ?> order-column" 
        data-source="/<?=$table->source?>" 
        data-jsb-name="table" 
        data-jsb-type="context" 
        data-jsb-class="App.DataTable"
    >
    <thead>
        <tr>
            <?php if( isset( $table->showAll ) ) : ?>
            <th>
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline" data-jsb-name="selectAll" data-jsb-class="JsB">
                    <input type="checkbox" class="group-checkable" data-jsb-class="CheckBox"  />
                    <span></span>
                </label>
            </th>
            <?php endif ?>

            <?php foreach ( $table->header as $name ) : ?>
            <?php if( is_array($name) ) : ?>
            <th class="<?=$name['classes']?>"><?=$name['text']?></th>
            <?php else : ?>
            <th><?=$name?></th>
            <?php endif ?>
            <?php endforeach ?>

            <?php if ( isset( $table->languages ) && count( $table->languages ) > 1 ) : ?>
            <th>
            <?php foreach ( $table->languages as $language ) : ?>
                <?php if( !$language->default ) : ?>
                <img src="<?=base_url($this->config->item('i18n_flags_path') . $language->country .'.png')?>" alt="<?=$language->code?>" />
                <?php endif ?>
            <?php endforeach ?>
            </th>
            <?php endif ?>

            <?php if( !isset( $table->noActions ) ) : ?>
            <th width="17%" name="actions" data-jsb-name="actions" data-jsb-class="JsB"><?=$this->lang->line('operations')?></th>
            <?php endif ?>

        </tr>
    </thead>
    <tbody></tbody>
</table>