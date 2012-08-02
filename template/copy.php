<h2>Wiki Kopieren</h2>
    <p>Hier haben Sie die m�glichkeit das komplette Wiki in eine ihrer anderen Vorlesungen zu kopieren. Beachten Sie dabei das Wiki in der Ziel Vorlesung gel�scht wird</p>
    <p>Infos �ber das Wiki dieser Vorlesungen:
        <div>Anzahl der Wiki Seiten: <?= $infos["seiten"] ?></div>
        <div>Letzte �nderung: <?= date("d.m.Y - G:i:s" ,$infos["aenderung"]) ?> </div>
    </p>
        <form action="copy">
            <div><p>Liste der Vorlesungen</p></div>
            <div style="width: 100%; float: left;"><div style="width: 5%; float: left;">Auswahl</div><div style="width: 10%; float: left;">Semester</div><div style="width: 40%; float: left;">Vorlesungsname</div></div>
            <? foreach($vls as $v) : ?>
                <div style="width: 100%; float: left;"><div style="width: 5%; float: left;">--</div><div style="width: 10%; float: left;"><?= $v["sem_name"] ?></div><div style="width: 40%; float: left;"><?= $v["name"] ?></div></div>
            <? endforeach ?>
            <p>
                Wiki dieser Vorlesung (Vorlesungsname) in die obenausgew�hlten Vorlesungen kopieren
                <button>Kopieren</button>
            </p>
        </form>
