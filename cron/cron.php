<?php

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require '../vendor/autoload.php';
include('../simple_html_dom.php');
include('sphinx.php');
include('utilities.php');
include('avitoma.php');
include('moteur.php');
include('souk.php');
include('wandaloo.php');
include('marocannonces.php');
include('sarouty.php');

Class Cron {

  public $adapter;

  public function __construct() {
    $adapter = new \Zend\Db\Adapter\Adapter(array(
      'driver' => 'Mysqli',
      'database' => 'searchannonces',
      'username' => 'root',
       'password' => 'xfYdTuUPz6dw',
      'charset' => 'utf8',
      'options' => array(
        'buffer_results' => true,
      ),
    ));
    $this->adapter = $adapter;
  }

  public function _excuteCron() {
    $marocannonces = new Moteur($this->adapter);
    $marocannonces->fetchALLAnnonces(2);

    $marocannonces = new Souk($this->adapter);
    $marocannonces->fetchALLAnnonces(2);

    $marocannonces = new sarouty($this->adapter);
    $marocannonces->fetchALLAnnonces(1);
//
    $marocannonces = new Marocannonces($this->adapter);
    $marocannonces->fetchALLAnnonces(1);
//
////    $marocannonces = new Avitoma($this->adapter);
////    $marocannonces->fetchALLAnnonces(1);
//
    $marocannonces = new wandaloo($this->adapter);
    $marocannonces->fetchALLAnnonces(1);
  }

}

$cron = new Cron();
$cron->_excuteCron();
