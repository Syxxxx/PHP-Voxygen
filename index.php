<?php
// PHP Voxygen 1.0
// Forked by TiBounise (http://tibounise.com) based on the inital code of mGeek (http://mgeek.fr)

include 'lib/voxygen.class.php';

$voxygen = new Voxygen(true);
$errorMessage = '';

if ((isset($_POST['listen']) OR isset($_POST['download'])) AND !empty($_POST['message']) AND !empty($_POST['voice'])) {
	try {
		$location = $voxygen->voiceSynthesis($_POST['voice'],$_POST['message']);
		$mp3name = explode('/',$location);	
	} catch (Exception $e) {
		$errorMessage .= $e.' ';
	}
} elseif (isset($_POST['listen']) OR isset($_POST['download'])) {
	$errorMessage .= 'Vous avez oublié de remplir certains champs. ';
}

?>
<!doctype html>
<html>
<head>
	<title>PHP Voxygen</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta charset="utf-8" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<?php
		if (isset($_POST['download'])) {
			echo '<meta http-equiv="refresh" content="0; URL=getfromcache.php?id='.$mp3name[1].'">';
		}
	?>
	<link href="lib/bootstrap.min.css" rel="stylesheet" />
	<link href="lib/bootstrap-responsive.css" rel="stylesheet" />
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="apple-touch/touch-icon-57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch/touch-icon-114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch/touch-icon-72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch/touch-icon-144.png" />
	<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)" href="apple-touch/touch-startup-460.png">
	<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" href="apple-touch/touch-startup-920.png">
	<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="apple-touch/touch-startup-1096.png">
	<style type="text/css">
		@media (min-width: 981px) {
			body {
				padding-top: 60px;
			}
		}
	</style>
</head>
<body>
	<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">PHP Voxygen</a>
        </div>
      </div>
    </div>

	<div class="container">
		<?php
			if (!empty($errorMessage)) {
				echo '<div class="alert alert-error">'.$errorMessage.'</div>';
			}
		?>
		<form method="POST" class="form-horizontal" action="index.php"> 
			<div class="control-group">
				<label class="control-label">Message</label>
				<div class="controls">
					<textarea class="input-xlarge" rows="3" name="message" ><?php if (isset($_POST['message'])) { echo stripslashes(strip_tags($_POST['message'])); } ?></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Voix</label>
				<div class="controls">
					<select name="voice">
						<?php echo $voxygen->voiceList(isset($_POST['voice']) ? $_POST['voice'] : null); ?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<div class="btn-group">
						<button type="submit" name="listen" class="btn btn-info">Écouter</button>
						<button type="submit" name="download" class="btn btn-info">Télécharger</button>
					</div>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
				<?php 
					if (isset($_POST['listen']) AND !empty($location)) {
				?>
					<object type="application/x-shockwave-flash" data="lib/dewplayer.swf" width="200" height="20" id="dewplayer" name="dewplayer">
						<param name="movie" value="lib/dewplayer.swf" />
						<param name="flashvars" value="mp3=<?php echo $location; ?>&amp;autostart=1" />
						<param name="wmode" value="transparent" />
						<audio preload="auto" controls="controls">
							<source src="<?php echo $location; ?>" type="audio/mpeg" />
						</audio>
					</object>
				<?php
					}
				?>
				</div>
			</div>
		</form>
	</div>
</body>
</html>