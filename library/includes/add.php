<form class="form" method="POST" action="<?php echo Panel::Root('panel');?>?saveFile=<?php echo $filename; ?>">
	<input type="hidden" name="token" value="' . Morfy::factory()->generateToken() . '">

	<div class="row p0">
		<div class="col-md-6">
			<div class="form-group">
				<label><?php echo $lang['Name'];?>:</label>	
				<input type="text" name="filename" class="form-control" value="<?php echo $filename; ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Select Folder</label>
				<select name="foldername" id="folder" class="form-control">
					<option>Select Folder</option>
					<option value="isBlog">Blog</option>
					<option value="isPortfolio">Portfolio</option>
				</select>
				<script>
					window.addEventListener('load',function(){
						var folder = document.querySelector('#folder');
						folder.addEventListener('change',function(){
							this.name = this.value;
							console.log(this.name);
						});
					});
				</script>
			</div>
		</div>
	</div>

	<div class="form-group">
		<?php include_once('marckdown_editor.php'); ?>
	</div>

	<div class="form-group">
		<a href="<?php echo Panel::Root('panel');?>" class="btn btn-danger btn-sm"><?php echo $lang['Cancel'];?></a>
		<input type="submit" id="demo" class="btn btn-primary btn-sm" value="<?php echo $lang['Save'];?>">
	</div>
</form>
