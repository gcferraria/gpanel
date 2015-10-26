<div class="portlet solid bordered grey-cararra" data-jsb-name="visits" data-jsb-type="context" data-jsb-class="App.Portlet">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-bar-chart-o"></i> <?=$this->lang->line('dashboard_box_visits_title')?>
		</div>
		<div class="actions">
	        <div class="btn-group pull-right">
				<a href="" class="btn grey-steel btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<?=$this->lang->line('dashboard_site_choise')?>
					<span class="fa fa-angle-down"></span>
				</a>
				<ul class="dropdown-menu pull-right">
					<?php foreach( $dashboard->domains as $domain => $profile ) : ?>
                    <li>
						<a href="javascript:;" id="<?=$profile?>" data-jsb-class="App.Chart.Profile"><?=$domain?></a>
					</li>
                    <?php endforeach ?>
				</ul>
			</div>
		</div>
    </div>
	<div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
		<div class="btn-toolbar margin-bottom-10">
			<div class="btn-group" data-toggle="buttons" data-jsb-name="metrics" data-jsb-class="JsB">
				<label class="btn grey-steel btn-sm active" data-jsb-class="App.Chart.Metric">
					<input type="radio" name="options" class="toggle" id="metric" value="visits"><?=$this->lang->line('dashboard_box_visits_visits')?>
				</label>
				<label class="btn grey-steel btn-sm" data-jsb-class="App.Chart.Metric">
					<input type="radio" name="options" class="toggle" id="metric" value="unique_pageviews"><?=$this->lang->line('dashboard_box_visits_unique_page_views')?> 
				</label>
				<label class="btn grey-steel btn-sm" data-jsb-class="App.Chart.Metric">
					<input type="radio" name="options" class="toggle" id="metric" value="pageviews"><?=$this->lang->line('dashboard_box_visits_page_views')?>
				</label>
			</div>
		</div>
        <div class="chart" data-jsb-name="chart" data-metric="visits" data-profile="<?=$dashboard->domains[key($dashboard->domains)]?>" data-url="<?=$dashboard->visits->url?>" data-jsb-class="App.Chart" ></div>
	</div>
</div>
