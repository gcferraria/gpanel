<?php 
    echo 
        $this->load->view('html/portlets/form.php', array(
            'name' => 'newsletter',
            'icon' => 'icon-envelope',
            'form' => $newsletter->form,
        ));
    ;
?>