<div id="wiki_copy_assi_static">
    <input id="cid" style="" value="<?= $cid ?>">
    <input id="step" style="" value="0">
</div>
<div id="wiki_copy_assi_0" class="wiki_copy_assi">
    <h1>Willkommen im Assistent zum Kopieren des Wikis</h1>
    <div class="wiki_copy_assi_text">Hier k&ouml;nnen sie den ganzen Inhalt dieser Veranstaltung ( <strong>  <?= $vorlesungsname ?> </strong> ) in eine andere Veranstaltung kopieren. Dabei haben Sie die Möglichkeit einen Ordner anzugeben in dem alle Bilder und Dateien gespeichert sind. Dieser Ordner wird dann auch Kopiert und die Links in dem neuen Wiki angepasst </div>
</div>

<div id="wiki_copy_assi_1" class="wiki_copy_assi">
    <h1>Bitte wählen Sie die Veranstaltung aus wohin das Wiki kopiert werden soll (Schritt 1) </h1>
        <div class="wiki_copy_assi_text">
            <div><p>Liste der Veranstaltungen</p></div>
            <div style="width: 100%; float: left;"><div style="width: 5%; float: left;">Auswahl</div><div style="width: 10%; float: left;">Semester</div><div style="width: 40%; float: left;">Veranstaltungsname</div></div>
                <? foreach($vls as $v) : ?>
                    <div style="width: 100%; float: left;">
                        <div style="width: 5%; float: left;">
                            <input type="checkbox" name="vorlesung" value="<?= $v["id"] ?>" >
                        </div>
                        <div style="width: 10%; float: left;"><?= $v["sem_name"] ?></div>
                        <div style="width: 40%; float: left;"><?= $v["name"] ?></div>
                    </div>
                <? endforeach ?> 
        </div>
</div>

<div id="wiki_copy_assi_2" class="wiki_copy_assi">
    <h1>Bitte wählen Sie den Ordner aus, welcher die Dateien f&uuml;r  das Wiki enth&auml;t (Schritt 2)</h1>
    <? foreach($folders as $f) : ?>
                    <div style="width: 100%; float: left;">
                        <div style="width: 5%; float: left;">
                            <input type="checkbox" name="folder" value="<?= $f["id"] ?>" >
                        </div>
                        <div style="width: 40%; float: left;"><?= $f["name"] ?></div>
                    </div>
                <? endforeach ?> 
</div>

<div id="wiki_copy_assi_3" class="wiki_copy_assi">
    <h1>Zusammenfassung (Schritt 3)</h1>
    <div class="wiki_copy_assi_text">
        Mit dem Klick auf Wiki-Kopieren wird das Wiki in die Angegebene Veranstaltungen kopiert. Der Inhalt wird von <strong>  <?= $vorlesungsname ?> </strong> in folgende Veranstaltungen kopiert <br /> <div id="wiki_copy_vllist"> </div>
</div>
</div>

<div id="wiki_copy_assi_wait" class="wiki_copy_assi" style="display: none;">
    <h1>der Kopiervorgang wird durchgeführt</h1>
    <div class="wiki_copy_assi_text">
        Das Kopieren wird durchgeführt. Dieser sollte nach wenigen Sekunden beendet sein.
</div>
</div>

<div id="wiki_copy_assi_fertig" class="wiki_copy_assi" style="display: none;">
    <h1>Kopiervorgang erflogreich</h1>
    <div class="wiki_copy_assi_text">
        Das Kopieren des Wikis war erfolgreich.
</div>
</div>

<div id="wiki_copy_assi_error" class="wiki_copy_assi" style="display: none;">
    <h1>Kopiervorgang nicht erflogreich</h1>
    <div class="wiki_copy_assi_text">
        Das Kopieren des Wikis war leider nicht erfolgreich. Die Fehlermeldung ist:
        <div id="wiki_copy_assi_error_msg"></div>
</div>
</div>

<div id="wiki_copy_assi_control">
    <div id="wiki_copy_assi_cancel">Abbrechen</div>
    <div id="wiki_copy_assi_next">Weiter -></div>
</div>