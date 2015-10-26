<div class="portlet paddingless" data-jsb-name="last_activity" data-jsb-type="context" data-jsb-class="App.Portlet">
	<div class="portlet-title line">
		<div class="caption">
			<i class="fa fa-bell-o"></i> <?=$this->lang->line('dashboard_box_last_activity_title')?>
		</div>
		<div class="tools">
		    <a href="" class="collapse" data-jsb-name="collapse" title="<?=$this->lang->line('collapse')?>" data-jsb-class="App.Portlet.Collapse"></a>
        </div>
	</div>
	<div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
		<div class="tabbable-line">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#tab_1_1" data-toggle="tab"><?=$this->lang->line('dashboard_box_last_activity_contents')?></a>
				</li>
				<li class="">
					<a href="#tab_1_2" data-toggle="tab"><?=$this->lang->line('dashboard_box_last_activity_sessions')?></a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active tasks-widget" id="tab_1_1">
					<div class="scroller" data-height="280" data-jsb-class="App.Scroll">
						<ul class="task-list">
							<?php foreach ( $dashboard->activity->contents as $content ) : ?>
							<li>
                                <div class="task-checkbox"></div>
                                <div class="task-title"><span class="task-title-sp"><?=$content->name?></span> <span class="label label-sm label-info"><?=$content->publish?></span></div>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group">
                                        <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <?php foreach ( $content->categories as $category ) : ?>
                                            <li>
                                                <a href="<?=$category->link?>" title="<?=$category->name?>">
                                                    <i class="fa fa-pencil"></i> <?=$category->name?> 
                                                </a>
                                            </li>
                                            <?php endforeach ?>
                                        </ul>
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
								<img alt="<?=$session->name?>" src="<?=base_url('images/'.$session->avatar)?>" class="img-responsive">
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
