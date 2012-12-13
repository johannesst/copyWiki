<?php
require_once 'classes/wikicopy.php';
/**
 * Created by JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 02.08.12
 * Time: 08:30
 * To change this template use File | Settings | File Templates.
 */
class copyWiki extends StudipPlugin implements SystemPlugin
{
    private $vlid, $userright;
    public function __construct() {
        global  $user, $perm, $auth;
        parent::__construct();
        $perm->studip_perms;
        if(isset($_REQUEST["auswahl"])) $this->vlid = $_REQUEST["auswahl"];
        if(isset($_REQUEST["cid"])) $this->vlid = $_REQUEST["cid"];
        if(isset($this->vlid)) {
            $userid = $GLOBALS['user']->id;
            $userrechte =   $perm->studip_perms;
            $this->userright = $userrechte[$this->vlid][$userid];
            if($this->userright == "dozent" AND Navigation::hasItem("/course/wiki")) {
                $navigation = new AutoNavigation("Wiki kopieren", PluginEngine::getURL($this, array(), "show"));
                Navigation::addItem('/course/wiki/copy', clone $navigation);
            }

        }

    }

    public function show_action() {
        $neowiki = new neoWiki();
        PageLayout::addStylesheet($this->getPluginURL() .'/assets/wikicopy.css');
        PageLayout::addScript($this->getPluginURL() . '/assets/wikiCopy.js');
        $template = $this->getTemplate("copy.php");
        $this->vlid = $_REQUEST["cid"];
        $template->set_attribute('folders', $neowiki->getDataFolders($this->vlid));
        $template->set_attribute('infos', $this->getWikiInfos());
        $template->set_attribute('vls', $this->getUserVl());
        $template->set_attribute('cid', $this->vlid);
        $template->set_attribute('vorlesungsname', $this->getVlName());
        echo $template->render();
    }

    private function getWikiInfos() {
        $db = DBManager::get();
        $anzahlSeiten = $db->prepare('SELECT count( `range_id` )
                                FROM `wiki`
                                WHERE `range_id` LIKE ?');
        $anzahlSeiten->execute(array($this->vlid));

        $seiten =  $anzahlSeiten->fetchColumn();
        $infos["seiten"] = $seiten["count(`range_id`)"];
        $db2 = DBManager::get();
        $aenderung = $db2->prepare('SELECT *
                                    FROM wiki
                                    WHERE range_id LIKE ?
                                    ORDER BY chdate DESC');
        $aenderung->execute(array($this->vlid));

        $laenderung =  $aenderung->fetchAll();
        $infos["aenderung"] = $laenderung[0]["chdate"];
        return $infos;
    }

    private function getUserVl() {
        $db = DBManager::get();
        $aenderung = $db->prepare("SELECT s.Seminar_id as id, s.Name as name, s.start_time FROM `seminare` as s
                                    INNER JOIN seminar_user as u ON s.`Seminar_id` = u.Seminar_id
                                    WHERE u.user_id = ? AND u.status = 'dozent'
                                    ORDER BY  s.start_time DESC");
        $aenderung->execute(array($GLOBALS['user']->id));

        $vls =  $aenderung->fetchAll();
       foreach($vls as $v) {
           if($this->vlid != $v["id"]) {
                $semester = $db->prepare("SELECT s.name, s.vorles_beginn as beginn, s.vorles_ende as ende  FROM `semester_data` as s
                                          WHERE beginn <= ? AND ende >= ?");
                $semester->execute(array($v["start_time"],$v["start_time"]));

                $sem =  $semester->fetchAll();
                $sem = $sem[0];

                $v["sem_name"] = $sem["name"];
                $vlliste[] = $v;
               
           }
       }

        return $vlliste;

    }

    private function getVlName() {
        $db = DBManager::get();
        $vl = $db->prepare("SELECT s.Seminar_id as id, s.Name as name FROM `seminare` as s
                            WHERE s.Seminar_id = ?");
        $vl->execute(array($this->vlid));

        $vls =  $vl->fetchAll();
        $name = $vls[0]["name"];
        return $name;
    }



















    protected function getDisplayName() {
        return "Wiki Kopieren ".$this->getVlName();
    }

    protected function getTemplate($template_file_name, $layout = "without_infobox") {
        if ($layout) {
            if (method_exists($this, "getDisplayName")) {
                PageLayout::setTitle($this->getDisplayName());
            } else {
                PageLayout::setTitle(get_class($this));
            }
        }
        if (!$this->template_factory) {
            $this->template_factory = new Flexi_TemplateFactory(dirname(__file__)."/template");
        }
        $template = $this->template_factory->open($template_file_name);
        if ($layout) {
            $template->set_layout($GLOBALS['template_factory']->open($layout === "without_infobox" ? 'layouts/base_without_infobox' : 'layouts/base'));
        }
        return $template;
    }

}
