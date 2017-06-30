/**
 * Created by alexander.andreev on 26.06.2017.
 */
$(document).ready(function(){

   $("#regButton").click(function(){
       var username = $("#uname").val();
       var email = $("#email").val();
       var password = $("#pw").val();
       console.log(uname);
       console.log(email);
       console.log(pw);
      // var pwr = $("#pwr").val();
       var data = {
           "username": username,
           "email": email,
           "password": password,
        //   "passwr": pwr
       };

      $.ajax(
          {
             type: 'POST',
             url: 'index.php?r=main/registration',
              dataType: 'json',
             data: data,
              success: function()
              {alert("Form submited");}
          }
      ).done(function()
      {

      });
      return false;
   });
});