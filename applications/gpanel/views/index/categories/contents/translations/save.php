<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'translation',
            'icon' => $icon,
            'form' => $form,
        ));
    ;
?>
<?=$this->load->view('index/categories/contents/_upload', array( 'table' => $table ) )?>