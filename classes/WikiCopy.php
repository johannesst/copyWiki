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
    
    function copyWiki ($from, $to) {
         //Prüfen on User in beiden Vorlesungen Dozent ist
    $db = DBManager::get();
    $fromvl = $db->prepare("SELECT count(user_id)
                                FROM seminar_user
                                WHERE user_id LIKE ?
                                AND Seminar_id = ?
                                AND status = 'dozent'");
    $fromvl->execute(array($GLOBALS['user']->id,$from));
    

    $fromvl =  $fromvl->fetchAll();

    if($fromvl[0]["count(user_id)"] == "1") $fromvl = true;
    else echo json_encode(array("fehler" => "Keine Berechtigungen auf der Stamm Veranstaltungen -> ".$GLOBALS['user']->id." -> ".$from));
    
    $tovl = $db->prepare("SELECT count(user_id)
                                FROM seminar_user
                                WHERE user_id LIKE ?
                                AND Seminar_id = ?
                                AND status = 'dozent'");
    $tovl->execute(array($GLOBALS['user']->id,$to));

    $tovl =  $tovl->fetchAll();

    if($tovl[0]["count(user_id)"] == "1") $tovl = true;
     else echo json_encode(array("fehler" => "Keine Berechtigungen auf der Ziel Veranstaltungen"));

    if($tovl AND $fromvl) {
        //Löschen der alten Seiten
        $db = DBManager::get();

        $loeschen = $db->prepare('DELETE FROM wiki WHERE wiki.range_id = ?');
        $loeschen->execute(array($to));

        $loeschen = $db->prepare('DELETE FROM wiki_links WHERE wiki_links.range_id = ?');
        $loeschen->execute(array($to));

        $loeschen = $db->prepare('DELETE FROM wiki_locks WHERE wiki_locks.range_id = ?');
        $loeschen->execute(array($to));


        //Auslesen der From-Wiki-Seiten
        //Wiki Seiten
        $WikiFrom = $db->prepare('SELECT *
                                        FROM wiki
                                        WHERE range_id LIKE ?
                                        ORDER BY chdate DESC');
        $WikiFrom->execute(array($from));

        $WikiFrom =  $WikiFrom->fetchAll();

        foreach($WikiFrom as $f) {
            $WikiFrom = $db->prepare('INSERT INTO wiki (
                range_id, user_id, keyword, body, chdate, version)
                VALUES (?, ?, ?, ?, ?, ?)');
            $WikiFrom->execute(array($to,$GLOBALS['user']->id,$f["keyword"],$f["body"],time(),$f["version"]));
        }

        //Links
        $WikiFrom = $db->prepare('SELECT *
                                        FROM wiki_links
                                        WHERE range_id LIKE ?');
        $WikiFrom->execute(array($from));

        $WikiFrom =  $WikiFrom->fetchAll();

        foreach($WikiFrom as $f) {
            $WikiFrom = $db->prepare('INSERT INTO wiki_links (
                range_id, from_keyword, to_keyword)
                VALUES (?, ?, ?)');
            $WikiFrom->execute(array($to,$f["from_keyword"],$f["to_keyword"]));
        }

        //Wiki-Locks

        $WikiFrom = $db->prepare('SELECT *
                                        FROM wiki_locks
                                        WHERE range_id LIKE ?
                                        ORDER BY chdate DESC');
        $WikiFrom->execute(array($from));

        $WikiFrom =  $WikiFrom->fetchAll();

        foreach($WikiFrom as $f) {
            $WikiFrom = $db->prepare('INSERT INTO wiki_links (
                user_id, range_id, keyword, chdate)
                VALUES (?, ?, ?, ?, ?, ?)');
            $WikiFrom->execute(array($f["user_id"],$to,$f["keyword"],$f["chdate"]));
        }

       // echo json_encode(array("status" => "ok"));


    } else {
        echo json_encode(array("fehler" => "Keine Berechtigung"));
    }
        
    }
    
    function copyFolders($vlid, $folders, $to) {
         $db = DBManager::get();
        foreach ($folders as $fo) {
            $sql = " SELECT *  FROM `dokumente` WHERE `seminar_id` LIKE ? AND `range_id` = ?";
            $files = $db->prepare($sql);
            $files->execute(array($vlid, $fo));
            $files =  $files->fetchAll();
            $newfolderid = $this->makeuid();       
            foreach($files as $file) {
                $oldpfad = $file["dokument_id"];
                $oldpfad = $GLOBALS["UPLOAD_PATH"]."/".$oldpfad[0] .  $oldpfad[1] . "/".  $oldpfad;
                $newid = $this->makeuid();        
                $newpfad = $GLOBALS["UPLOAD_PATH"]."/".$newid[0] .  $newid[1] . "/".  $newid;
                If(!is_dir($GLOBALS["UPLOAD_PATH"]."/".$newid[0] .  $newid[1] ))  mkdir($GLOBALS["UPLOAD_PATH"]."/".$newid[0] .  $newid[1] );
                    
                if(copy($oldpfad, $newpfad))
                { 
                    
                    //Datei erstellen
                    $sql = "INSERT INTO `dokumente` (
                                    `dokument_id` ,  `range_id` , `user_id` ,  `seminar_id` ,  `name` , `description` ,   `filename` ,  `mkdate` ,    `chdate` ,  `filesize` ,    `autor_host` ,     `downloads` ,  `url` ,     `protected` ,    `priority` ,  `author_name`
                                    )
                                    VALUES (
                                    ?,?,?, ?,?, ?,?,?,?,?,?,?, ?, ?, ?, ?
                                    )";
                    $files = $db->prepare($sql);
                    $files->execute(array($newid, $newfolderid, $file["user_id"],$to,$file["name"] , $file["description"] ,   $file["filename"] ,  $file["mkdate"] ,    $file["chdate"] ,  $file["filesize"] ,    $file["autor_host"] ,  $file["downloads"] ,  $file["url"] ,     $file["protected"] ,    $file["priority"] ,  $file["author_name"]));
                    //Im neuen Wiki alle Datein verknüpfungen erneuern
                    $sql = "update wiki set body  = replace(body,
                        'type=0&file_id=".$file["dokument_id"]."&file_name=".$file["filename"]."',
                        'type=0&file_id=".$newid."&file_name=".$file["filename"]."') 
                        WHERE range_id ='".$to."'";
                      $wikiupdate = $db->prepare($sql);
                      $wikiupdate->execute(array());
                } else echo "Fehler beim Kopieren";
            }
            $sql = "SELECT *  FROM folder  WHERE range_id = ?";
            $folderold = $db->prepare($sql);
            $folderold->execute(array($to));
            $folderold =  $folderold->fetchAll();
            $folderold = $folderold[0];
            If(empty($folderold["user_id"])) return false;
            
             $sql = "INSERT INTO `folder` (
                                    folder_id ,  range_id , user_id ,   name , description ,   permission ,  mkdate ,    chdate ,  priority 
                                    )
                                    VALUES (
                                    ?,?,?, ?,?, ?,?,?,?
                                    )";
              $foldernew = $db->prepare($sql);
             
           $foldernew->execute(array($newfolderid, $to,$folderold["user_id"],$folderold["name"],$folderold["description"],$folderold["permission"],$folderold["mkdate"],$folderold["chdate"],$folderold["priority"]));
            echo $newfolderid;
        }
    }

    function makeuid()
    {
        return md5(uniqid("jdfiuwenxclka")); // So werden in StudIP die UserIDs generiert
    }
    
}

?>
