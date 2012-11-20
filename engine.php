<?php

$voices = array('Agnes','Philippe','Loic','Bicool','Chut','DarkVadoor','Electra','JeanJean','John','Luc','Matteo','Melodine','Papi','Ramboo','Robot','Sidoo','Sorciere','Yeti','Zozo');

function sendToVoxygen($post) {
    $curlHandler = curl_init("voxygen.fr/index.php");
    curl_setopt($curlHandler, CURLOPT_HEADER, 0);
    curl_setopt($curlHandler, CURLOPT_POST, 1);
    curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curlHandler);
    curl_close($curlHandler);
    return $output;
} 

function downloadFile($voice,$text) {
    // GROMMO (anti-censorship filter)
    if (GROMMO) {
        $text = grommo($text);
    }
    if (!is_dir('cache')) {
        mkdir('cache');
    }
    $md5 = md5($voice.$text);
    $file = 'cache/'.$md5.'.mp3';
    if (!file_exists($file)) {
        $post = array("voice" => $voice, "texte" => stripslashes(strip_tags($text)));
        $voxyHTML = sendToVoxygen($post);
        if (preg_match('/mp3:"(.+?)"/',$voxyHTML,$regexHTML)) {
            $link = $regexHTML[1];
            file_put_contents($file, file_get_contents($link));
        } else {
            die('Une erreur s\'est produite. Veuillez verifier votre installation de PHP VoiceBox et de verifier si de nouvelles mises a jour n\'ont pas ete publiees');
        }
    }
    return $file;
}

function grommo($text) {
    $grommoDB = array(
        'bite' => 'bit',
        'cul' => 'ku');
    foreach ($grommoDB as $normal => $equivalent) {
        $text = str_replace(' '.$normal.'',' '.$equivalent.' ', $text);
    }
    return $text;
}

?>