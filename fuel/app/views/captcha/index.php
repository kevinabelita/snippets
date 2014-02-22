<?php echo Asset::css('bootstrap.css'); ?>

<div class="container">
	<div class="row">
		<h1>Form Test</h1><hr/><br/>
		
		<form method="POST" action="<?php echo Uri::create('captcha/process_form'); ?>" class="form-horizontal" id="test_form" role="form">
		
			<!-- Validation Errors -->
			<?php if(Session::get_flash('wrong_captcha', false)): ?><div class="alert alert-danger"><p><?php echo Session::get_flash('wrong_captcha'); ?></p></div><?php endif; ?>
		
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-8">
					<input type="text" name="name" class="form-control" id="" placeholder="Enter text" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label"></label>
				<div class="col-sm-8">
					<div class="">
						<img src="<?php echo Uri::create('captcha/generate'); ?>" alt="" id="captcha_image" title="captcha_image" />
						<button type="button" class="btn btn-default btn-sm btn-info" id="regenerate"><span class="glyphicon glyphicon-refresh"></span></button>
					</div>
					<br/>
					<input type="text" name="uc" class="form-control" id="" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary btn-lg" form="test_form">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#regenerate').click(function(){
		var timestamp = new Date().getTime();
		var url = '<?php echo Uri::create('captcha/generate'); ?>/';
		$('#captcha_image').attr('src', url + timestamp).load(function(){
			
		});
	});
	
});
</script>