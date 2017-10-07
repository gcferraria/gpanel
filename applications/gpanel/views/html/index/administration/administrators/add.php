<?php 
   	$this->load->view('html/portlets/form.php', array(
        'name' => 'administrator',
        'icon' => 'icon-user',
        'form' => $administrator->form,
    ));
?>