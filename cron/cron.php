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

        $marocannonces = new sarouty($this->adapter);
        $marocannonces->fetchALLAnnonces(8);
    }

}

$cron = new Cron();
$cron->_excuteCron();
