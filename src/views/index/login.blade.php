@include('laravel-admin::common.header')
<link rel="stylesheet" href="{{ URL::asset('css/pc.css') }}">
<section class="" >
    <form method="post" action="/admin/login" id="login" class="">
        @csrf
        <div class="formtitle">
            <h2 class="text-center">后台登录</h2>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">用户名</label>
            <input type="text" name="username" class="form-control" value="">
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">密码</label>
            <input type="password" name="password" class="form-control " value="">
            <div class="invalid-feedback"></div>
        </div>

        <div class="alert alert-warning d-none" id="msg"></div>

        <button class="btn btn-primary" type="submit">登录</button>
    </form>
</section>
<script>
$(function (){
    $("#login").submit(function (event){
        event.preventDefault()
        event.stopPropagation()
        const form = $(this)
        if(form[0].checkValidity()===false){
        }else{
            let url = form.attr("action");
            let type = form.attr("method");
            if(url && type){
                $('#login input.form-control').removeClass('is-valid').removeClass('is-invalid');
                $.ajax({
                    type,url,
                    data: form.serialize(),
                    dataType: "json",
                    success: function(res){
                        $('#login input.form-control').addClass('is-valid');
                        if(!res.code) {
                            location.href = res.data.redirect
                        }else if(res.code===11000){
                            for(var item in res.data){
                                let str = ''
                                res.data[item].forEach((elem, index)=>{
                                    str = str+elem+'<br>'
                                })
                                let obj = $('#login input[name="'+item+'"]');
                                obj.removeClass('is-valid').addClass('is-invalid');
                                obj.next('.invalid-feedback').html(str);
                            }
                        }else{
                            $("#msg").text(res.msg).removeClass('d-none');
                        }
                    },
                    complete:function(XMLHttpRequest,textStatus){
                        //console.log(XMLHttpRequest,textStatus)
                    }
                })
            }else{
                console.log('no action')
            }
        }

    })
});
</script>
@include('laravel-admin::common.footer')
