$('#add_cart_btn').click(function (e) {
    e.preventDefault();
    var goods_num=$('#goods_num').val();
    var goods_id=$('#goods_id').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'/cart/adddb',
        type:'post',
        data:{goods_id:goods_id,goods_num:goods_num},
        dataType:'json',
        success:function (res) {
            if(res.error==301){
                window.location.href=url;
            }else{
                alert(res.msg);
            }
        }
    })
})