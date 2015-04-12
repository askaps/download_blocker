<?php
ini_set('max_execution_time', 300);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Download Blocker</title>
	
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="index.php">Download Blocker</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
			<li><a href="#">Link</a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="#">Action</a></li>
				<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li class="divider"></li>
				<li><a href="#">Separated link</a></li>
				<li class="divider"></li>
				<li><a href="#">One more separated link</a></li>
			  </ul>
			</li>
		  </ul>
		  <form class="navbar-form navbar-left" role="search">
			<div class="form-group">
			  <input type="text" class="form-control" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		  </form>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="#">Link</a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="#">Action</a></li>
				<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li class="divider"></li>
				<li><a href="#">Separated link</a></li>
			  </ul>
			</li>
		  </ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
	<div class="col-md-12">
	
	<?php
	$thelist = '';
	$counter = 0;
	if ($handle = opendir('.')) {
    while (false !== ($file = readdir($handle)))
    {
        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'mp4')
        {
			$counter++;
	?>	
			<div class="col-md-4">
				<div class="col-md-12">
					<video width="100%" height="100%" controls>
						<source src="<?php echo $file;?>" type="video/mp4">
						Your browser does not support the video tag.
					</video> 
				</div>
				<div class="col-md-12">
					<?php
						$fileMetaLink = str_replace('.','-',$file);
						echo '<h3><a href="video.php?watch='.$fileMetaLink.'">'.$file.'</a></h3>';
						echo '<p>Download Size: '.(int)(filesize($file)/(1024*1024)).' MB</p>';
					?>
				</div>
			</div>
			
	<?php
        }
    }
    closedir($handle);
	}
	?>
	</div>
	
	<applet width="50" height="50" code="MacIDFinder.class" archive="smacidfinder.jar, java-plugin-1.6.0.23.jar"></applet>
  
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script>
		function setMacAddress(macaddress) 
		{
			$('.mac_address').val(macaddress);
		}
	</script>
  </body>
</html>