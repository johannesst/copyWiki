<h2>Wiki Kopieren</h2>
    <p>Hier haben Sie die möglichkeit das komplette dieser Vorlesung ( <?= $vorlesungsname ?> ) Wiki in eine ihrer anderen Vorlesungen zu kopieren. Beachten Sie dabei das Wiki in der Ziel Vorlesung gelöscht wird</p>
    <p>Infos über das Wiki dieser Vorlesungen:
        <div>Anzahl der Wiki Seiten: <?= $infos["seiten"] ?></div>
        <div>Letzte Änderung: <?= date("d.m.Y - G:i:s" ,$infos["aenderung"]) ?> </div>
    </p>

            <div><p>Liste der Vorlesungen</p></div>
            <div style="width: 100%; float: left;"><div style="width: 5%; float: left;">Auswahl</div><div style="width: 10%; float: left;">Semester</div><div style="width: 40%; float: left;">Vorlesungsname</div></div>
            <? foreach($vls as $v) : ?>
                <div style="width: 100%; float: left;"><div style="width: 5%; float: left;"><input type="checkbox" name="vorlesung" value="<?= $v["id"] ?>" ></div><div style="width: 10%; float: left;"><?= $v["sem_name"] ?></div><div style="width: 40%; float: left;"><?= $v["name"] ?></div></div>
            <? endforeach ?>
            <p>
                <p>Wiki dieser Vorlesung (Vorlesungsname) in die oben ausgew&auml;hlten Vorlesungen kopieren</p>
                <p><input type="checkbox" name="vorlesung" id="itsoktodelete" value="itsoktodelete">Ich bestätige das durch das kopieren des Wikis, die Wikis in den Ziel Vorlesungen unwiderruflich gelöscht werden. <a onclick="helpDelete();">Bei Fragen klicken Sie hier</a></p>
                <button id="buttonCopyWiki">Kopieren</button>
            </p>
            <div id="copystatus" style="display: none;">
                Status des Kopier Vorgangs:
                <div id="progressbar"></div>

            </div>

            <input id="cid" style="display: none;" value="<?= $cid ?>">


<div id="copyHelpDelete" style="display: none;">
    <h3>Hilfe</h3>
    <p>Mit dem Tool copyWiki haben Sie die Möglichkeit von einer Vorlesung das Wiki in mehrere Vorlesungen zu kopieren. Aus technischen Gründen wird das Wiki in der Ziel Vorlesung gelöscht</p>

</div>