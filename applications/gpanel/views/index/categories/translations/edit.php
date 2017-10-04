<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'translation',
            'icon' => 'icon-flag',
            'form' => $form,
        ));
    ;
?>