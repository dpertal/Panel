<div class="clearfix"></div>		
	
<?php Panel::uploadImages(); ?>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="col-md-6">

			<form class="form" method="post"   enctype="multipart/form-data">

				<div class="form-group">
					<label>Chosse a Image file: </label>
					<input type="file"  class="upload" name="file_upload" id="image-input" />
				</div>

				<div class="form-group">
					<label>Name: </label>
					<input type="text" class="form-control" name="name" id="name" placeholder="The name of image">
				</div>

				<div class="form-group">
					<label>With: </label>
					<input type="text" class="form-control" name="width" id="width" value="250">
				</div>

				<div  class="form-group">
					<label>Height: </label>
					<input type="text" class="form-control" name="height" id="height" value="180">
				</div>

				<div  class="form-group">
					<label>Options: </label>
					<select name="options" id="options" class="form-control">
						<option value="exact">Exact</option>
						<option value="maxWidth">MaxWidth</option>
						<option value="maxHeight">MaxHeight</option>
					</select>
			 	</div>
				
				<input type="submit" name="upload" id="upload" class="btn btn-primary btn-sm" value="Upload">

			</form>
		</div>

		<div  class="col-md-6">
			<img  id="image-display" src="<?php echo Panel::Root(); ?>/plugins/panel/assets/img/nopreview.jpg " alt="">
		</div>		
	</div>
</div>

