/**	This package is part of FastWP framework.*	Is available with all themes for compatibility*/
var fastwp_shortcodes_loaded = true;
var fastwp_debug = false;
if (typeof fastwp_debug == 'undefined') {
    fastwp_debug = false;
}
if (typeof fastwp_owl_loaded == 'undefined') {
    var fastwp_owl_loaded = false;
}

jQuery(function ($) {
    $('.calculate_loan').on('change', function(e){
        var currency = $('input[name=loan_currency]:checked', '#calculate_loan').val();
        var bank = $('select[name=bank] :selected', '#calculate_loan').val();
        var timeout = $('select[name=timeout] :selected', '#calculate_loan').val();

        var do_job = $('input[name=do_job]', '#calculate_loan').val();
        // console.log(currency + '-' + bank + '-' + timeout)
        $.ajax({
            type : "post",
            dataType : "json",
            url : Ajax_var.ajaxurl,
            data : {action: "shortcode_action", do_job : do_job, currency : currency, bank : bank, timeout : timeout},
            success: function(response) {
                console.log(response)
                if(response.status == "success") {
                    $('input[name=lai_suat]', '#calculate_loan').val(response.val);
                }
                else {
                   alert("Lãi xuất này chưa cập nhật")
                }
            }
        })   

    });

    $('input[name=calculate_type]').on('change', function(){
        var calculate_type = this.value;
        var form_id = $(this).closest('form').attr('id');
        if(calculate_type == 'bank'){
            $('#'+form_id+' .bank_list').slideDown();
        }else{
            $('#'+form_id+' .bank_list').slideUp();
        }
    });

    $('.calculate_result').on('click', function(e){
        e.preventDefault();
        var type_form = $(this).data('type');
        var amount = $('input[name=amount]', '#calculate_'+type_form+'_form').val();
        // amount = amount.replace(",", "");
        if(amount != ''){
            var form_id = '#calculate_'+type_form+'_form';
            var currency = $(form_id+' input[name=loan_currency]:checked').val();
            var type = $(form_id+' input[name=calculate_type]:checked').val();
            var bank = $(form_id+' select[name=bank] :selected').val();
            var time = $(form_id+' select[name=time] :selected').val();
            var do_job = $(form_id+' input[name=do_job]').val();
            var type_calculate = 'loan_type_fixed';
            if(do_job == 'calculate_loan'){
               type_calculate =  $(form_id+' input[name=loan_type]:checked').val();
            }
            // console.log(amount + '-' + currency + '-' + type+ '-' + bank+ '-' + time)
            $('#listRepayment').html('');
            $(form_id+ ' .return_string').html('');
            $.ajax({
                type : "post",
                dataType : "json",
                url : Ajax_var.ajaxurl,
                data : {action: "shortcode_action", do_job : do_job, currency : currency, bank : bank, type : type, type_calculate : type_calculate, amount : amount, time : time},
                success: function(response) {
                    // response = jQuery.parseJSON(data);
                    // alert(response.status)
                    if(response.status == "success") {
                        $(form_id+ ' input[name=lai_suat]').val(response.lai_suat);
                        $(form_id+ ' input[name=lai]').val(response.lai);
                        $(form_id+ ' input[name=lanh]').val(response.lanh);
                        $(form_id+ ' .return_string').html(response.text);
                        if(response.table){
                            $('#listRepayment').html(response.table);
                        }
                    }else {
                       // alert("Lãi xuất này chưa cập nhật");
                        $(form_id+ ' input[name=lai_suat]').val('');
                        $(form_id+ ' input[name=lai]').val('');
                        $(form_id+ ' input[name=lanh]').val('');
                        $(form_id+ ' .return_string').html(response.text);
                    }
                }
            });
        }else{
           alert('Vui lòng nhập số tiền muốn gửi!') ;
        }  
    });

    $('.calculate_custom_loan').on('click', function(e){
        e.preventDefault();
        var form_id = '#custom_calculate_loan_form';
        var amount = $('input[name=amount]', form_id).val();
        var time = $('input[name=time]', form_id).val();
        var lai_xuat_nam = $('input[name=lai_xuat_nam]', form_id).val();
        var type_calculate =  $('input[name=loan_type]:checked', form_id).val();
        var do_job = $('input[name=do_job]', form_id).val();
        amount = amount.replace(",", "");
	
        if(amount != '' && time > 0 && lai_xuat_nam >0){
            $('#listRepayment').html('');
            $(form_id+ ' .return_string').html('');
            $.ajax({
                type : "post",
                dataType : "json",
                url : Ajax_var.ajaxurl,
                data : {action: "shortcode_action", do_job : do_job, lai_xuat_nam : lai_xuat_nam, type_calculate : type_calculate, amount : amount, time : time},
                success: function(response) {
                    // response = jQuery.parseJSON(data);
                    // alert(response.status)
                    if(response.status == "success") {
                        $(form_id+ ' input[name=lai_suat]').val(response.lai_suat);
                        $(form_id+ ' input[name=lai]').val(response.lai);
                        $(form_id+ ' input[name=lanh]').val(response.lanh);
                        $(form_id+ ' .return_string').html(response.text);
                        if(response.table){
                            $('#listRepayment').html(response.table);
                        }
                    }else {
                       // alert("Lãi xuất này chưa cập nhật");
                        $(form_id+ ' input[name=lai_suat]').val('');
                        $(form_id+ ' input[name=lai]').val('');
                        $(form_id+ ' input[name=lanh]').val('');
                        $(form_id+ ' .return_string').html(response.text);
                    }
                }
            });
        }else{
           alert('Vui lòng điền đầy đủ các thông tin!') ;
        }  
    });
});




var markers = [];
var info_window = [];


function formatNumber(input) {
        var val = input.value.replace(/\D/g, "");
        if (val.length == 4) val = val.substr(0, 1) + "," + val.substr(1, 3);
        else if (val.length == 5) val = val.substr(0, 2) + "," + val.substr(2, 5);
        else if (val.length == 6) val = val.substr(0, 3) + "," + val.substr(3, 6);
        else if (val.length == 7) val = val.substr(0, 1) + "," + val.substr(1, 3) + "," + val.substr(4, 6);
        else if (val.length == 8) val = val.substr(0, 2) + "," + val.substr(2, 3) + "," + val.substr(5, 8);
        else if (val.length == 9) val = val.substr(0, 3) + "," + val.substr(3, 3) + "," + val.substr(6, 9);
        else if (val.length == 10) val = val.substr(0, 1) + "," + val.substr(1, 3) + "," + val.substr(4, 3) + "," + val.substr(7, 10);
        else if (val.length == 11) val = val.substr(0, 2) + "," + val.substr(2, 3) + "," + val.substr(5, 3) + "," + val.substr(8, 3);
        else if (val.length == 12) val = val.substr(0, 3) + "," + val.substr(3, 3) + "," + val.substr(6, 3) + "," + val.substr(9, 3);
        else if (val.length == 13) val = val.substr(0, 1) + "," + val.substr(1, 3) + "," + val.substr(4, 3) + "," + val.substr(7, 3) + "," + val.substr(10, 13);
        input.value = val;
    }

    function formatMonth(input) {
        var val = input.value.replace(/\D/g, "");
        if (val.length > 0) val = val.substr() + " tháng";
        input.value = val;
    }



function setFullHeight(){
	var w_height = jQuery(window).height();
	jQuery('.fastwp-full-bg').outerHeight(w_height);
}