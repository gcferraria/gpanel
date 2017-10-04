<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'administrator',
            'icon' => 'icon-user',
            'form' => $administrator->form,
        ));
    ;
?>