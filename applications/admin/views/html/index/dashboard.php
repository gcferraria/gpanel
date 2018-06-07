<div class="row">
	<?php $this->load->view('html/index/dashboard/_statistics')?>
</div>

<div class="clearfix"></div>

<div class="row">
	<div class="col-md-6 col-sm-6">
		<?php $this->load->view('html/index/dashboard/_visits')?>
	</div>
	<div class="col-md-6 col-sm-6">
		<?php $this->load->view('html/index/dashboard/_last_activity')?>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-sm-6">
		<?php $this->load->view('html/index/dashboard/_browsers')?>
    </div>
    <div class="col-md-6 col-sm-6">
		<?php $this->load->view('html/index/dashboard/_devices')?>
    </div>
</div>
