Handlebars.registerHelper('vnd', function(money) {
    money = number_with_dot(money);
    return new Handlebars.SafeString(money + '<sup>đ</sup>');
});

Handlebars.registerHelper('cny', function(money) {
    if (!money) { money = 0;}
    return new Handlebars.SafeString('¥ ' + money.numberFormat(2,',','.'));
});

function number_with_dot(x) {
    if (!x) { x=0;}
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1.$2");
    return x;
}

Number.prototype.numberFormat = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


var xhr;
var ItemList = {
    init : function(){
        // render source cho list
        var source = $('#_render_list_items').html();
        ItemList.ForList = Handlebars.compile(source);
        // render source cho popup
        var sourcePopup = $("#_render_popup_edit").html();
        ItemList.ForPopUp = Handlebars.compile(sourcePopup);
        // end
        var dataForm = $('#_form_list_product').serialize();
        $.ajax({
            url : search_item,
            type : 'GET',
            data : dataForm
        }).done(function(response){
            if(response.type == 1){
                $("#_listProduct").html(ItemList.ForList(response.data));
                $('[data-toggle="tooltip"]').tooltip({html : true});
                $("._product_info").html(response.total_product);
                $.paging('paging', parseInt(response.page), parseInt(response.total_page), function(page) {
                    $('input[name="page"]').val(page);
                    ItemList.renderItemList();
                });
            }
        });

        $(document).on('click','._sys_bizWeb', ItemList.clickSysBizWeb);
        $(document).on('click', '._exportExcel', ItemList.clickExportExcel);
        $(document).on('change','#_form_list_product',ItemList.formChangeData);
        $(document).on('change', '._checkAll', ItemList.checkboxCheckAll);
        $(document).on('click', "._sys_items", ItemList.SysItems);
        $(document).on('keyup', '._checkRegular',ItemList.checkInputWeight);
        $(document).on('change',"._checkboxSys" , ItemList.changeCheckBox);
        $(document).on('click' , '._active_items', ItemList.activeItem);// khoá sản phẩm , mở sản phẩm
        $(document).on('click' , '._delete_items' , ItemList.deleteItem);// xóa sản phẩm
        $(document).on('click', '._sortCreatedTime', ItemList.sortCreatedTime); // createdTime
        $(document).on('click' , '._priceOrigin', ItemList.sortPriceOrigin);// sort theo giá  gốc
        $(document).on('click', '._priceSale', ItemList.sortPriceSale); // sort theo giá bán
        $(document).on('click', '._lock_active' , ItemList.lockActive); // khóa hoạt động
        $(document).on('click', '._delete_array_items', ItemList.deleteArrayItem); // xóa mảng các sản phẩm
        $(document).on('click','._edit_items', ItemList.showPopupEdit); // mở popup edit sản phẩm
        $(document).on('click' , '._variant_save', ItemList.saveEditVariant); // khi click nút lưu lại sản phẩm
       /// $(document).on('keyup','._inputTags', ItemList.removeRegex); // xóa kí tự dấu phaayr



    },
   /* removeRegex : function(){
        //this.value = this.value.replace(/[^0-9\a-z.]/g,'');
    },*/

    /**
     * khi click vào nút lưu trêm pop up sửa nhanh sản phẩm
     */
    saveEditVariant: function(){
        var id_product = $(this).data('product-id');
        var inputTags =  $("._inputTags").val();
        var list_variant = [];
        var statusCheck = $("._onlyUpdatePrice").prop('checked');
        if(statusCheck){
            statusCheck = true;
        }else{
            statusCheck = false;
        }
        $('._change_variant_price').each(function () {
            var objVariant = {};
            objVariant.id = $(this).data('variant-id');
            objVariant.price = $(this).val();
            list_variant.push(objVariant);
        });
        var product_title = $("._product_title").val();
        // lấy giá trị của radiobutton
        if(xhr && xhr.readyState != 4){
            xhr.abort();
        }
        xhr = $.ajax({
            url : 'product_list/update_items',
            data : {
                product_id : id_product,
                list_variant : list_variant,
                product_title : product_title,
                only_update_price : statusCheck,
                input_tags : inputTags
            },
            type: 'POST'
        }).done(function(response){
            if(response.type == 1){
                $.notify('Cập nhật sản phẩm thành công !' , 'success');
                ItemList.renderItemList();
            }
        });

    },

    showPopupEdit : function(){
        $("#myModal").modal('show');
        var item_id = $(this).data('item-id');
        ItemList.sendRequestGetItemVariant(item_id);
    },
    sendRequestGetItemVariant : function(id_product){
        $.ajax({
            url : 'product_list/Get_items_variant_follow_item',
            data : {'id' : id_product},
            type : 'POST'

        }).done(function(response){
            if(response.type == 1){
                $("#_popup_edit_product").html(ItemList.ForPopUp(response.data));
                $('._list_variant').slimScroll({
                    height: '400px',
                    alwaysVisible: true
                    //max-height: '50px'
                });
                $("._inputTags").tagsinput('items');// render ra input tag
                $('.autonumeric').autoNumeric('init',{
                    aNum: '0123456789',
                    vMax: '99999999.99',
                    aSep: '.',
                    aDec: ',',
                    aPad: false, // bỏ dấu phẩy 0 đằng sau
                    dGroup: '3'
                });
            }

        });
    },
    /**
     * xoá một lúc nhiều sản phẩm
     */
    deleteArrayItem : function(){

        var list_product_id = [];
        $('._checkboxSys:checked').each(function () {
            list_product_id.push($(this).attr('rel'));
        });
        if(list_product_id.length == 0){
            bootbox.dialog({
                message: "Hãy tick chọn sản phẩm muốn đồng bộ !",
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
            return;
        }
        bootbox.dialog({
            message: "Bạn có chắc muốn xóa sản phẩm đã chọn ?",
            title: "<strong>Xác nhận</strong>",
            buttons: {
                danger: {
                    label: "Xóa",
                    className: "btn-danger",
                    callback: function() {
                        $.ajax({
                            url : 'product_list/delete_array_items',
                            type : 'POST',
                            data : {
                                product_id : list_product_id
                            }

                        }).done(function(response){
                            if(response.type == 1){
                                ItemList.renderItemList();
                            }else{
                                console.info("lỗi xóa mảng !");
                            }
                        });
                    }
                },
                main: {
                    label: "Hủy",
                    className: "btn-success",
                    callback: function() {

                    }
                }
            }
        });

    },

    /**
     * chuyển trạng thái của sản phẩm
     */
    lockActive : function(e){
        e.preventDefault();
        var activeValue = $(this).data('code');
        var list_product_id = [];
        $('._checkboxSys:checked').each(function () {
            list_product_id.push($(this).attr('rel'));
        });
        if(list_product_id.length == 0){
            bootbox.dialog({
                message: "Hãy tick chọn sản phẩm muốn đồng bộ !",
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
            return;
        }
        $.ajax({
            url :'product_list/change_status_product',
            type : 'POST',
            data : {
                product_id : list_product_id,
                activeValue : activeValue
            }
        }).done(function(response){
            if(response.type == 1){
                var name = '';
                if(activeValue == 'ACTIVE'){
                    name = 'mở khóa'
                }else{
                    name = 'khóa'
                }
                ItemList.renderItemList();
                // hiển thị thông bnaos sau đóp mất đi
               var $array =  response.success_active;
                for(var j = 0 ; j < $array.length ; j++ ){
                    if($("._checkAll").prop('checked') == true){
                        $.notify(name + ' thành công hoạt động của các sản phẩm đã chọn' , 'success');
                        return;
                    }else{
                        $.notify( name + ' thành công hoạt động sản phẩm có id ' + $array[j] , 'success');
                    }

                }

            }
        })
    },
    /**
     * sort theo giá bán min
     */
    sortPriceSale : function(){
        var conditionName = $(this).data('code');
        var condition = $(this).data('value');
        ItemList.sortConditional(conditionName,condition);
    },

    /**
     * sort theo giá gốc min
     */
    sortPriceOrigin : function(){
        var conditionName = $(this).data('code');
        var condition = $(this).data('value');
        ItemList.sortConditional(conditionName,condition);
    },
    /**
     * sort theo thời gian
     */
    sortCreatedTime : function(){
        var conditionName = $(this).data('code');
        var condition = $(this).data('value');
        ItemList.sortConditional(conditionName,condition);
    },
    /**
     * sort theo điều kiện truyền vào
     * @param conditionName
     * @param condition
     */
    sortConditional : function(conditionName, condition){
        var dataFormValue = $('#_form_list_product').serialize();
        var dataForm = dataFormValue  + '&sortCondition='+conditionName + '&condition='+condition;
        var page = $("#current_page").val();
        var pageUrl = list_item_url +'?'+ dataForm;
        ItemList.push_state(pageUrl);
        $.ajax({
            url : search_item,
            type : 'GET',
            data : dataForm
        }).done(function(response){
            if(response.type == 1){
                $("#_listProduct").html(ItemList.ForList(response.data));
                $('[data-toggle="tooltip"]').tooltip({html : true});
                $("._product_info").html(response.total_product);
                $.paging('paging',parseInt(response.page) ,parseInt(response.total_page), function(page) {
                    $('input[name="page"]').val(page);
                    ItemList.renderItemList();
                });
            }
        });
    },
    /**
     * xóa sản phẩm của , xóa một sản phẩm
     */
    deleteItem : function(){
        var product_id = $(this).data('id-item');

        bootbox.dialog({
            message: "Bạn có chắc muốn xóa sản phẩm đã chọn ?",
            title: "<strong>Xác nhận</strong>",
            buttons: {
                danger: {
                    label: "Xóa",
                    className: "btn-danger",
                    callback: function() {
                        $.ajax({
                            url : 'product_list/delete_items',
                            type : 'POST',
                            data : {
                                product_id : product_id
                            }
                        }).done(function(response){
                            if(response.type == 1){
                                ItemList.renderItemList();
                            }else{
                                console.info("fail");
                            }
                        });
                    }
                },
                main: {
                    label: "Hủy",
                    className: "btn-success",
                    callback: function() {

                    }
                }
            }
        });
    },
    /**
     * chuyển trạng thái của sản phẩm
     */
    activeItem : function(){
        var product_id = $(this).data('product-id');
        var active_item = $(this).data('active');
        $.ajax({
            url : 'product_list/change_active_items',
            type : 'POST',
            data : {
                active : active_item,
                product_id : product_id
            }
        }).done(function(response){
            if(response.type == 1){
                ItemList.renderItemList();
                console.info("success");
            }else{
                console.info("fail");
            }
        });

    },

    changeCheckBox : function(){
        var numberNotChecked = $('._checkboxSys:not(":checked")').length;
        if(numberNotChecked  == 0){
            $('._checkAll').prop('checked',true);
        }else{
            $('._checkAll').prop('checked',false);
        }
    },
    checkInputWeight : function(){
        this.value = this.value.replace(/[^0-9\.]/g,'');
    },
    checkboxCheckAll : function(){
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    },
    clickSysBizWeb : function(e){
        var productId = $(this).data('code');
                $.ajax({
                    data : {
                        items_id : productId
                    },
                    type : 'GET',
                    url : 'Synchronized/Sync'
                }).done(function(response){
                    if(response.type == 1){
                        $("#_button_sys_" + productId).addClass('disabled');
                    }
                });

    },
    renderItemList : function(){
        if(xhr && xhr.readyState != 4){
            xhr.abort();
        }
        var dataForm = $('#_form_list_product').serialize();
        var page = $("#current_page").val();
        var pageUrl = list_item_url +'?'+ dataForm;
        ItemList.push_state(pageUrl);
        xhr = $.ajax({
            url : search_item,
            data : dataForm,
            type: 'GET'
        }).done(function(response){
            if(response.type == 1){
                $("#_listProduct").html(ItemList.ForList(response.data));
                $('[data-toggle="tooltip"]').tooltip({html : true});
                $("._product_info").html(response.total_product);
                $.paging('paging',parseInt(response.page) ,parseInt(response.total_page), function(page) {
                    $('input[name="page"]').val(page);
                    ItemList.renderItemList();
                });

            }
        });
    },
    formChangeData : function(){
        $("#current_page").val(1);
        ItemList.renderItemList();
    },
    push_state : function(pageurl) {
        if (pageurl != window.location) {
            window.history.pushState({path: pageurl}, '', pageurl);
        }
    },
    clickExportExcel : function(){
        // lấy ra param sau đó gắn lên trên url
        var data = $('#_form_list_product').serialize();
        window.location = 'product_list/export_excel_items?'+ data;
    },
    SysItems : function(e){
        e.preventDefault();
        var list_product_id = [];
        $('._checkboxSys:checked').each(function () {
            list_product_id.push($(this).attr('rel'));
        });
        if(list_product_id.length == 0){
            bootbox.dialog({
                message: "Hãy tick chọn sản phẩm muốn đồng bộ !",
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
            return;
        }
        $.ajax({
            data : {
                items_id : list_product_id
            },
            type : 'GET',
            url : 'Synchronized/Sync'
        }).done(function(response){
            if(response.type == 0){
                bootbox.alert(response.message);
            }
            if(response.type == 1){
                if(response.sucess_ids){ // mảng id các sản phẩm có id có đủ điều kiện dfdoodngf bộ
                    for(var sid = 0 ; sid <= response.sucess_ids.length ; sid++){
                        $("#_btn_sys_" +  response.sucess_ids[sid]).addClass("disabled");
                    }
                }
                // TODO : chưa xử lý trường hợp mảng chưa các id items ko đủ điều kiện ko đồng bộ thành công
            }
        });
    }
};

$(document).ready(function () {
    ItemList.init();
    $('[data-toggle="tooltip"]').tooltip({html : true});
    $('select').select2({ // bỏ search box trong selectbox
        minimumResultsForSearch: -1
    });
    /*$(function(){
        $('#_edit_product_variant').slimScroll({
            height: '500px'
        });
    });*/
    //$('input').uniform();
});