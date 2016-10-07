<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Parser
{
    /*call to external service
    /mean time to response in apps.caib.es 10secs ... patience
    */
    public function getContent($contentArray = null){
        $url = "https://apps.caib.es/sadperdoc5front/interins/resultatsAdjudicacio.do?convocatoria=101&codiFuncio=&codiCentre=";
        $content = utf8_encode(file_get_contents($url));
        if(!empty($content)){
            return $this->parseResponse($content);      
        }
    }

    public function parseResponse($content){
        $contentArray  = explode ( '<div class="panel-heading">' , $content );
        unset($contentArray[0]);
        $adjudication = array();
        $i=1;
        foreach ($contentArray as $individualAdjudication) {
            if ($individualAdjudication == null){
                unset($contentArray[$i]);
            }
            $contentClear =  $this->cleanHtmlTags($individualAdjudication);
            $cutResult = $this->cutResult($contentClear);
            array_push($adjudication, $cutResult);
            $i++;
        }
        return $adjudication;

    }

    public function cleanHtmlTags($contentArray){
        return strip_tags($contentArray);
    }
    /*
    /cut to strings diferent parts 
    / return array with individuals adjudications
    */
    public function cutResult($contentClear){

        $dateStart = explode ( 'Data inici:' , $contentClear );
        $dateStart = explode ( 'Data finalització prevista *' , $dateStart[1] );

        $dateEnd = explode ( 'Data finalització prevista *:' , $contentClear );
        if (isset($dateEnd[1])){
            $dateEnd = explode ( 'Llocs treball' , $dateEnd[1]);
        }else{
            $dateEnd = null;
        }
        

        $location = explode ( 'Llocs treball' , $contentClear );
        if (isset($location[1])){
            $location = explode ( 'Funcions' , $location[1]);
        }else{
            $location = null;
        }

        $teacherName = explode ( 'Adjudicada a:' , $contentClear );
        if (isset($teacherName[1])){
            $teacherName = explode ( 'Punts' , $teacherName[1]);
            $teacherName[0] = str_replace(". ", "", $teacherName[0]);
            $teacherName[0] = $this->cleanTeacherName($teacherName[0]);
        }else{
            $teacherName = null;
        }

        $information=array(
            'dateStart'     => $dateStart[0], 
            'dateEnd'       => $dateEnd[0],
            'location'      => $location != null ? $location[0] : null,
            'teacherName'   => $teacherName != null ? $teacherName[0] : null 
            );
        return  $information;       
    }
    public function cleanTeacherName($teacherName){
        $length = strlen ($teacherName);
        //we rest 8 because this is the number to the specials white spaces adding at string
        $teacherName = substr($teacherName, 0, $length-8);
        return $teacherName;
    }
    public function cleanWhiteSpaces($text){
        $text = str_replace(" ", "",  $text);
        $text = str_replace("\n", "", $text);
        $text = str_replace("    ", "", $text);
        return $text;
    }
}
