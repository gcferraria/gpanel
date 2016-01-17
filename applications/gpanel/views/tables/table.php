<div class="table-responsive">
    <table class="table table-striped table-bordered table-advance table-hover">
        <thead>
            <tr>
                <?php foreach ( $table->header as $name ) : ?>
                <?php if( is_array($name) ) : ?>
                <th class="<?=$name['classes']?>"><?=$name['text']?></th>
                <?php else : ?>
                <th><?=$name?></th>
                <?php endif ?>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $table->contents as $content ) : ?>
            <tr>
                <?php foreach ( $content as $value ) : ?>
                <td><?=$value?></td>
                <?php endforeach ?>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>