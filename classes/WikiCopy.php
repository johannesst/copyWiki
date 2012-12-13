<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Stellt die Funtkionen bereit die Notwending sind damit das Wiki Kopiert werden kann
 * Kopiert auch die Dateien zu einem Wiki
 * 
 * @author johannesstichler
 */
class neoWiki {
    function getDataFolders($cid) {
        $db = DBManager::get();
        $sql = "SELECT  f.name as 'Ordner', f.folder_id FROM `dokumente` as d  "
                   ."INNER JOIN folder as f on f.folder_id = d.`range_id` "
                   ."WHERE (`seminar_id` LIKE  ?) "
                   ."ORDER BY f.name";
        $folder = $db->prepare($sql);
        $folder->execute(array($cid));
        $folder =  $folder->fetchAll();
        $list = array();
        $flist = array();
        foreach($folder as $f) {
            if(array_search($f["folder_id"], $list) === false) {
                $list[] = $f["folder_id"];
                $flist[] = array("id" => $f["folder_id"], "name" =>$f["Ordner"]) ;
            }
        }
        return $flist;
    }
}

?>
