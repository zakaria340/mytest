<?php

//delete from annonces where id IN (30,500000000);
//$string = 'delete from annonces where id IN (';
//for($i=2700;$i<2800;$i++){
//  $string .=$i.',';
//}
//$string .= ');';
//print $string;
//die('r');

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require '../vendor/autoload.php';

use Foolz\SphinxQL\SphinxQL;
use Foolz\SphinxQL\Connection;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$app = new \Slim\Slim();

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string($d)) {
        return utf8_encode($d);
    }
    return $d;
}

$app->get('/annonces', function () {
    $adapter = new Zend\Db\Adapter\Adapter(array(
        'driver' => 'Mysqli',
        'database' => 'searchannonces',
        'username' => 'root',
        'password' => '',
        'options' => array(
            'buffer_results' => true,
        )
    ));

//  $conn = new Connection();
//  $conn->setParams(array('host' => '127.0.0.1', 'port' => 9306));
    $q = '';
    $ville = $tags = NULL;
    if (isset($_GET['q'])) {
        $q = $_GET['q'];
        $ville = (isset($_GET['source'])) ? $_GET['source'] : null;
        if (isset($_GET['tags'])) {
            $tags = $_GET['tags'];
        }
    }
    $page = 1;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    $per_page = 35;
//  $query = SphinxQL::create($conn)->select('*')
//    ->from('annonces');
    if (isset($_GET['q']) && $q != '') {
        //  $query->match(array('title', 'description', 'tags'), $q);
    }
    if ($ville && $ville != 0 && $ville != '') {
        // $query->where('ville', (int) $ville);
    }
    if ($tags && $tags != 'none') {
        //$query->match(array('tags'), $tags);
    }
    //$result = $query->execute();
    $ids = array();
//  foreach ($result as $item) {
//    $ids[] = $item['id'];
//  }
    $annoncesTable = new \Zend\Db\TableGateway\TableGateway('annonces', $adapter);
    $sqlSelect = $annoncesTable->getSql()->select();
    if (true) {
        $sqlSelect->join('sites', 'annonces.idSite = sites.idSites', array('idSites', 'name', 'logo'));
        $sqlSelect->join('villes', 'annonces.ville = villes.idVilles', array('labelville' => 'name'));
        //  $sqlSelect->where(array('idAnnonces' => $ids));
        // $sqlSelect->where('sites.idSites = 2');
        $resultSet_count = $annoncesTable->selectWith($sqlSelect);
        $data_count = utf8ize($resultSet_count->toArray());
        $total_count = count($data_count);
        $list_tags = $list_sites = array();

        foreach ($data_count as $c) {
            if (!isset($list_tags[$c['tags']])) {
                $list_tags[$c['tags']] = str_replace(' ', '-', strtolower(trim($c['tags'])));
            }

            if (!isset($list_sites[$c['idSites']])) {
                $list_sites[$c['idSites']] = trim($c['name']);
            }
        }
        $page_ = $page;
        if ($page == 1) {
            $page_ = 0;
        }
        $sqlSelect->limit($per_page); // always takes an integer/numeric
        $offset = $page_ * $per_page;

        $sqlSelect->offset($offset);
        // $sqlSelect->where(array('idAnnonces' => $ids));
    } else {
        echo '[]';
        die;
    }

    $resultSet = $annoncesTable->selectWith($sqlSelect);
    $data_ = utf8ize($resultSet->toArray());
    $filteredData = array();
    if (!empty($data_)) {
        $filteredData = $list_tags;
        if (count($list_tags) > 5) {
            $list_tags_r = array_rand($list_tags, 5);
            $filteredData = array_intersect_key(
                    $list_tags, array_flip($list_tags_r)
            );
        }
    }

    $data_return = array(
        'page' => $page,
        'total_count' => $total_count,
        'items' => $data_,
        'tags' => $filteredData,
        'sites' => $list_sites
    );

    $data = \Zend\Json\Encoder::encode($data_return);
    echo $data;
});
$app->run();
