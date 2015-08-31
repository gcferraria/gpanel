<div class="row">
	<?=$this->load->view('index/dashboard/_statistics')?>
</div>

<div class="clearfix"></div>

<div class="row">
	<div class="col-md-6 col-sm-6">
		<?=$this->load->view('index/dashboard/_visits')?>
	</div>
	<div class="col-md-6 col-sm-6">
		<?=$this->load->view('index/dashboard/_last_activity')?>
	</div>
	<div class="col-md-6 col-sm-6">
		<?=$this->load->view('index/dashboard/_browsers')?>
    </div>
    <div class="col-md-6 col-sm-6">
		<?=$this->load->view('index/dashboard/_general_stats')?>
    </div>
</div>
