function cancel_request(param){
    $('#myModalCompleteDetails').modal('show');
    $('#formid').val(param);
    return false;
}
function auto_formsubmit(){
    var val = $('#formid').val();
    var reason = $('#reasonbox').val();
    if(!reason){
        $('#reasonbox').css({'border':'1px solid red'});
        return false;
    }else{
        return true;
        //window.location = "/Orders/cancel_order/"+val;
    }
}
function order_formsubmit(){
    var username = $('#username').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    if(!username){
        $('#username').css({'border':'1px solid red'});
        return false;
    }else if(!email){
        $('#email').css({'border':'1px solid red'});
        return false;
    }else if(!phone){
        $('#phone').css({'border':'1px solid red'});
        return false;
    }else{
       return true;
    }
}
function reviews(id){
 $('#myModalCompleteDetailstwo').modal('show');
 $.ajax({
                type: 'POST',
                data: {v_id: id},
                url: '/vehicles/reviews',
                success: function(result){
                    $('#rts').html(result);
                },
                error: function(xhr, desc, err) {
                    console.log(xhr);
                }
            });
    }
