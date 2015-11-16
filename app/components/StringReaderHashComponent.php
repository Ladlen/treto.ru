<?php

class StringReaderHashComponent extends StringReaderComponent
{
    protected $hashStrings = [];

    public function getNextString()
    {
        $string = parent::getNextString();

        $stringHash = md5($string);
        $this->hashStrings[$stringHash] = $string;

        return $string;
    }

    public function getStringByHash($hash)
    {
        return $this->hashStrings[$hash];
    }
}