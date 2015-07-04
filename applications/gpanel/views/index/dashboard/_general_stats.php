<div class="portlet box red-sunglo" data-jsb-name="general_stats" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
		<div class="caption">
			<i class="fa fa-calendar"></i> <?=$this->lang->line('dashboard_box_general_stats_title')?>
		</div>
		<div class="actions">
			<a href="javascript:;" class="btn btn-sm btn-default easy-pie-chart-reload" data-jsb-name="reload" data-jsb-class="App.Portlet.Reload">
				<i class="fa fa-repeat"></i> <?=$this->lang->line('dashboard_box_general_stats_refresh')?>
			</a>
			<div class="btn-group pull-right">
				<ul class="dropdown-menu pull-right">
					<?php foreach( $dashboard->domains as $domain => $profile ) : ?>
                    <li>
						<a href="javascript:;" id="<?=$profile?>" data-jsb-class="App.Chart.Profile"><?=$domain?></a>
					</li>
                    <?php endforeach ?>
				</ul>
				<a href="" class="btn btn-sm btn-default" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<?=$this->lang->line('dashboard_box_visits_site_choise')?>
					<span class="fa fa-angle-down"></span>
				</a>
			</div>
		</div>
	</div>
	<div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
		<div class="row" data-jsb-name="chart" data-metric="visits" data-profile="<?=$dashboard->domains[key($dashboard->domains)]?>" data-url="<?=$dashboard->visits->url?>" data-jsb-class="App.Chart" >
			<div class="col-md-4">
				<div class="easy-pie-chart">
					<div class="number transactions" data-percent="55">
						<span>+55 </span>%
						<canvas height="75" width="75"></canvas></div>
						<a class="title" href="#">
						Transactions <i class="icon-arrow-right"></i>
						</a>
				</div>
			</div>
			<div class="margin-bottom-10 visible-sm">
			</div>
		</div>
	</div>
</div>