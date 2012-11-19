<?php
	ob_start();
	session_start();

	define('GROMMO', true);

	include 'fonctions.php';

	$voices = array('Agnes','Philippe','Loic','Bicool','Chut','DarkVadoor','Electra','JeanJean','John','Luc','Matteo','Melodine','Papi','Ramboo','Robot','Sidoo','Sorciere','Yeti','Zozo');

	if ((isset($_POST['listen']) OR isset($_POST['download'])) AND isset($_POST['message']) AND isset($_POST['voice'])) {
		$location = downloadFile($_POST['voice'],$_POST['message']);
		if (isset($_POST['download'])) {
			header('Location: '.$location);
        	exit;
		}
	} elseif (isset($_POST['listen']) OR isset($_POST['download'])) {
		die('PROUT, wrong parameters');
	}
?>
<!doctype html>
<html>
<head>
	<title>PHP VoiceBox</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta charset="utf-8">
	<link href="lib/bootstrap.css" rel="stylesheet">
	<link href="lib/bootstrap-responsive.css" rel="stylesheet">
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
          <a class="brand" href="#">PHP VoiceBox</a>
        </div>
      </div>
    </div>

	<div class="container">
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
						<?php
							foreach ($voices as $voice) {
								if (isset($_POST['voice']) AND $voice == $_POST['voice']) {
									echo '<option selected>'.$voice.'</option>';
								} else {
									echo '<option>'.$voice.'</option>';
								}
							}
						?>
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