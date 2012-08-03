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
    $.each(vls, function(index, value) {
        alert(index+ "=>" + value);
        $.getJSON('/plugins_packages/neo/copyWiki/ajax.php', {
            from: $("#cid").val(),
            to: value
        }, function(data){
            if(data["status"] == "ok") {
                $( "#progressbar" ).progressbar({
                    value: nextstep
                });
                nextstep = nextstep + steps;
            }
        });


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
                    vls[anzahl] = $(this).val();
                    anzahl = anzahl + 1;

                }
            );

            copyWiki(vls, anzahl);
        });
});

