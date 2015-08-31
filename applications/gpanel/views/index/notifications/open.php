<div class="portlet" data-jsb-name="notifications" data-jsb-type="context" data-jsb-class="App.Portlet">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-bullhorn"></i><?=$notification->subject?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-jsb-name="collapse" data-jsb-class="App.Portlet.Collapse"></a>
		</div>
	</div>
	<div class="portlet-body" data-jsb-name="body" data-jsb-class="JsB">
		<div class="row">
			<div class="col-md-12">
				<?=$notification->body?>
			</div>
		</div>
	</div>
</div>