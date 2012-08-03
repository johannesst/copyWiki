<?php
$STUDIP_BASE_PATH = realpath( dirname(__FILE__) . '/../../../..');
$include_path = get_include_path();
$include_path .= PATH_SEPARATOR . $STUDIP_BASE_PATH . DIRECTORY_SEPARATOR . 'public';

require_once $STUDIP_BASE_PATH . "/lib/bootstrap.php";
URLHelper::setBaseUrl($ABSOLUTE_URI_STUDIP);

page_open(array('sess' => 'Seminar_Session', 'auth' => 'Seminar_Default_Auth', 'perm' => 'Seminar_Perm', 'user' => 'Seminar_User'));
$perm->check('dozent');
if(isset($_REQUEST["to"]) AND isset($_REQUEST["from"])) {
    //Löschen der alten Seiten
    $to = $_REQUEST["to"];
    $from = $_REQUEST["from"];
    $db = DBManager::get();

    $loeschen = $db->prepare('DELETE FROM studip.wiki WHERE wiki.range_id = ?');
    $loeschen->execute(array($to));

    //Auslesen der From-Wiki-Seiten
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

  echo json_encode(array("status" => "ok"));
}



?>