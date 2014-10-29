<form class="panel_form panel_form_full" method="POST" action="<?php echo Panel::Root('panel');?>?updateFile=<?php echo $filename; ?>">
	<div class="form-group">
		<?php include_once('marckdown_editor.php'); ?>
	</div>

	<div class="form-group">
		<a href="<?php echo Panel::Root('panel');?>" class="btn btn-danger btn-sm"><?php echo $lang['Cancel'];?></a>
		<input type="submit" class="btn btn-primary btn-sm" value="<?php echo $lang['Update'];?>">
	</div>
</form>
