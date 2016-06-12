$(document).ready(function () {
    //-- BEGIN FILE UPLOAD
    $('#file-upload').fileupload({
        url: upload_url,
        //limitMultiFileUploads : 5,
        dataType: 'json',
        //disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator && navigator.userAgent),
        //disableImageResize: false,
        //imageMaxWidth: 800,
        //imageMaxHeight: 800,
        done: function (e, response) {
            var modalElem = $('#_upload-success-modal');
            if (response.result.type) {
                var result_html = 'Upload file <span class="semi-bold">'
                    +response.result.source_file.join(', ')
                    +'</span> thành công';
                modalElem.find('div#_upload-success-body').removeClass('hidden');
            } else {
                //need error report
                var result_html = 'Upload file thất bại';
            }
            modalElem.find('#_upload-success-header').html(result_html);
            modalElem.modal('show');

            if (response.result.type) {
                FileDataList.parse(response.result.id, function(data) {
                    var parse_success_ctn = modalElem.find('div#_parsing-success-body');
                    parse_success_ctn.find('span#_items-result-no').html(data.total_item);
                    parse_success_ctn.find('span#_variants-result-no').html(data.total_rows);
                    modalElem.find('#_upload-success-body').fadeOut();
                    parse_success_ctn.removeClass('hidden');
                });
            }

            /**
             $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo('#files');
            });
             **/
        }
    }).bind('fileuploadstop', function (e) {
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
    //-- end file upload

}).on('click', 'input._url-input', function() {
    $(this).select();
});

FileDataList = {
    initialized: false,
    tmp: null,
    init: function() {
        if (!this.initialized) {
            this.initialized = true;
        }
    },

    parse : function(files_id, callback) {
        var self = this;
        $.ajax({
            url : parse_file_url,
            type : "POST",
            data : {
                file_id: files_id[0]
            },
            success : function(response){
                self.preview(response);
                callback(response);
            }
        });
    },

    preview: function(data) {
        var self = this;
        self.init();
    }
};