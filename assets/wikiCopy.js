/**
 * Created with JetBrains PhpStorm.
 * User: johannesstichler
 * Date: 02.08.12
 * Time: 13:41
 * To change this template use File | Settings | File Templates.
 */
function copyWiki(vls)
{
    $.each(vls, function(index, value) {
                $.getJSON('/plugins_packages/neo/copyWiki/ajax.php', {
            from: $("#cid").val(),
            to: value
        }, function(data){
            if(data["status"] == "ok") {

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
                    }
                }
            );

            copyWiki(vls);
        });
});

