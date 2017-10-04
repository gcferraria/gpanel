<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'option',
            'icon' => 'icon-globe',
            'form' => $category_option->form,
        ));
    ;
?>