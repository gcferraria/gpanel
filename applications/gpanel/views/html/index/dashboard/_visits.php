<div class="portlet light bordered" data-jsb-name="visits" data-jsb-type="context" data-jsb-class="App.Portlet">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-bar-chart font-red-sunglo"></i> 
			<span class="caption-subject font-red-sunglo bold uppercase"> <?=$this->lang->line('dashboard_box_visits_title')?></span>
			<span class="caption-helper"><?=$this->lang->line('dashboard_box_visits_subtitle')?></span>
		</div>
		<div class="actions">
	        <div class="btn-group pull-right">
				<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
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
			<div class="btn-group btn-group-circle" data-toggle="buttons" data-jsb-name="metrics" data-jsb-class="JsB">
				<label class="btn grey-salsa btn-sm active" data-jsb-class="App.Chart.Metric">
					<input type="radio" name="options" class="toggle" value="visits"><?=$this->lang->line('dashboard_box_visits_visits')?>
				</label>
				<label class="btn grey-salsa btn-sm" data-jsb-class="App.Chart.Metric">
					<input type="radio" name="options" class="toggle" value="uniquepageviews"><?=$this->lang->line('dashboard_box_visits_unique_page_views')?> 
				</label>
				<label class="btn grey-salsa btn-sm" data-jsb-class="App.Chart.Metric">
					<input type="radio" name="options" class="toggle" value="pageviews"><?=$this->lang->line('dashboard_box_visits_page_views')?>
				</label>
			</div>
		</div>
        <div class="chart" data-jsb-name="chart" data-metric="visits" data-profile="<?=$dashboard->domains[key($dashboard->domains)]?>" data-url="<?=$dashboard->visits->url?>" data-jsb-class="App.Chart" ></div>
	</div>
</div>