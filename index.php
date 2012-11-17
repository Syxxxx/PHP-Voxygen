<?php 
	
	set_time_limit (20);
	include 'fonctions.php';

	$lien = '';

	$errors = '';
	$user_message = '';

	if (isset($_POST['message'])) {
		$user_message = $_POST['message'];
	}
	
	$voix = "Agnes";
	if (isset($_POST['voix'])) {
		$voix = $_POST['voix'];
	}
	
	$flash = "0";
	if (isset($_GET['flash'])) {
		$flash = $_GET['flash'];
	}


	if (isset($_POST['submit'])) {
		$post = array("voice" => $voix, "texte" => $user_message);
		$result = curl_post("http://voxygen.fr/index.php", $post);
		$lien = string_between($result, 'mp3:"', '"');
		$file = "cache/".rand(10000,99999);
		file_put_contents($file.".mp3", file_get_contents($lien));
	}

	if (isset($_POST['download'])) {
		$post = array("voice" => $voix, "texte" => $user_message);
		$result = curl_post("http://voxygen.fr/index.php", $post);
		$lien = string_between($result, 'mp3:"', '"');
		$file = "cache/".rand(10000,99999);
		file_put_contents($file.".mp3", file_get_contents($lien));
		header('Location: '.$file.".mp3");
	}
?>

<!doctype html>
<html>
<head>
	<title>VoiceBox</title>
	<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">	
	<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

	<div class="container">
		
			<h3>Synthétiseur de voix en PHP | PHP VoiceBox</h3>
			<form method="POST" class="form-horizontal"> 
				<div class="control-group">
					<label class="control-label" for="textarea">Message</label>
					<div class="controls">
						<textarea class="input-xlarge" id="textarea" rows="3" name="message" ><?php echo htmlentities($user_message); ?></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="select">Voix</label>
					<div class="controls">
						<select multiple="multiple" id="select" name="voix">
							<option <?php if ($voix == "Agnes") { echo "selected"; }?>>Agnes</option>
							<option <?php if ($voix == "Philippe") { echo "selected"; }?>>Philippe</option>
							<option <?php if ($voix == "Loic") { echo "selected"; }?>>Loic</option>
							<option <?php if ($voix == "Bicool") { echo "selected"; }?>>Bicool</option>
							<option <?php if ($voix == "Chut") { echo "selected"; }?>>Chut</option>
							<option <?php if ($voix == "DarkVadoor") { echo "selected"; }?>>DarkVadoor</option>
							<option <?php if ($voix == "Electra") { echo "selected"; }?>>Electra</option>
							<option <?php if ($voix == "JeanJean") { echo "selected"; }?>>JeanJean</option>
							<option <?php if ($voix == "John") { echo "selected"; }?>>John</option>
							<option <?php if ($voix == "Luc") { echo "selected"; }?>>Luc</option>
							<option <?php if ($voix == "Matteo") { echo "selected"; }?>>Matteo</option>
							<option <?php if ($voix == "Melodine") { echo "selected"; }?>>Melodine</option>
							<option <?php if ($voix == "Papi") { echo "selected"; }?>>Papi</option>
							<option <?php if ($voix == "Ramboo") { echo "selected"; }?>>Ramboo</option>
							<option <?php if ($voix == "Robot") { echo "selected"; }?>>Robot</option>
							<option <?php if ($voix == "Sidoo") { echo "selected"; }?>>Sidoo</option>
							<option <?php if ($voix == "Sorciere") { echo "selected"; }?>>Sorciere</option>
							<option <?php if ($voix == "Yeti") { echo "selected"; }?>>Yeti</option>
							<option <?php if ($voix == "Zozo") { echo "selected"; }?>>Zozo</option>
						</select>

					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" name="submit" class="btn btn-info">Écouter le texte</button>
						<button type="submit" name="download" class="btn btn-info">Télécharger le fichier MP3</button>
					</div>
				</div>

			<div class="control-group">
				<div class="controls">
				<?php 
					if ($lien != "") {
						if ($flash == "1") {
							echo '<pre><embed type="application/x-shockwave-flash" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" flashvars="audioUrl='.$file.'.mp3&autoPlay=true" width="365" height="25" quality="best"></embed></pre>';		
						} else {
							echo '<audio preload="auto" controls="controls" autoplay="autoplay">';
							echo '<source src="'.$file.'.mp3" type="audio/mpeg" />';	
							echo '</audio>';
							echo '<br><br><a href="?flash=1" class="btn btn-small">Vous n'."'".'entendez pas le son ? Cliquez ici pour utiliser le player flash</a>';
						}
					}
				?>
				</div>
			</div>

			</form>

			<footer><i>"Les versions alpha de tes logiciels sont plus fonctionnelles que la version finale de NebulaCloud"</i> <a href="http://twitter.com/Apcros">@Apcros</a></footer>
			<br>

			<footer>
				Version 0.4 | Report bugs: <a href="http://twitter.com/mGeek_">@mGeek_</a>
				<br>&copy; Copyright 2012 - <a href="http://mgeek.fr/">mGeek</a>
				<small><br>Merci à <a href="http://voxygen.fr/">voxygen.fr</a></small>
			</footer>

		</body>
		</div>
</html>