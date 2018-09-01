<?php 
    $this->load->view('html/portlets/form.php', array(
        'name' => 'template',
        'icon' => 'icon-wrench',
        'form' => $template->form,
    ));
?>