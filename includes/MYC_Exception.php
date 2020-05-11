<?php
/**
 * Created by PhpStorm.
 * User: devacc
 * Date: 06.05.2020
 * Time: 22:58
 */

class MYC_Exception extends Exception
{
    public function errorMessage() {
        //error message
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b> ';
        return $errorMsg;
    }
}