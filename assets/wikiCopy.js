/**
 * Created with JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 02.08.12
 * Time: 13:41
 * To change this template use File | Settings | File Templates.
 */
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

