<?php
// PHP VoiceBox 0.6
// Forked by TiBounise (http://tibounise.com) based on the inital code of mGeek (http://mgeek.fr)

class Voxygen {
    /**
     * Status of the grommo filter
     * 
     * @var boolean
     * @access private
     */
    private $grommo;

    /**
     * Path to the cache folder
     * 
     * @var string
     * @access private
     */
    private $cacheFolder;

    /**
     * Array of the voices
     * 
     * @var array
     * @access public
     */
    public $voices = array('Damien','Eva','Agnes','Philippe','Loic','Bicool','Chut','DarkVadoor','Electra','JeanJean','John','Luc','Matteo','Melodine','Papi','Ramboo','Robot','Sidoo','Sorciere','Yeti','Zozo','Marta','Elizabeth','Bibi','Paul','Bronwen','Adel');

    /**
     * Class initialisator
     * 
     * @param boolean $grommo State of the grommo filter
     * @param string $cacheFolder Path to the cache folder
     * @access public
     */
    public function __construct($grommo = false,$cacheFolder = 'cache') {
        if (is_bool($grommo)) {
            $this->grommo = $grommo;
        }
        if (is_string($cacheFolder)) {
            $this->cacheFolder = $cacheFolder;
        }
    }

    /**
     * Main function to do voice synthesis requests
     * 
     * @param string $voice Voice
     * @param string $text Text to be said
     * @access public
     * @return string Path to the rendered file
     */
    public function voiceSynthesis($voice,$text) {
        if (!in_array($voice,$this->voices)) {
            throw new Exception('This voice you\'ve selected is currently not implemented.');
        }

        if (get_magic_quotes_gpc()) $text = stripslashes($text);

        if ($this->grommo) {
            $text = $this->grommoFilter($text);
        }
        if (!is_dir($this->cacheFolder)) {
            mkdir($this->cacheFolder);
        }
        $md5 = md5($voice.$text);
        $file = $this->cacheFolder.'/'.$md5.'.mp3';
        if (!file_exists($file)) {
            $post = 'method=get&voice='.$voice.'&text='.urlencode($text);
            $voxygenJSON = $this->curlJob($post);
            $voxygenParsedData = json_decode($voxygenJSON,true);
            if ($voxygenParsedData !== null && isset($voxygenParsedData['signal'])) {
                file_put_contents($file,file_get_contents($voxygenParsedData['signal']));
            } else {
                throw new Exception('Voxygen has probably changed its APIs. We can\'t get a correct URL.');
            }
        }
        return $file;   
    }

    /**
     * Grommo filter function
     * 
     * @param string $text Text to filter
     * @return string Text filtered
     * @access public
     */
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

    /**
     * HTTP request function
     * 
     * @param string $post Content of the request
     * @return string Output of the request
     * @access private
     */
    private function curlJob($post) {
        $curlHandler = curl_init("http://voxygen.fr/sites/all/modules/voxygen_voices/assets/proxy/index.php");
        curl_setopt($curlHandler, CURLOPT_HEADER, false);
        curl_setopt($curlHandler, CURLOPT_POST, true);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_REFERER, 'http://voxygen.fr/fr');
        curl_setopt($curlHandler, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:23.0) Gecko/20100101 Firefox/23.0');
        curl_setopt($curlHandler, CURLOPT_COOKIE, 'has_js=1');
        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, array(
            'Content-type: application/x-www-form-urlencoded',
            'X-Requested-With:  XMLHttpRequest',
            'Host: voxygen.fr'
        ));
        $output = curl_exec($curlHandler);
        curl_close($curlHandler);
        return $output;
    }
}

?>