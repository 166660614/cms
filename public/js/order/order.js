$('.orderno').click(function (e) {
    e.preventDefault();
    var _this=$(this);
    var order_id=_this.parents('tr').attr('order_id');
    //console.log(cart_id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'/order/cancel',
        type:'post',
        data:{order_id:order_id},
        dataType:'json',
        success:function (res) {
           if(res.error!=301){
               alert(res.msg);
               _this.parents('tr').remove();
           }else{
               alert(res.msg);
           }
        }
    })
})