<div class="modal fade" tabindex="-1" role="dialog" data-jsb-name="upload" data-jsb-class="App.Modal.Upload">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selecção de Ficheiro Multimédia</h4>
            </div>
            <div class="modal-body">
                <?php 
                    $this->load->view('html/tables/datatable.php')
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline"><?=$this->lang->line('close')?></button>
                <button type="button" class="btn green" data-jsb-class="App.Modal.Upload.Save"><?=$this->lang->line('save')?></button>
            </div>
        </div>
    </div>
</div>
