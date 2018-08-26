<div data-jsb-name="statistics" data-jsb-class="App.DashBoard.Statistics" data-url="<?=$dashboard->statistics->url?>">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue">
			<div class="visual">
				<i class="fa fa-bullhorn"></i>
			</div>
			<div class="details">
				<div class="number" data-jsb-name="notifications" data-value="0" data-jsb-class="App.DashBoard.Statistics.Element">0</div>
				<div class="desc">
					<?=$this->lang->line('dashboard_notification_count')?>
				</div>
			</div>
	        <a class="more" href="<?=site_url('notifications')?>">
	            <?=$this->lang->line('view_more')?><i class="m-icon-swapright m-icon-white"></i>
	        </a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat red">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number" data-jsb-name="counters" data-value="0" data-jsb-class="App.DashBoard.Statistics.Element">0</div>
				<div class="desc">
					<?=$this->lang->line('dashboard_tops_count')?>
				</div>
			</div>
	        <a class="more" href="<?=site_url('categories/contents/index/1')?>">
	            <?=$this->lang->line('view_more')?><i class="m-icon-swapright m-icon-white"></i>
	        </a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat green">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number" data-jsb-name="contents" data-value="0" data-jsb-class="App.DashBoard.Statistics.Element">0</div>
				<div class="desc">
					<?=$this->lang->line('dashboard_content_count')?>
				</div>
			</div>
	        <a class="more" href="<?=site_url('categories/contents/index/1')?>">
	            <?=$this->lang->line('view_more')?><i class="m-icon-swapright m-icon-white"></i>
	        </a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-user"></i>
			</div>
			<div class="details">
				<div class="number" data-jsb-name="subscribers" data-value="0" data-jsb-class="App.DashBoard.Statistics.Element">0</div>
				<div class="desc">
					<?=$this->lang->line('dashboard_subscribers_count')?>
				</div>
			</div>
	        <a class="more" href="<?=site_url('newsletters/contacts')?>">
	            <?=$this->lang->line('view_more')?><i class="m-icon-swapright m-icon-white"></i>
	        </a>
		</div>
	</div>
</div>