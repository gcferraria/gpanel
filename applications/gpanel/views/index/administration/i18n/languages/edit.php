<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'language',
            'icon' => 'icon-flag',
            'form' => $form,
        ));
    ;
?>