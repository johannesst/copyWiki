<?php
$STUDIP_BASE_PATH = realpath( dirname(__FILE__) . '/../../../..');
$include_path = get_include_path();
$include_path .= PATH_SEPARATOR . $STUDIP_BASE_PATH . DIRECTORY_SEPARATOR . 'public';

require_once $STUDIP_BASE_PATH . "/lib/bootstrap.php";
URLHelper::setBaseUrl($ABSOLUTE_URI_STUDIP);

page_open(array('sess' => 'Seminar_Session', 'auth' => 'Seminar_Default_Auth', 'perm' => 'Seminar_Perm', 'user' => 'Seminar_User'));
$perm->check('dozent');
if(isset($_REQUEST["to"]) AND isset($_REQUEST["from"])) {
    //Prüfen on User in beiden Vorlesungen Dozent ist
    $db = DBManager::get();
    $fromvl = $db->prepare("SELECT count(user_id)
                                FROM seminar_user
                                WHERE user_id LIKE ?
                                AND status = 'dozent'");
    $fromvl->execute(array($from));

    $fromvl =  $fromvl->fetchAll();

    if($fromvl[0]["count(user_id)"] == "1") $fromvl = true;

    $tovl = $db->prepare("SELECT count(user_id)
                                FROM seminar_user
                                WHERE user_id LIKE ?
                                AND status = 'dozent'");
    $tovl->execute(array($to));

    $tovl =  $tovl->fetchAll();

    if($tovl[0]["count(user_id)"] == "1") $tovl = true;


    if($tovl AND $fromvl) {
        //Löschen der alten Seiten
        $to = $_REQUEST["to"];
        $from = $_REQUEST["from"];
        $db = DBManager::get();

        $loeschen = $db->prepare('DELETE FROM studip.wiki WHERE wiki.range_id = ?');
        $loeschen->execute(array($to));

        $loeschen = $db->prepare('DELETE FROM studip.wiki_links WHERE wiki_links.range_id = ?');
        $loeschen->execute(array($to));

        $loeschen = $db->prepare('DELETE FROM studip.wiki_locks WHERE wiki_locks.range_id = ?');
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
            $WikiFrom = $db->prepare('INSERT INTO studip.wiki (
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
            $WikiFrom = $db->prepare('INSERT INTO studip.wiki_links (
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
            $WikiFrom = $db->prepare('INSERT INTO studip.wiki_links (
                user_id, range_id, keyword, chdate)
                VALUES (?, ?, ?, ?, ?, ?)');
            $WikiFrom->execute(array($f["user_id"],$to,$f["keyword"],$f["chdate"]));
        }

        echo json_encode(array("status" => "ok"));


    } else {
        echo json_encode(array("fehler" => "Keine Berechtigung"));
    }
}



?>
