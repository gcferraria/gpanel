<?php 
    echo 
        $this->load->view('html/portlets/form.php', array(
            'name' => 'newsletter',
            'icon' => 'icon-layers',
            'form' => $newsletter->form,
        ));
    ;
?>