<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'website',
            'icon' => 'icon-puzzle',
            'form' => $form,
        ));
    ;
?>