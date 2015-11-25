<?php

class encriptStrClass {
    public function encodeUrl($str){
    $eStr=base64_encode('ku'.$str.'kks');
    return $eStr;
    }
    
    public function decodeUrl($str){
    $eStr=base64_decode($str);
    $eStr=  substr($eStr,0,-3);
    $eStr=substr($eStr,2);
    return $eStr;
    }
}
?>
