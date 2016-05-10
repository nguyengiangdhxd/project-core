$(document).ready(function(){
    ChangePass.init();
});
$(window).on('load', function(){
    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy'
    });
});
var ChangePass = {
    init : function(){
        $(document).on('click','#_changePass', ChangePass.clickChangePass);
    },
    clickChangePass : function(){
        var old_pass = $('#old-password').val();
        var new_pass = $('#new-password').val();
        var res_pass = $('#retype-password').val();
        var errors = [];
        var $cpAlert = $('#cp-alert');
        if(!old_pass || !new_pass || !res_pass){
            $cpAlert.html('<strong>Lỗi!</strong><br>');
            $cpAlert.append("Hãy nhập đầy đủ thông tin !");
            $cpAlert.show();
            return;
        }
        if(new_pass != res_pass){
            $cpAlert.html('<strong>Lỗi!</strong><br>');
            $cpAlert.append("Mật khẩu khống giống nhau !");
            $cpAlert.show();
            return;
        }

        if(old_pass != new_pass && new_pass == res_pass){
            $.ajax({
                data : {
                    old_pass : old_pass,
                    new_pass : new_pass,
                    res_pass : res_pass
                },
                type : 'POST',
                url : 'CustomerProfile/change_password'
            }).done(function(response){
                if(response.type == 1){
                    bootbox.dialog({
                        message : "Bạn đã đổi mật khẩu thành công !",
                        title : "Hệ thống thông báo",
                        buttons : {
                            success : {
                                label : "OK",
                                className : 'btn-success',
                                callback : function () {}
                            }

                        }
                    });
                    setTimeout(function(){
                       logOut(); // logout ra khỏi trang
                    }, 3000);
                }else{
                    var errs= JSON.parse(response.message) || [];
                    errs.forEach(function (err) {
                        errors.push(err);
                    });
                    showError();
                }
            });
        }

        function showError(){
            $cpAlert.html('<strong>Lỗi!</strong><br>');
            $cpAlert.append(errors.join('<br />'));
            $cpAlert.show();
        }
        function logOut(){
            $.ajax({
                data : '',
                url :'Login/logout',
                type :'POST'
            }).done(function(response){
                location.reload();
            });
        }
    }
}