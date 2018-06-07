<div id="assets-modal" class="modal fade" role="dialog" data-jsb-name="upload" data-jsb-type="context" data-jsb-class="App.Modal.Assets">
    <div class="modal-dialog">
        <div class="modal-content scroller" data-jsb-name="content" data-height="100%" data-always-visible="1" data-rail-visible="0" data-jsb-class="App.Scroll">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4>Media</h4>
            </div>
            <div class="modal-body">
                <?php 
                    $this->load->view('html/tables/assets.php')
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal" class="btn dark btn-outline"><?=$this->lang->line('close')?></button>
                <button type="button" class="btn green" data-jsb-class="App.Modal.Assets.Save"><?=$this->lang->line('save')?></button>
            </div>
        </div>
    </div>
</div>