/**
 * Created with JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 02.08.12
 * Time: 13:41
 * To change this template use File | Settings | File Templates.
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
    getNameVls();
    $("#wiki_copy_assi_3").show();
    $("#step").val(4);
    $("#wiki_copy_assi_next").html('<span class="ui-button-text">Wiki kopieren</span>');
}

function copyWiki() {
    var vls = {};
    var folders = {};
    //Auslesen der Veranstaltungen
    vls = getAllVLs();
    folders = getAllFolders();
    startcopy(vls, folders);
         
}

function getNameVls() {
      $("#wiki_copy_assi_1 :input:checkbox:checked").each(
        function() {
            if(true) {
                $.post("ajax", {'todo': 'getname', 'vlid': $(this).val() }, function (data) {
                    $('#wiki_copy_vllist').append("<p>"+data + "</p>");
                     console.log(data);
                });
            }
        });
}

function startcopy(vls, folders) {
    hideall();
    $('#wiki_copy_assi_wait').toggle();
    $("#wiki_copy_assi_next").button({ disabled: true });
    $("#wiki_copy_assi_cancel").button({ disabled: true });
    $.post("ajax", {'todo': 'copy', 'vls': vls, 'folders': folders, 'from': $('#cid').val() },
        function (data) {
            if(data.length == 0) {
                  $('#wiki_copy_assi_wait').toggle();
                  $('#wiki_copy_assi_fertig').toggle();
            } else {
                $('#wiki_copy_assi_wait').toggle();
                $('#wiki_copy_assi_error').toggle();
                $('#wiki_copy_assi_error_msg').append(data);
            }
        });
}

function getAllVLs() {
    var anzahl = 0;
    var vls = {};
     $("#wiki_copy_assi_1 :input:checkbox:checked").each(
        function() {
            if(true) {
                console.log($(this).val());
                vls[anzahl] = $(this).val();
                anzahl++;
            }
        });
        return vls;
}

function getAllFolders() {
    var anzahl = 0;
    var folders = {};
     $("#wiki_copy_assi_2 :input:checkbox:checked").each(
        function() {
            if(true) {
                console.log($(this).val());
                folders[anzahl] = $(this).val();
                anzahl++;
            }
        });
        return folders;
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