/**
 * Created by alexander.andreev on 27.06.2017.
 */
$(document).ready(function () {

    $("#loginButton").click(function(){
        var login = $("#authUname").val();
        var pw = $("#authPw").val();

        var formedData = {
            "login":login,
            "pw":pw
        }
        $.ajax(
            {
                type: 'POST',
                url: 'index.php?r=main/login',
                dataType: 'json',
                data: formedData,
                success: function()
                {
                    alert('Auth success');
                },
                error: function()
                {
                    alert("Something went wrong");
                }
            }
        ).done(function(){
            alert('done');
        });

        return false;
    });
});
