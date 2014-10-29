<div class="container-fluid">
	<div class="row-fluid">
		<h5><?php echo $lang['Full images'];?></h5>
		<?php Panel::showFullImg(Panel::Config(Morfy::$config['Panel_Images'],'full'),'300','200'); ?>
	</div>
</div>

<span class="clearfix divider"></span>


<div class="container-fluid">
	<div class="row-fluid">
		<h5><?php echo $lang['Thumbnails'];?></h5>
		<?php Panel::showFullImg(Panel::Config(Morfy::$config['Panel_Thumbnails'],'tumb')); ?>
	</div>
</div>