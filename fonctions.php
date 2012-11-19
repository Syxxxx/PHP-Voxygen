<?php

function curl_post($url, array $post = NULL, array $options = array()) {
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($post)
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
} 

function downloadFile($voice,$text) {
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
        $voxyHTML = curl_post("http://voxygen.fr/index.php", $post);
        preg_match('/mp3:"(.+?)"/',$voxyHTML,$regexHTML);
        $link = $regexHTML[1];
        file_put_contents($file, file_get_contents($link));
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