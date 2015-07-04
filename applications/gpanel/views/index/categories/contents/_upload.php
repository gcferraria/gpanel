<div id="upload" class="modal fade" tabindex="-1" role="dialog" data-jsb-class="App.Modal.Upload">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selecção de Ficheiro Multimédia</h4>
            </div>
            <div class="modal-body">
                <?=$this->load->view('tables/datatable.php')?>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Fechar</button>
                <button type="button" class="btn blue" data-jsb-class="App.Modal.Upload.Save">Gravar</button>
            </div>
        </div>
    </div>
</div>