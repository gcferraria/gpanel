<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'contact',
            'icon' => 'icon-user-following',
            'form' => $newsletter_contact->form,
        ));
    ;
?>