<?php 
    echo 
        $this->load->view('portlets/form.php', array(
            'name' => 'content',
            'icon' => 'icon-globe',
            'form' => $content->form,
        ));
    ;
?>
<?=$this->load->view('index/categories/contents/_upload', array( 'table' => $table ) )?>
