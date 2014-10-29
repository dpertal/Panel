<form class="form" method="POST" action="<?php echo Panel::Root('panel');?>?saveFile=<?php echo $filename; ?>">
	<input type="hidden" name="token" value="' . Morfy::factory()->generateToken() . '">

	<div class="form-group">
		<label><?php echo $lang['Name'];?>:</label>	
		<input type="text" name="filename" class="form-control" value="<?php echo $filename; ?>">
	</div>

	<div class="form-group">
		<label class="checkbox-inline">
	      <input name="isBlog" type="checkbox"> <?php echo $lang['Check this if is a blog'];?>
	  </label>
	</div>

	<div class="form-group">
		<?php include_once('marckdown_editor.php'); ?>
	</div>

	<div class="form-group">
		<a href="<?php echo Panel::Root('panel');?>" class="btn btn-danger btn-sm"><?php echo $lang['Cancel'];?></a>
		<input type="submit" id="demo" class="btn btn-primary btn-sm" value="<?php echo $lang['Save'];?>">
	</div>
</form>
