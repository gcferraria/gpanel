<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'content_type',
            'icon' => 'icon-settings',
            'form' => $content_type->form,
        ));
    ;
?>