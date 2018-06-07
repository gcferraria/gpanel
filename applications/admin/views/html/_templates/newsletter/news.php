<table border="0" width="100%" cellpadding="10" cellspacing="0" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-style: normal;font-variant: normal;font-weight: normal;">
    <?php if ( isset( $new ) ) : ?>
    <tr>
        <td align="left" colspan="2">
            <h1 style="color:#666666;font-size:14px;text-transform:uppercase;">
                <strong>Notícias</strong>
            </h1>
        </td>
    </tr>
    <?php foreach ( $new as $item ) : ?>
    <tr>
        <td align="left" width="200px">
            <a href="<?=$item['url']?>" target="_blank" style="border-style: none;">
                <img src="<?=static_url( $item['image'] )?>" border="0" width="295" alt="" />
            </a>
        </td>
        <td align="left" style="vertical-align: top;">
            <h2 style="color:#333;font-size:12px;"><strong><?=$item['title']?></strong></h2>
            <p><?=$item['lead']?></p>
        </td>
    </tr>
    <?php endforeach ?>
    <?php endif ?>
    <?php if ( isset( $event ) ) : ?>
    <tr>
        <td align="left" colspan="2">
            <h1 style="color:#666666;font-size:14px;text-transform:uppercase;text-align:left">
                <strong>Agenda</strong>
            </h1>
        </td>
    </tr>
    <?php foreach ( $event as $item ) : ?>
    <tr>
        <td align="left" width="200px">
            <a href="<?=$item['url']?>" target="_blank" style="border-style: none;">
                <img src="<?=static_url( $item['image'] )?>" width="295" alt="" />
            </a>
        </td>
        <td align="left" style="vertical-align: top;">
            <h2 style="color:#333;font-size:12px;"><strong><?=$item['title']?></strong></h2>
            <p><?=$item['lead']?></p>
        </td>
    </tr>
    <?php endforeach ?>
    <?php endif ?>

</table>

<small>
	Esta comunicação foi enviada automaticamente.<br />
	Por favor não responda a este e-mail.Para mais esclarecimentos sobre esta comunicação será necessário contactar o ordenante da operação.<br />
    Para remover a sua subscrição, envie um email para <a href="mailto:geral@jf-castelo.pt">geral@jf-castelo.pt</a>.
</small>
