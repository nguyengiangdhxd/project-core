$(document).ready(function(){
    $("._logout").click(function(){
        $.ajax({
            data : '',
            url :'Login/logout',
            type :'POST'
        }).done(function(response){
            location.reload();
        });
    });
});
