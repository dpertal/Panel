<div class="container-fluid">
	<div class="row-fluid">
		<div class="col-md-4 col-md-offset-4">	
				<form  method="POST" action="?action=login"  class="form-inline">
					<input type="hidden" name="token" value="<?php echo  Morfy::factory()->generateToken(); ?>">
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control">
					</div>
					<input type="submit" class="btn btn-primary" value="<?php echo $lang['Login']; ?>">
				</form>
		</div>
	</div>
</div>





