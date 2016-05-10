window.onload = function(){

    //Check File API support
    if(window.File && window.FileList && window.FileReader)
    {
        var filesInput = document.getElementById("files");

        filesInput.addEventListener("change", function(event){

            var files = event.target.files; //FileList object
            var output = document.getElementById("upload-preview-img");

            for(var i = 0; i< files.length; i++)
            {
                var file = files[i];

                //Only pics
                if(!file.type.match('image'))
                    continue;

                var picReader = new FileReader();

                picReader.addEventListener("load",function(event){

                    var picFile = event.target;

                    var div = document.createElement("li");
                    $(div).addClass("img-detail-ide m-b-15");

                    var html_inner = "<img src='" + picFile.result + "'/>";

                    html_inner += "<ul class='icon-hover-ide'>";

                    html_inner += '<li data-toggle="tooltip" data-original-title="Xóa ảnh"><a href="#"><i class="pg-trash"></i></a> </li>';

                    html_inner += '<li data-toggle="tooltip" data-original-title="Mở link ảnh"><a href="#"><i class="fa fa-link"></i></a> </li>';

                    html_inner += '</ul>';

                    div.innerHTML = html_inner;

                    output.insertBefore(div,null);

                });

                //Read the image
                picReader.readAsDataURL(file);
            }

        });
    }
    else
    {
        console.log("Your browser does not support File API");
    }
}
