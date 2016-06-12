$(document).ready(function () {
    $(document).ajaxComplete(function(event, xhr, settings){
        try {
            var response = $.parseJSON(xhr.responseText);
            if(response.error_code =='E0001'){
                alert(response.message);
                setTimeout(function(){
                    location.reload();
                }, 2000);

            }

        } catch(e) {
            console.log("exception");
            //JSON parse error, this is not json (or JSON isn't in your browser)

        }
    });

    $(".loading-dot-dot-dot").Loadingdotdotdot({
        "speed": 400,
        "maxDots": 4,
        "word": $(this).data('text')
    });
});

