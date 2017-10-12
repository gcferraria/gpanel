<?php 
    $_REQUEST['load_media_modal'] = TRUE;
    $this->load->view('html/portlets/form.php', array(
        'name' => 'content',
        'icon' => 'icon-globe',
        'form' => $content->form,
    ));
?>