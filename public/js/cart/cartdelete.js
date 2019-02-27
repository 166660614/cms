$('.delete2').click(function (e) {
    e.preventDefault();
    var _this=$(this);
    var cart_id=_this.parents('tr').attr('cart_id');
    //console.log(cart_id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'/cart/delete2',
        type:'post',
        data:{cart_id:cart_id},
        dataType:'json',
        success:function (res) {
            if(res.error==301){
                window.location.href=url;
            }else{
                alert('删除成功');
                _this.parents('tr').remove();
            }
        }
    })
})
$('.order_buy').click(function (e) {
    e.preventDefault();
    var _this=$(this);
    var buy_num=_this.parents('tr').attr('buy_num');
    var goods_price=_this.parents('tr').attr('goods_price');
    var cart2_id=_this.parents('tr').attr('cart_id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'/buy/cart',
        type:'post',
        data:{buy_num:buy_num,goods_price:goods_price,cart_id:cart2_id,goods_id:goods_id},
        dataType:'json',
        success:function (res) {
            if(res.error!=301){
                alert('下单成功,请去支付');
                window.location.href='/order/detail';
            }else{
                window.location.href=url;
            }
        }
    })
})