/**
 * Created with JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 02.08.12
 * Time: 13:41
 * To change this template use File | Settings | File Templates.
 */
/*
function copyWiki(vls, anzahl)
{
    var steps = 100/anzahl;
    var nextstep = steps;
    var zahl = 0 
    $.each(vls, function(index, value) {
        //alert(zahl+ "=>" + anzahl);
        $.getJSON('/plugins_packages/neo/copyWiki/ajax.php', {
            from: $("#cid").val(),
            to: value
        }, function(data){
            if(data["status"] == "ok") {
                $( "#progressbar" ).progressbar({
                    value: nextstep
                });
                nextstep = nextstep + steps;
		zahl = zahl + 1;
		if(zahl == anzahl) {
			alert("Das Kopieren war erfolgreich");
		}
            }
        });


    });
}

function helpDelete() {
    $('#copyHelpDelete').dialog({
        minWidth: 400,
        modal: true,
        buttons: {
            "Ok": function() {
                $(this).dialog("close");
            }
        }
    });
}

$(document).ready(function(){
    $("#buttonCopyWiki").button();
    $("#buttonCopyWiki").click(
        function () {
            var anzahl = 0;
            var vls = {};
            $("#copystatus").show();
            $(":input:checkbox:checked").each(
                function() {
                    if($(this).val() != "itsoktodelete") {
                        vls[anzahl] = $(this).val();
                        anzahl = anzahl + 1;
                    }
                }
            );

            copyWiki(vls, anzahl);
        });
});
*/
function cancel() {
    $("#step").val(0);
    step1();
    console.log("Das geht noch nicht");
}

function next() {
    var  step = $("#step").val();
    step = parseInt(step);
    if(typeof(step == "number")) {
        switch(step) {
            case 0: step1(); break;
            case 1: step2(); break;
            case 2: step3(); break;
            case 3: step4(); break;
            case 4: copyWiki(); break;
                default: cancel();
        }
    } else alert("step hat einen Falschen Wert -> " + typeof(step));
}

function step1() {
    hideall();
     $("#wiki_copy_assi_0").show();
     
     $("#step").val(1);
     $("#wiki_copy_assi_next").html('<span class="ui-button-text">Weiter -></span>');
}

function step2() {
    hideall();
     $("#wiki_copy_assi_1").show();
     $("#step").val(2);
}

function step3() {
    hideall();
    $("#wiki_copy_assi_2").show();
    $("#step").val(3);
}

function step4() {
    hideall();
    $("#wiki_copy_assi_3").show();
    $("#step").val(4);
    $("#wiki_copy_assi_next").html('<span class="ui-button-text">Wiki kopieren</span>');
}

function copyWiki() {
    var anzahl = 0, vls = {};
    var folderanzahl = 0, folders = {};
    //Auslesen der Veranstaltungen
    $("#wiki_copy_assi_1 :input:checkbox:checked").each(
        function() {
            if(true) {
                console.log($(this).val());
                vls[anzahl] = $(this).val();
                anzahl++;
            }
        });
        //Auslesen der zu kopierenden Ordner
        $("#wiki_copy_assi_2 :input:checkbox:checked").each(
        function() {
            if(true) {
                console.log($(this).val());
                folders[folderanzahl] = $(this).val();
                folderanzahl++;
            }
        });
         alert(anzahl);
        //Fuer jede ausgewaehlte Veranstalltung soll das Wiki kopiert werden
         $.each(vls, function(index, value) {
            $.getJSON('plugins.php/copywiki/ajax', {
               from: $("#cid").val(),
               to: value,
               todo: copyWiki
           }, function(data){
               if(data["status"] == "ok") {
                           if(index == anzahl) {
                               alert("Das Kopieren war erfolgreich");
                       }
               }
           });
           //Dabei sollen auch gleich alle Dateien bzw. Ordner kopiert werden.
          /*
           $.each(folders, function(index, fol) {
                    $.getJSON('plugins.php/copywiki/ajax', {
                        from: $("#cid").val(),
                        to: value,
                        todo: copydata,
                        what: fol
                    }, function(data){
                        if(data["status"] == "ok") {
                                    if(index == anzahl) {
                                        alert("Das Kopieren war erfolgreich");
                                }
                        }
                    });
           }); */
    });
        
                
}


function hideall() {
      $("#wiki_copy_assi_0").hide();
      $("#wiki_copy_assi_1").hide();
      $("#wiki_copy_assi_2").hide();
      $("#wiki_copy_assi_3").hide();
}

$(document).ready(function(){
    step1();
    $("#wiki_copy_assi_cancel").button().click(function () { cancel(); });
    $("#wiki_copy_assi_next").button().click(function () { next(); });
    
});