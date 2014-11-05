<!-- Wrapper -->
<div id="morfy_panel" class="wrapper">

  <!-- Sidebar -->
  <div class="sidebar">

  	<div class="panel_logo">
  		<a href="<?php echo Panel::Root('panel'); ?>">
        <img src="<?php echo Panel::Root(); ?>plugins/panel/assets/img/logo.jpg" alt="Mofry Panel">
      </a>
    </div>

			<?php if (!empty($_SESSION['login'])) {?>
					<nav>
						<ul class="menu">
              <li><a href="/panel"><i class="fa fa-home"></i> &nbsp; <?php echo $lang['Home']; ?></a></li>
              <li><a href="?get=images"><i class="fa fa-image"></i> &nbsp; <?php echo $lang['Images']; ?></a></li>
              <li><a href="?get=uploads"><i class="fa fa-file-image-o"></i> &nbsp; <?php echo $lang['New Image']; ?></a></li>
              <li><a href="?get=new"><i class="fa fa-edit"></i> &nbsp; <?php echo $lang['New Page']; ?></a></li>
              <li><a href="?get=settings"><i class="fa fa-gears"></i> &nbsp; <?php echo $lang['Settings']; ?></a></li>
							<li><a href="?get=documentation"><i class="fa fa-support"></i> &nbsp; <?php echo $lang['Documentation']; ?></a></li>
						</ul>
					</nav>
			<?php } ?>

  </div>

  <!-- Main content -->
  <div class="main">

    <!-- Header  -->
    <header class="header">
        <a class="header-title pull-left" href="<?php echo Panel::Root('panel'); ?>">MORFY PANEL</a></h1>
        <div class="pull-right well-sm">

        <?php if (!empty($_SESSION['login'])){ ?>
          <a href="?action=logout"><i class="fa fa-sign-out fa-2x"></i></a></a>
        <?php } ?>
        
        </div>
    </header>

    <!-- Content -->
    <section class="content">
      
      <div class="alert_panel"></div>
  
			<?php if (empty($_SESSION['login'])) { ?>
				<?php Morfy::factory()->runAction('auth'); ?>
			 <?php }else{  ?>
					<?php Morfy::factory()->runAction('content'); ?>
			 <?php } ?>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <p class="text-muted text-center"><?php echo $lang['Powered by']; ?><a href="http://morfy.monstra.org/" title="Simple and fast file-based CMS">Morfy</a>.</p>
    </footer>

  </div>

</div>

