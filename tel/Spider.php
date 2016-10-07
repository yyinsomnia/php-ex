<?php


class Dim_Tel_Spider
{

    private $url;


    private $htmlContents;

    private $telDict;
    
    public function __construct($url)
    { 
        $this->url = $url;

    }

    public function getHtmlContens()
    {
        if (isset($this->htmlContents)) {
            ;
        } else {
            $this->htmlContents = file_get_contents($this->url);
        }
        
        return $this->htmlContents;
    }

    public function getTelDict()
    {
        if (isset($this->telDict)) {
            ;
        } else {
            $this->telDict = self::parseTelDict($this->getHtmlContens());
        }
        return $this->telDict;
    }

    public static function parseTelDict($html)
    {
        $telDict = array();
        $pattern = '#<div class="para" label-module="para">.*</div>#';
        preg_match_all($pattern, $html, $telDict);
        var_dump($telDict);die;
        return $telDict;
    }



}