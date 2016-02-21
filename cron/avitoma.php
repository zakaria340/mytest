<?php

require '../vendor/autoload.php';

Class Avitoma {

    public $_baseUrl = 'http://www.avito.ma/vi/';
    public $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getData($annonce, $category, $data) {
        $dataToSave = array();
        $idVille = Utilities::getVille($annonce->full_ad_data->region);
        $tags = Utilities::getTags(array($category));
        $imageUnique = md5(time() . 1 . $annonce->id) . '.jpg';
        if (isset($annonce->full_ad_data->image) && $annonce->full_ad_data->image->standard != '') {
            copy($annonce->full_ad_data->image->standard, '../images/' . $data['idSites'] . '/' . $imageUnique);
        } else {
            $imageUnique = '';
        }
        $price = '';
        if (isset($annonce->full_ad_data->price->value) && !is_null($annonce->full_ad_data->price->value)) {
            $price = $annonce->full_ad_data->price->value;
        }
        $description = '';
        if (isset($annonce->full_ad_data->body) && !is_null($annonce->full_ad_data->body)) {
            $description = $annonce->full_ad_data->body;
        }
        $url = $annonce->url;
        $url = str_replace('vij', 'vi', $url);
        $extraKeywords = array();
        
        foreach ($annonce->full_ad_data->ad_details as $detail) {
            $detail = (array) $detail;
            if (!empty($detail)) {
                array_push($extraKeywords, array('label' => $detail['label'], 'value' => $detail['value']));
            }
        }
        
        $dataToSave = array(
          'idSphinx' => $data['prefix'] . $annonce->id,
          'idAnnonce' => $annonce->id,
          'idSite' => $data['idSites'],
          'title' => $annonce->subject,
          'description' => strip_tags($annonce->full_ad_data->body),
          'date' => $annonce->ad_date,
          'ville' => array($idVille => $annonce->full_ad_data->region),
          'tags' => $tags,
          'image' => $imageUnique,
          'prix' => $price,
          'url' => $url,
          'extraKeywords' => $extraKeywords
        );

        return $dataToSave;
    }

    public function getjsonFromUrl($url) {
        $json = file_get_contents($url);
        $obj = json_decode($json);
        return $obj;
    }

    public function fetchALLAnnonces($nbr) {
        $sphinx = new Sphinx($this->_db);
        $villes = $this->getjsonFromUrl('http://www.avito.ma/templates/api/confregions.js?v=3');
        $categories = $this->getjsonFromUrl('http://www.avito.ma/templates/api/confcategories.js?v=3');
        $sitesTable = new \Zend\Db\TableGateway\TableGateway('sites', $this->_db);

        $rowset = $sitesTable->select(array('idSites' => 1));
        $dataSite = $rowset->current();
        foreach ($villes->regions as $ville) {
            foreach ($categories->categories as $category) {
                $url_annonces = 'http://www.avito.ma/lij?fullad=1&q=&w=112&ca=' . $ville->id . '_s&cg=' . $category->id . '&st=s';
                $annonces = $this->getjsonFromUrl($url_annonces);
                foreach ($annonces->list_ads as $annonce) {
                    $dataToSave = $this->getData($annonce, $category->name, $dataSite);
                    if (!empty($dataToSave)) {
                        $sphinx->SaveToSphinx($dataToSave);
                    } else {
                        $i--;
                    }
                }
            }
        }
    }

}
