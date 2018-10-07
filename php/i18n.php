<?php
function _s($phrase) {
    static $translations = NULL;
    if (is_null($translations)) {
        $lang_file = "translations/".$_SESSION["lang"].".json";
        $lang_file_content = file_get_contents($lang_file);
        $translations = json_decode($lang_file_content, true);
    }
    if(array_key_exists($phrase, $translations)){
        return $translations[$phrase];
    }
    return $phrase;
}