<?php
// PHP VoiceBox 0.6
// Forked by TiBounise (http://tibounise.com) based on the inital code of mGeek (http://mgeek.fr)

class Voxygen {
    private $grommo;
    private $cacheFolder;
    public $voices = array('Damien','Eva','Agnes','Philippe','Loic','Bicool','Chut','DarkVadoor','Electra','JeanJean','John','Luc','Matteo','Melodine','Papi','Ramboo','Robot','Sidoo','Sorciere','Yeti','Zozo','Marta','Elizabeth','Bibi','Paul','Bronwen','Adel');

    public function __construct($grommo = false,$cacheFolder = 'cache') {
        if (is_bool($grommo)) {
            $this->grommo = $grommo;
        }
        if (is_string($cacheFolder)) {
            $this->cacheFolder = $cacheFolder;
        }
    }
    public function voiceSynthesis($voice,$text) {
        if (!in_array($voice,$this->voices)) {
            throw new Exception('This voice you\'ve selected is currently not implemented.');
        }
        if ($this->grommo) {
            $text = $this->grommoFilter($text);
        }
        if (!is_dir($this->cacheFolder)) {
            mkdir($this->cacheFolder);
        }
        $md5 = md5($voice.$text);
        $file = $this->cacheFolder.'/'.$md5.'.mp3';
        if (!file_exists($file)) {
            $post = 'voice='.$voice.'&texte='.trim(stripslashes(strip_tags(utf8_decode($text))));
            $voxygenHTML = $this->curlJob($post);
            if (preg_match('/mp3:"(.+?)"/',$voxygenHTML,$regexHTML)) {
                $link = $regexHTML[1];
                file_put_contents($file, file_get_contents($link));
            } else {
                throw new Exception('Voxygen has probably changed its APIs. We can\'t get a correct URL.');
            }
        }
        return $file;   
    }
    public function grommoFilter($text) {
        $text = ' '.$text.' ';
        $grommoDB = array(
            'bite'    => 'bit',
            'cul'     => 'ku',
            'putain'  => 'puh tin',
            'shit'    => 'shi ihte',
            'enculer' => 'an qu\'hulé',
            'enculé'  => 'an qu\'hulé',
            'salope'  => 'sale ôpe',
            'morsay'  => 'morsaille',
            'suce'    => 'suh sse',
            'sucer'   => 'suh ceh',
            'nems'    => 'naimes');
        foreach ($grommoDB as $normal => $equivalent) {
            $text = str_ireplace(' '.$normal.' ',' '.$equivalent.' ', $text);
            $text = str_ireplace(' '.$normal.'.',' '.$equivalent.'.', $text);
            $text = str_ireplace('.'.$normal.' ','.'.$equivalent.' ', $text);
        }
        return $text;
    }
    public function voiceList($voice = 'Agnes') {
        $list = '';
        foreach ($this->voices as $voice) {
            if (isset($_POST['voice']) AND $voice == $_POST['voice']) {
                $list .= '<option selected>'.$voice.'</option>';
            } else {
                $list .= '<option>'.$voice.'</option>';
            }
        }
        return $list;
    }
    private function curlJob($post) {
        $curlHandler = curl_init("voxygen.fr/index.php");
        curl_setopt($curlHandler, CURLOPT_HEADER, true);
        curl_setopt($curlHandler, CURLOPT_POST, false);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curlHandler);
        curl_close($curlHandler);
        return $output;
    }
}

?>