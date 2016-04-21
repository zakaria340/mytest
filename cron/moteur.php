<?php

Class Moteur {

  public $_baseUrl = '';
  public $_db;

  public function __construct($db) {
    $this->_db = $db;
  }

  public function getData($url, $data) {
    $s = preg_match_all('/detail-annonce\/(.*)\//', $url, $matches);
    $annonceID = $matches[1][0];

    $sphinx = new Sphinx($this->_db);
    $d = $sphinx->checkAnnoncebyUrl($url);
    if (!empty($d)) {
      return array();
    }


    $html = file_get_html($url);
    $dataToSave = array();

    if ($html && $html->find('h1 strong', 0)) {
      $prix = $image = $title = $urlAnnonces = '';
      $title = $html->find('h1', 0)->plaintext;
      $title = strip_tags($title);
      $title = trim($title);
      $date = '';
      if ($html->find('#colonne-gauche-bloc-annonce table tr', 7) && $html->find('#colonne-gauche-bloc-annonce table tr', 7)->find('td', 1)) {
        $date = $html->find('#colonne-gauche-bloc-annonce table tr', 7)->find('td', 1)->plaintext;
        $date = trim($date);
        $date = strtotime($date);
      }

      if ($html->find('#colonne-gauche-bloc-annonce p', 0)) {
        $prix = trim($html->find('#colonne-gauche-bloc-annonce p', 0)->plaintext);
        $prix = str_replace('Dhs', '', $prix);
        $prix = trim($prix);
      }

      if ($html->find('#bloc-photos-annonces a img', 0)) {
        $image = trim($html->find('#bloc-photos-annonces img.grande-photo-annonce', 0)->src);
        $image = 'http://www.moteur.ma' . $image;
      }

      $ville = $html->find('#bloc-informations-vendeur tr ', 1);
      $ville = $ville->find('a', 0)->plaintext;
      $ville = trim($ville);

      $idVille = Utilities::getVille($ville);
      $tags = Utilities::getTags(array('Voitures'));

      $extraKeywords = array();

      foreach ($html->find('#colonne-gauche-bloc-annonce table tr') as $liinfo) {
        if ($liinfo->find('td', 1)) {
          $dataitem = array('label' => $liinfo->find('td', 0)->plaintext,
            'value' => trim($liinfo->find('td', 1)->plaintext));
          array_push($extraKeywords, $dataitem);
        }
      }
      $description = '';
      if ($html->find('meta[NAME=description]', 0)) {
        $description = $html->find('meta[NAME=description]', 0)->attr['content'];
      }

      array_pop($extraKeywords);
      array_pop($extraKeywords);
      if ($image != '') {
        $imageUnique = md5(time() . 3 . $annonceID) . '.jpg';
        Utilities::resizeandsave($image, $data['idSites'], $imageUnique);
      } else {
        $imageUnique = '';
      }

      $dataToSave = array(
        'idSphinx' => $data['prefix'] . $annonceID,
        'idAnnonce' => $annonceID,
        'idSite' => $data['idSites'],
        'title' => trim($title),
        'description' => trim($description),
        'date' => $date,
        'ville' => array($idVille => $ville),
        'tags' => $tags,
        'image' => $imageUnique,
        'prix' => $prix,
        'url' => $url,
        'extraKeywords' => $extraKeywords
      );
    }
    return $dataToSave;
  }

  public function fetchALLAnnonces($nbr) {
    $sitesTable = new \Zend\Db\TableGateway\TableGateway('sites', $this->_db);
    $sphinx = new Sphinx($this->_db);
    $rowset = $sitesTable->select(array('idSites' => 5));
    $data = $rowset->current();

    for ($i = 1; $i <= $nbr; $i++) {
      $listpagehtml = file_get_html('http://www.moteur.ma/?lang=fr&cat=voiture&moteur=achat-voiture-occasion&marque=&modele=&stock-professionnel=&carburant=&boite=&prix_min=&prix_max=&annee_min=&annee_max=&km=&couleur=&carrosserie=&premiere_main=&avec_photo=&ville=&page=' . $i);
      foreach ($listpagehtml->find('#bloc-resultat-recherche-auto table td a') as $item) {
        $link = $item->href;
        $link = 'http://www.moteur.ma' . $link;
        $dataToSave = $this->getData($link, $data);
        if (!empty($dataToSave)) {
         $sphinx->SaveToSphinx($dataToSave);
        }
      }
    }
  }

}
