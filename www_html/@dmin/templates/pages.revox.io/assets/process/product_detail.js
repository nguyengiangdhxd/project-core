$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({html : true});
    $('select').select2({ // bỏ search box trong selectbox
        minimumResultsForSearch: -1
    });
    $("._inputTags").tagsinput('items');
    Product_detail.init(); // gọi load toàn bộ trang khi sử dụng handlbar
});
var Product_detail = {
    init : function(){
        var sourceSys =  $('#_render_sys').html();
        Product_detail.ForSys = Handlebars.compile(sourceSys); // complie source render đồng bộ

        var variant_source = $('#_render_variant_product').html();
        Product_detail.ForVariant = Handlebars.compile(variant_source); // complie source variant

        var option_product_source = $('#_render_option_product').html();//_option_items
        Product_detail.ForOption = Handlebars.compile(option_product_source);

        var log_action = $("#_render_log").html(); // logaction _log_user
        Product_detail.ForLog = Handlebars.compile(log_action);
        $("#_log_user").html(Product_detail.ForLog);

        var activity_action = $("#_render_activity").html();
        Product_detail.ForActivity = Handlebars.compile(activity_action);
       // $("#_activity_user").html(Product_detail.ForActivity);

        Product_detail.sendProductId(); // gọi hàm render ra các phần dồng bộ
        Product_detail.renderVariant();// goi hàm xử lý render các variant
        Product_detail.renderOption(); // gọi hàm xử lý render Option
        Product_detail.renderActivity(); // gọi hàm xử lý render ra các activity

        $(document).on('change','._switchy_sys', Product_detail.changeSwitchery);
        $(document).on('click', '#_btn_sys_product', Product_detail.clickSysProduct);// click đồng bộ sản phẩm
        $(document).on('click' , '._variant_save', Product_detail.clickSaveVariant); // sự kiện xảy ra khi click lưu lại giá trị
        $(document).on('change', '._change_variant_price', Product_detail.changeVariantPrice); // thay đổi khi save giá
        $(document).on('keypress', '._change_variant_price', Product_detail.keyPressVariantPrice); // thay đổi khi save giá
        $(document).on("click",'._save_option' , Product_detail.clickSaveOption); // click lưu lại option của sản phẩm
        $(document).on('keypress','._change_option', Product_detail.keyPressSaveOption);// khi ấn enter thì lưu lại giá trị
        $(document).on('click','#_btn_chat_submit', Product_detail.sendChatClick);
    },
    keyPressSaveOption : function(e){
        if(e.keyCode == 13){
            var key  = $(this).data('key');
            var title = $(this).val();
            var ordering = $(this).data('ordering');
            Product_detail.updateOption(title, key,ordering);
        }

    },
    clickSaveOption : function(){
        var key = $(this).data('key');
        var title = $("#_option_"+key).val();
        var ordering = $(this).data('ordering');
        Product_detail.updateOption(title, key,ordering);
    },
    /**
     * file update lại tiêu đề của sản phẩm
     * @param title
     * @param key
     * @param ordering
     */
    updateOption : function( title , key, ordering){
        item_options[key].name = title;
        item_options[key].ordering = ordering;
        $.ajax({
            url : 'product_detail/update_option_product',
            type : 'POST',
            data : {
                id : product_id ,
                app_key : app_key,
                store : store,
                option : item_options
            }
        }).done(function(response){
            if(response.type == 1){
                $("#_save_option_"+key).html('<i class="fa fa-check"></i>');
            }
        }).fail(function(){
            Product_detail.showPopupFail();
        })
    },
    // sự kiện thay đổi giá
    keyPressVariantPrice : function(e){
        var sale_price = $(this).val(); // giá
        var variant_id = $(this).data('variant-id');
        if(e.keyCode == 13){
            Product_detail.saveVariant(variant_id,sale_price);
        }
    },
    /**
     * bắt sự kiện change
     */
    changeVariantPrice : function(){
        var sale_price = $(this).val(); // giá
        var variant_id = $(this).data('variant-id');
        Product_detail.saveVariant(variant_id,sale_price);

    },
    /**
     * sự kiện click lưu lại giá của sản phẩm
     */
    clickSaveVariant : function(){
        var variant_id = $(this).data('variant-id');
        var sale_price = $('#_variant_price_'+variant_id).val();
        Product_detail.saveVariant(variant_id,sale_price);
    },
    /**
     * hàm chung sử dụng để lưu lại giá của variant
     * @param variant_id
     * @param salePrice
     */
    saveVariant : function(variant_id , salePrice){
        $.ajax({
            url : 'product_detail/get_variant_follow_id',
            type : 'POST',
            data : {
                id : product_id ,
                app_key : app_key,
                store : store,
                variant_id : variant_id,
                sale_price : salePrice
            }
        }).done(function(response){
            if(response.type == 1){
                // hiển thị báo thành công
                //<i class="fa fa-check"></i>
                $("#_variant_"+variant_id).html('<i class="fa fa-check"></i>');
            }else{
                console.info("error");
            }
        }).fail(function(){
            Product_detail.showPopupFail();
        });
    },
    /**
     * render hiển thị cho variant
     */
    renderVariant : function(){
        $.ajax({
            type : 'POST',
            url :'product_detail/get_variant_follow_id',
            data :{
                id : product_id ,
                app_key : app_key,
                store : store
            }

        }).done(function(response){
            if(response.type == 1){
                $("#_variant_product").html( Product_detail.ForVariant(response.data));
                $('.autonumeric').autoNumeric('init',{
                    aNum: '0123456789',
                    vMax: '99999999.99',
                    aSep: '.',
                    aDec: ',',
                    aPad: false, // bỏ dấu phẩy 0 đằng sau
                    dGroup: '3'
                });
            }else{
                console.info("error");
            }
        }).fail(function(){
            Product_detail.showPopupFail();
        })
    },
    /**
     * render khi bắt đầu vào trang
     */
    renderActivity : function(){
        $.ajax({
            type : 'POST',
            url : 'product_detail/load_and_update_activity',
            data : {
                id : product_id ,
                app_key : app_key,
                store : store
            }
        }).done(function(response){
            if(response.type == 1){
                $("#_activity_user").html(Product_detail.ForActivity(response.data));
            }else{
             console.info("error !");
            }
        }).fail(function () {
            Product_detail.showPopupFail();
        })  
    },
    sendChatClick : function(){
        var content_chat = $("#_content_chat").val();
        Product_detail.sendContentChat(content_chat);
    },
    /**
     * gửi nội dụng chat để lưu
     * @param content_chat
     */
    sendContentChat: function(content_chat){
        $("#_btn_chat_submit").addClass('disabled');
        $.ajax({
            type : 'POST',
            url : 'product_detail/load_and_update_activity',
            data : {
                id : product_id ,
                app_key : app_key,
                store : store,
                content: content_chat
            }
        }).done(function(response){
            if(response.type == 1){
                $("#_activity_user").html(Product_detail.ForActivity(response.data));
                var content_chat = $("#_content_chat").val('');
                $("#_btn_chat_submit").removeClass('disabled');

            }else{
                console.info("error !");
                $("#_btn_chat_submit").removeClass('disabled');
            }
        }).fail(function () {
            Product_detail.showPopupFail();
            $("#_btn_chat_submit").removeClass('disabled');
        })
    },
    
    /**
     * hàm render lại option
     */
    renderOption : function(){
        $.ajax({
            type : 'POST',
            url : 'product_detail/update_option_product',
            data : {
                id : product_id ,
                app_key : app_key,
                store : store
            }
        }).done(function(response){
            if(response.type == 1){
                $("#_option_items").html(Product_detail.ForOption(response.data));
            }else{
                console.info("error");
            }
        }).fail(function(){
            Product_detail.showPopupFail();
        });
    },
    /**
     * render lại phần đồng bộ
     * @param swichery
     */
    sendProductId : function(swichery){
        // lấy dữ liệu từ trạng thái của nút swichery
        $.ajax({
            type : 'GET',
            url : 'product_detail/get_item_product',
            data : {
                id : product_id ,
                app_key : app_key,
                store : store,
                active : swichery
            }
        }).done(function(response){
            if(response.type == 1){
                $("#_display_render_sys").html(Product_detail.ForSys(response.data));
                var elem = document.querySelector('._switchy_sys');
                var init = new Switchery(elem);
            }else{
                console.info("error");
            }
        }).fail(function(){
            Product_detail.showPopupFail();
        });
    },
    /**
     * sự kiện change switchery
     */
    changeSwitchery : function(){
        var changeCheckbox = document.querySelector('._switchy_sys');
        var switChery = changeCheckbox.checked ; // lấy giá trị của swithchery
        Product_detail.sendProductId(switChery);
    },
    clickSysProduct : function(){
        var item_id = $(this).data('item-id');
        // đẩy giá trị này vào hàm đồng bộ sản phẩm
        $.ajax({
            data : {
                items_id : item_id
            },
            type : 'GET',
            url : 'Synchronized/Sync'
        }).done(function(response){
            if(response.type == 1){
                $('#_btn_sys_product').addClass('disabled');
                $('#_status_sys').removeClass('hidden');
            }else{
                Product_detail.showPopupFail();
            }
        });

    },
    showPopupFail : function(){
        bootbox.dialog({
            message: "Không thể đồng bộ sản phẩm , kiểm tra lại đường truyền !",
            title: "<strong>Thông báo</strong>",
            buttons: {
                success: {
                    label: "OK",
                    className: 'btn-success',
                    callback: function () {
                    }
                }
            }
        });
    }

};