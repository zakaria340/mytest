<?php

Class Utilities {

  public $_db;

  public function __construct($db) {
    $this->_db = $db;
  }

  public static function resizeandsave($images, $idSite, $imageUnique) {
    $width = 650;
    $size = GetimageSize($images);
    $height = round($width * $size[1] / $size[0]);
    $images_orig = ImageCreateFromJPEG($images);
    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);
    $images_fin = ImageCreateTrueColor($width, $height);
    ImageCopyResampled(
      $images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX,
      $photoY
    );
    ImageJPEG($images_fin, '../images/' . $idSite . '/' . $imageUnique);
    ImageDestroy($images_orig);
    ImageDestroy($images_fin);
    return $imageUnique;
  }

  public static function getVille($ville) {
    $db = new PDO(
      'mysql:host=localhost;dbname=searchannonces;charset=utf8', 'root',
      'ppHTNa3i'
    );
    $cleanString = Utilities::clean($ville);
    $stmt = $db->query(
      "SELECT * FROM villes WHERE slug LIKE '%" . $cleanString . "%'"
    );
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($data)) {
      return $data['idVilles'];
    }
    else {
      $db->exec(
        "INSERT INTO `villes`(`name`,`slug`) VALUES ('$ville','$cleanString')"
      );
      return $db->lastInsertId();
    }
    return $ville;
  }

  public static function getTags($tags) {
    $db = new PDO(
      'mysql:host=localhost;dbname=searchannonces;charset=utf8', 'root',
      'ppHTNa3i'
    );
    $listTags = array();
    foreach ($tags as $tag) {
      $cleanString = Utilities::clean($tag);
      $stmt = $db->query(
        "SELECT * FROM tags WHERE slug LIKE '%" . $cleanString . "%'"
      );

      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!empty($data)) {
        $listTags[$data['idTags']] = $tag;
      }
      else {
        $db->exec(
          "INSERT INTO `tags`(`name`,`slug`) VALUES ('$tag','$cleanString')"
        );
        $listTags[$db->lastInsertId()] = $tag;
      }
    }
    return $listTags;
  }


  public static function getTagsAnnonces($tagsExtra, $idAnnonce) {
    $db = new PDO(
      'mysql:host=localhost;dbname=searchannonces;charset=utf8', 'root',
      'ppHTNa3i'
    );
    foreach ($tagsExtra as $tag) {
      $cleanString = Utilities::clean($tag['label']);
      $stmt = $db->query(
        "SELECT * FROM tagsExtra WHERE slug LIKE '%" . $cleanString . "%'"
      );

      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!empty($data)) {
        // existe
        $idExtratag = $data['idTagsExtra'];
        $valuee = $tag['value'];
        $db->exec(
          "INSERT INTO `tagsAnnonces`(`idAnnonce`,`idTags`,`Value`) VALUES ('$idAnnonce','$idExtratag','$valuee')"
        );
      }
      else {
        $label = $tag['label'];
        $valuee = $tag['value'];
        //not exist
        $db->exec(
          "INSERT INTO `tagsExtra`(`slug`,`Title`) VALUES ('$cleanString','$label')"
        );
        $lastIdextra = $db->lastInsertId();
        $db->exec(
          "INSERT INTO `tagsAnnonces`(`idAnnonce`,`idTags`,`Value`) VALUES ('$idAnnonce','$lastIdextra','$valuee')"
        );
      }
    }
    return TRUE;
  }

  public static function clean($string) {
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
    $string = str_replace($a, $b, $string);
    $string = strtolower($string);
    $string = addslashes($string);
    $string = str_replace(' ', '-', $string);
    return $string;
  }

}
