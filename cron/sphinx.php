<?php

use Foolz\SphinxQL\SphinxQL;
use Foolz\SphinxQL\Connection;

Class Sphinx {

    public $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function checkAnnoncebyUrl($url) {
        $annoncesTable = new \Zend\Db\TableGateway\TableGateway('annonces', $this->_db);
        $sqlSelect = $annoncesTable->getSql()->select();
        $sqlSelect->where(array('url' => $url));
        $resultSet_count = $annoncesTable->selectWith($sqlSelect);
        $data_check = $resultSet_count->toArray();
        return $data_check;
    }

    public function SaveToSphinx($data) {

        $annoncesTable = new \Zend\Db\TableGateway\TableGateway('annonces', $this->_db);
        extract($data);
        $dataAnnonce = $data;
        unset($dataAnnonce['idSphinx']);
        unset($dataAnnonce['idAnnonce']);
        $ville = array_values($dataAnnonce['ville']);
        $ville = $ville[0];
        $dataAnnonce['ville'] = $ville;
        $dataAnnonce['tags'] = implode(', ', $dataAnnonce['tags']);
        $rawExtraKeywords = $dataAnnonce['extraKeywords'];
        $dataAnnonce['extraKeywords'] = json_encode($dataAnnonce['extraKeywords']);
        $annoncesTable->insert($dataAnnonce);
        $idAnnonce = $annoncesTable->getLastInsertValue();

        /**
         * Sphinx Insert
         */
/*        $conn = new Connection();
        //$sq = SphinxQL::create($conn)->delete();
        $conn->setParams(array('host' => '127.0.0.1', 'port' => 9306));
        $sq = SphinxQL::create($conn)->insert()->into('annonces8');
        $sphinxData = array(
            'id' => $idAnnonce,
            'title' => $dataAnnonce['title'],
            'description' => $dataAnnonce['description'],
            'tags' => $dataAnnonce['tags'],
            'extrakeywords' => json_encode($rawExtraKeywords),
            'idsite' => $dataAnnonce['idSite'],
            'ville' => $dataAnnonce['ville'],
            'date' => $dataAnnonce['date']
        );
        //var_dump($sphinxData);die('SPHINX');
       $sq->set($sphinxData)->execute();*/
    }

}
