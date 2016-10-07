<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slack
{
    public function send($content = null ){
        $message = $content;
        $room = "#channel";
        $icon = ":car:";
        $url = "https://hooks.slack.com/services/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";
         
        $data = "payload=" . json_encode(array(
        "channel"       =>  "#interins",
        "text"          =>  $message,
        "icon_emoji"    =>  $icon
        ));
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
