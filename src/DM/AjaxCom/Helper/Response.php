<?php

namespace DM\AjaxCom\Helper;

class Response
{
    public static function json($data)
    {
        //@todo set proper respon header
        return json_encode($data);
        
    }
}
