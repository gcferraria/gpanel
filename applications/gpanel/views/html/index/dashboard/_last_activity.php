<div class="portlet light bordered" data-jsb-name="last_activity" data-jsb-type="context" data-jsb-class="App.Portlet">
	<div class="portlet-title tabbable-line">
		<div class="caption">
			<i class="icon-globe font-green-sharp"></i> 
			<span class="caption-subject font-green bold uppercase">
				<?=$this->lang->line('dashboard_box_last_activity_title')?>	
			</span>
		</div>
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_1_1" data-toggle="tab" class="uppercase"><?=$this->lang->line('dashboard_box_last_activity_contents')?></a>
			</li>
			<li class="">
				<a href="#tab_1_2" data-toggle="tab" class="uppercase"><?=$this->lang->line('dashboard_box_last_activity_sessions')?></a>
			</li>
		</ul>
	</div>
	<div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
		<div class="tab-content">
			<div class="tab-pane active tasks-widget" id="tab_1_1">
				<div class="scroller" data-height="340" data-jsb-class="App.Scroll">
					<ul class="feeds">
						<?php foreach ( $dashboard->activity->contents as $content ) : ?>
						<li>
						<div class="col1">
							<div class="cont">
								<div class="cont-col1">
	                                <div class="label label-sm label-warning">
	                                    <i class="fa fa-plus"></i>
	                                </div>
	                            </div>
								<div class="cont-col2">
									<div class="desc">
										<?=word_limiter($content->name,7)?>
										<?php foreach ( $content->categories as $category ) : ?>
	                                    <a href="<?=$category->link?>" title="<?=$category->name?>" class="label label-sm label-default"><?=$category->name?></a>    
	                                    <?php endforeach ?>
	                                    <a href="javascript:;" title="<?=$content->creator?>" data-jsb-class="Tooltip">
                                            <span class="icon-user"></i>
                                        </a>
                                    </div>
								</div>
							</div>
						</div>
						<div class="col2">
							<div class="date"><?=$content->publish?></div>
						</div>
						</li>
						<?php endforeach?>
					</ul>
				</div>
			</div>
			<div class="tab-pane" id="tab_1_2">
				<div class="scroller" data-height="340" data-jsb-class="App.Scroll">
					<?php 
						$count   = 1;
						$columns = 2;
					?>
					<?php foreach ( $dashboard->activity->sessions as $session ) : ?>

						<?php if ( $count%$columns == 1 ) : ?>
						<div class="row">
						<?php endif ?>

						<?php 
							$cols = ( count($dashboard->activity->sessions) > $columns ) ? 12 / $columns  : 12 / count($dashboard->activity->sessions);
						?>
						<div class="col-md-<?=$cols?> col-sm-<?=$cols?>">
							<img alt="<?=$session->name?>" src="<?=base_url('img/'.$session->avatar)?>" class="img-responsive">
							<div class="details">
								<div>
									<a href="#"><?=$session->name?></a>
									<span class="label label-sm label-info"><?=$session->browser?></span>
								</div>
								<div><?=$session->date?></div>
							</div>
						</div>

						<?php if ( $count%$columns == 0 || $count == count($dashboard->activity->sessions) ) : ?>
						</div>
						<?php endif ?>

					<?php $count++;?>
					<?php endforeach?>
				</div>
			</div>
		</div>
	</div>
</div>