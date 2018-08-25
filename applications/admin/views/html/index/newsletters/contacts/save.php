<?php 
    $this->load->view('html/portlets/form.php', array(
        'name' => 'contact',
        'icon' => 'icon-user-following',
        'form' => $newsletter_contact->form,
    ));
?>