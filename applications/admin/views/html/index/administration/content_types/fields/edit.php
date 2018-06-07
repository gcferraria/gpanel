<?php 
    $this->load->view('html/portlets/form.php', array(
        'name' => 'content_type_field',
        'icon' => 'icon-settings',
        'form' => $content_type_field->form,
    ));
?>