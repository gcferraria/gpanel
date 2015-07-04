<div class="portlet paddingless" data-jsb-name="last_activity" data-jsb-type="context" data-jsb-class="App.Portlet">
	<div class="portlet-title line">
		<div class="caption">
			<i class="fa fa-bell-o"></i> <?=$this->lang->line('dashboard_box_last_activity_title')?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
		</div>
	</div>
	<div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
		<div class="tabbable tabbable-custom">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#tab_1_1" data-toggle="tab"><?=$this->lang->line('dashboard_box_last_activity_contents')?></a>
				</li>
				<li class="">
					<a href="#tab_1_2" data-toggle="tab"><?=$this->lang->line('dashboard_box_last_activity_sessions')?></a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1_1">
					<div class="scroller" data-height="270" data-jsb-class="App.Scroll">
						<ul class="feeds">
							<?php foreach ( $dashboard->activity->contents as $content ) : ?>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-info">
												<i class="fa fa-plus"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												<span class="task-title-sp"><?=$content->name?></span>
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										<?=$content->publish?>
									</div>
								</div>
							</li>
							<?php endforeach?>
						</ul>
					</div>
				</div>
				<div class="tab-pane" id="tab_1_2">
					<div class="scroller" data-height="270" data-jsb-class="App.Scroll">
						<?php $i=0?>
						<?php foreach ( $dashboard->activity->sessions as $session ) : ?>
						<?php if( $i%2 == 0 ) : ?>
						<div class="row">
						<?php endif ?>
							<div class="col-md-6 user-info">
								<img alt="" src="<?=base_url('images/'.$session->avatar)?>" class="img-responsive">
								<div class="details">
									<div>
										<a href="#"><?=$session->name?></a>
										<span class="label label-sm label-info"><?=$session->browser?></span>
									</div>
									<div><?=$session->date?></div>
								</div>
							</div>
						<?php if( $i%2 == 1 ): ?>
						</div>
						<?php endif ?>
						<?php $i++?>
						<?php endforeach?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
