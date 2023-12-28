<?php namespace App\Libraries;

class Mpdf {

     public $method;

     function __construct() {

           //require_once MPDF;

           $this->method = new \Mpdf\Mpdf (['mode' => 'utf-8']);
      }
}