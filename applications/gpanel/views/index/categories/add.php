<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'category',
            'icon' => 'icon-globe',
            'form' => $form,
        ));
    ;
?>