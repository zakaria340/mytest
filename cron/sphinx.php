<?php
use Foolz\SphinxQL\SphinxQL;
use Foolz\SphinxQL\Connection;

Class Sphinx {

    public $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function SaveToSphinx($data) {
      
        $annoncesTable = new \Zend\Db\TableGateway\TableGateway('annonces', $this->_db);
        extract($data);
        $dataAnnonce = $data;
        unset($dataAnnonce['idSphinx']);
        unset($dataAnnonce['idAnnonce']);
        $ville = array_keys($dataAnnonce['ville']);
        $dataAnnonce['ville'] = $ville[0];
        $dataAnnonce['ville'] = $ville[0];
        $dataAnnonce['tags'] = implode(', ', $dataAnnonce['tags']);
        $rawExtraKeywords = $dataAnnonce['extraKeywords'];
        $dataAnnonce['extraKeywords'] = json_encode($dataAnnonce['extraKeywords']);
        $annoncesTable->insert($dataAnnonce);
        $idAnnonce = $annoncesTable->getLastInsertValue();

        /**
         * Sphinx Insert
         */
//        $conn = new Connection();
//        
//        $sq = SphinxQL::create($conn)->delete();
//        
//        $conn->setParams(array('host' => '127.0.0.1', 'port' => 9306));
//        $sq = SphinxQL::create($conn)->insert()->into('annonces');
//        $sphinxData = array(
//            'id' => $idAnnonce,
//            'title' => $dataAnnonce['title'],
//            'description' => $dataAnnonce['description'],
//            'tags' => $dataAnnonce['tags'],
//            'extrakeywords' => json_encode($rawExtraKeywords),
//            'idsite' => $dataAnnonce['idSite'],
//            'ville' => $dataAnnonce['ville'],
//            'date' => $dataAnnonce['date']
//        );
        //var_dump($sphinxData);die('SPHINX');
        //$sq->set($sphinxData)->execute();
    }

}
