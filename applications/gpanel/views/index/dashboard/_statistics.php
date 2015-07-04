<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="dashboard-stat blue-madison">
		<div class="visual">
			<i class="fa fa-bullhorn"></i>
		</div>
		<div class="details">
			<div class="number">
				<?=$dashboard->statistics->notifications?>
			</div>
			<div class="desc">
				<?=$this->lang->line('dashboard_notification_count')?>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="dashboard-stat red-intense">
		<div class="visual">
			<i class="fa fa-bar-chart-o"></i>
		</div>
		<div class="details">
			<div class="number">
				<?=$dashboard->statistics->counters?>
			</div>
			<div class="desc">
				<?=$this->lang->line('dashboard_tops_count')?>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="dashboard-stat green-haze">
		<div class="visual">
			<i class="fa fa-bar-chart-o"></i>
		</div>
		<div class="details">
			<div class="number">
				<?=$dashboard->statistics->contents?>
			</div>
			<div class="desc">
				<?=$this->lang->line('dashboard_content_count')?>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="dashboard-stat purple-plum">
		<div class="visual">
			<i class="fa fa-user"></i>
		</div>
		<div class="details">
			<div class="number">
				<?=$dashboard->statistics->users?>
			</div>
			<div class="desc">
				<?=$this->lang->line('dashboard_users_count')?>
			</div>
		</div>
	</div>
</div>
