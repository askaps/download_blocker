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
	
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "2306a669-b6ff-4eb4-b47b-48cf57d20457", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
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
	
	<div class="col-md-10">
	
	<?php
	$watch = $_GET['watch'];
	$file = str_replace('-','.',$watch);
	?>	
				<div class="col-md-8">
					<video width="100%" height="100%" controls>
						<source src="<?php echo $file;?>" type="video/mp4">
						Your browser does not support the video tag.
					</video> 
				</div>
				<div class="col-md-4">
					<?php
						echo '<h3>'.$file.'</h3>';
						echo '<p>Download Size: '.(int)(filesize($file)/(1024*1024)).' MB</p>';
					?>
					<form method="post" class='dnldBtn' action='compile.php' id='<?php echo $watch;?>'>
						<input type="hidden" name="compile">
						<input type="hidden" name="mac_address" id="mac_address" class="mac_address">
						<input type="hidden" name="filename" value="<?php echo $file;?>.enc">
						<div id='div_<?php echo $watch;?>'>
							<button type='submit' class="btn btn-info">Download Now</button>
						</div>
					</form>
					
					<div style="margin-top:10px;">
						<span class='st_sharethis_large' displayText='ShareThis'></span>
						<span class='st_facebook_large' displayText='Facebook'></span>
						<span class='st_twitter_large' displayText='Tweet'></span>
						<span class='st_linkedin_large' displayText='LinkedIn'></span>
						<span class='st_pinterest_large' displayText='Pinterest'></span>
						<span class='st_email_large' displayText='Email'></span>
					</div>
						
				</div>
			
	</div>
	<div class="col-md-10">
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			/* * * CONFIGURATION VARIABLES * * */
			var disqus_shortname = 'downloadblocker';
			
			/* * * DON'T EDIT BELOW THIS LINE * * */
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
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
	<script type='text/javascript'>
		$(".dnldBtn").submit(function(event) {
			event.preventDefault();
			var $form = $( this ),
			url = $form.attr( 'action' );
			var data = $(this).serialize();
			var posting = $.post( url, data );
			posting.done(function( data ) {
				var fId = $form.attr('id');
				var divId = $('#div_'+fId);
				divId.html(data);
				
			});
		});
	</script>
  </body>
</html>