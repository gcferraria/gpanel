<div class="portlet light bordered" data-jsb-name="browsers" data-jsb-type="context" data-jsb-class="App.Portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-bar-chart font-purple"></i> 
            <span class="caption-subject font-purple bold uppercase"><?=$this->lang->line("dashboard_box_browsers_title")?></span>
        </div>
        <div class="actions">
            <a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload" data-jsb-name="reload" title="<?=$this->lang->line('reload')?>" data-jsb-class="App.Portlet.Reload">
            <i class="fa fa-repeat"></i> <?=$this->lang->line("reload")?></a>
            <div class="btn-group">
                <a class="btn green btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
					<?=$this->lang->line('dashboard_site_choise')?> <i class="fa fa-angle-down"></i>
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
	<?php reset( $dashboard->domains ) ?>
    <div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
        <div class="row" data-jsb-name="chart" data-metric="sessions" data-profile="<?=$dashboard->domains[key($dashboard->domains)]?>" data-url="<?=$dashboard->browsers->url?>" data-profile="" data-jsb-class="App.PieChart">
            <div class="col-md-4">
                <div class="easy-pie-chart">
                    <div class="number" data-color="green" data-jsb-class="App.PieChart.Object" data-percent="0">
                        <span>0</span>%
                    </div>
                    <a class="title" href="javascript:;"></a>
                </div>
            </div>
            <div class="margin-bottom-10 visible-sm"></div>
            <div class="col-md-4">
                <div class="easy-pie-chart">
                    <div class="number" data-color="yellow" data-jsb-class="App.PieChart.Object" data-percent="0">
                        <span>0</span>%
                    </div>
                    <a class="title" href="javascript:;"></a>
                </div>
            </div>
            <div class="margin-bottom-10 visible-sm"></div>
            <div class="col-md-4">
                <div class="easy-pie-chart">
                    <div class="number" data-color="red" data-jsb-class="App.PieChart.Object" data-percent="0">
                        <span>0</span>%
                    </div>
                    <a class="title" href="javascript:;"></a>
                </div>
            </div>
        </div>
    </div>
</div>
