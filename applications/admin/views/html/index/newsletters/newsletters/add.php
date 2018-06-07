<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'newsletter',
            'icon' => 'icon-envelope',
            'form' => $newsletter->form,
        ));
    ;
?>