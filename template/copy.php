<h2>Wiki Kopieren</h2>
    <p>Hier haben Sie die möglichkeit das komplette Wiki in eine ihrer anderen Vorlesungen zu kopieren. Beachten Sie dabei das Wiki in der Ziel Vorlesung gelöscht wird</p>
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
                Wiki dieser Vorlesung (Vorlesungsname) in die obenausgewählten Vorlesungen kopieren
                <button id="buttonCopyWiki">Kopieren</button>
            </p>
            <div id="copystatus" style="display: none;">
                Status des Kopier Vorgangs:
                <div id="progressbar"></div>

            </div>

            <input id="cid" style="display: ;" value="<?= $cid ?>">