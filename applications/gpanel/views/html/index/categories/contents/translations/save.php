<?php 
    $_REQUEST['load_media_modal'] = TRUE;
    $this->load->view('html/portlets/form.php', array(
        'name' => 'translation',
        'icon' => $icon,
        'form' => $form,
    ));
?>