<?php

Class wandaloo {

    public $_baseUrl = '';
    public $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getData($url, $data) {
        $html = file_get_html($url);
        $dataToSave = array();

        if ($html && $html->find('h1.paveOccasion', 0)) {

            $prix = $image = $title = $urlAnnonces = '';
            $title = $html->find('h1.paveOccasion', 0)->plaintext;
            $date = $html->find('#sommaire ul', 0)->lastChild()->plaintext;
            $date = str_replace('Date de publication', '', $date);
            $date = trim($date);
            //$date = $html->find('#sommaire ul li span.rouge',0)->plaintext;

            if ($html->find('#occasionHeader h4', 0)) {
                $prix = trim($html->find('#occasionHeader h4', 0)->plaintext);
                $prix = str_replace('DH', '', $prix);
                $prix = trim($prix);
            }
            if ($html->find('meta[property=og:image]', 0)) {
                $image = trim($html->find('meta[property=og:image]', 0)->content);
            }

            $ville = trim($html->find('#vendeur li#Nom ', 0)->innertext);

            $ville = explode('<br/>', $ville);
            $ville = $ville[1];

            $ville = explode(',', $ville);
            $ville = trim($ville[0]);

            //$idVille = Utilities::getVille($ville);
            $cat1 = trim('Voitures');
            //$tags = Utilities::getTags(array($cat1));
            $extraKeywords = array();


            foreach ($html->find('#sommaire li') as $liinfo) {
                $dataitem = array('label' => $liinfo->find('p', 0)->plaintext,
                    'value' => trim($liinfo->find('span', 0)->plaintext));
                array_push($extraKeywords, $dataitem);
            }


            $typeCarburant = $html->find('#sommaire li', 2);
            array_push($extraKeywords, $typeCarburant->find('span', 0)->plaintext);
            $datemise = $html->find('#sommaire li', 3);
            array_push($extraKeywords, $datemise->find('span', 0)->plaintext);
            $boitevitesse = $html->find('#sommaire li', 6);
            array_push($extraKeywords, $boitevitesse->find('span', 0)->plaintext);

            $imageUnique = md5(time() . 1 . $id);
            if ($image != '') {
                //   copy($image, '../images/' . $data['idSites'] . '/' . $imageUnique . '.jpg');
            } else {
                $imageUnique = '';
            }
            $dataToSave = array(
                'idSphinx' => 1 . $id,
                'idAnnonce' => $id,
                'idSite' => 1,
                'title' => trim($title),
                'description' => trim($html->find('#oComment p', 0)->plaintext),
                'date' => $date,
                'ville' => array(),
                'tags' => array(),
                'image' => $image,
                'prix' => $prix,
                'url' => '',
                'extraKeywords' => $extraKeywords
            );
        }
        return $dataToSave;
    }

    public function fetchALLAnnonces($nbr) {
        $nbr = 3;
        for ($i = 1; $i <= $nbr; $i++) {
            $listpagehtml = file_get_html('http://www.wandaloo.com/occasion/?pg=' . $i);
            foreach ($listpagehtml->find('#left #resultat .sortable tbody .evenrow') as $item) {
                // $sphinx = new Sphinx();                
                // $stmt = $this->_db->query("SELECT * FROM sites WHERE name = 'wandaloo'");
                // $data = $stmt->fetch(PDO::FETCH_ASSOC);
                //  $idFetchAll = $data['idFetchsAll'];
                $link = $item->getAttribute('onclick');
                $link = str_replace("GoToLink('", '', $link);
                $link = str_replace("');", '', $link);
                $dataToSave = $this->getData($link, array());
                if (!empty($dataToSave)) {
                    $sphinx->SaveToSphinx($dataToSave);
                } else {
                    $i--;
                }

            }
        }
    }


}
