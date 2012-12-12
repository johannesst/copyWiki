<h2>Wiki kopieren</h2>
<div>Hier haben Sie die M&ouml;glichkeit, den kompletten Inhalt des Wikis der (Quell-)Veranstaltung <strong> <?= $vorlesungsname ?> </strong>  in das Wiki einer anderen (Ziel-)Veranstaltung zu kopieren. Bitte beachten Sie, dass Inhalte eines bereits bestehenden Wikis in der Zielveranstaltung damit gel&ouml;scht bzw. &uuml;berschrieben werden.</div>
<div>Infos ?ber das Wiki dieser Veranstaltung:
    <div>Anzahl der Wiki Seiten: <?= $infos["seiten"] ?></div>
    <div>Letzte &Auml;nderung: <?= date("d.m.Y - G:i:s" ,$infos["aenderung"]) ?> </div>
</div>
<div>
<div><p>Liste der Veranstaltungen</p></div>
<div style="width: 100%; float: left;"><div style="width: 5%; float: left;">Auswahl</div><div style="width: 10%; float: left;">Semester</div><div style="width: 40%; float: left;">Veranstaltungsname</div></div>
<? foreach($vls as $v) : ?>
<div style="width: 100%; float: left;"><div style="width: 5%; float: left;"><input type="checkbox" name="vorlesung" value="<?= $v["id"] ?>" ></div><div style="width: 10%; float: left;"><?= $v["sem_name"] ?></div><div style="width: 40%; float: left;"><?= $v["name"] ?></div></div><br>
<? endforeach ?>
</div>
<div><br>Wiki dieser Veranstaltung <strong>  <?= $vorlesungsname ?> </strong> in die oben ausgew&auml;hlten Veranstaltungen kopieren</div>
<div><input type="checkbox" name="vorlesung" id="itsoktodelete" value="itsoktodelete">Ich bin mir bewusst, dass durch Kopieren des Wiki-Inhalts dieser Veranstaltung eventuell vorhandene Wikis in den von mir oben ausgew&auml;hlten Zielveranstaltungen unwiderruflich gel&ouml;scht bzw.&uuml;berschrieben werden. <a  href='#' onclick="helpDelete();">Bei Fragen klicken Sie hier</a></div>
<div><button id="buttonCopyWiki">Kopieren</button></div>

<div id="copystatus" style="display: none;">
    Das Kopieren war erfolgreich
</div>

<input id="cid" style="display: none;" value="<?= $cid ?>">


<div id="copyHelpDelete" style="display: none;">
    <h3>Hilfe</h3>
    <p>Mit dem Tool copyWiki haben Sie die M?glichkeit von einer Veranstaltung das Wiki in mehrere Veranstaltungen zu kopieren. Aus technischen Gr?nden wird das Wiki in der Ziel Veranstaltung gel&ouml;scht</p>

</div>