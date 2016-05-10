/**
 * login của khách
 */
$(document).ready(function () {
    /*LoginCustomer.init();*/
});
/*
var LoginCustomer = {
 init : function(){
      $(document).on('click','#_btn_commit',LoginCustomer.clickLogin);
  },
    clickLogin : function(){
        var user_name = $("#_user_name").val();
        var passWord = $("#_password").val();
        $(this).addClass('disabled');
        if(!user_name || !passWord){
            return;
        }
        $.ajax({
            data : {passWord : passWord, userName : user_name},
            type : 'POST',
            url : 'Customer/login'
        }).done(function (response) {
            if (response.type == 0) {
                for(var i = 0; i < response.error.length ; i++){
                    $("._error").html(response.error[i]);
                    $("#_btn_commit").removeClass('disabled');
                }
            }
            if(response.type == 1){
                window.location="http://www.tutorialspoint.com";
                $("#_btn_commit").removeClass('disabled');
            }
        });
    }
};*/
