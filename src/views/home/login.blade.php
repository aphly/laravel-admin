@include('laravel-admin::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/admin/css/login.css') }}">
<section class="login d-flex" >
    <div class="login1">
        <span>
            " 相伴十载，出发下一站 "
        </span>
    </div>
    <div class="login2">
        <form method="post" action="/admin/login" id="login" class="login_form">
            @csrf
            <div class="login_title">
                <span class="text-center">后台登录</span>
            </div>
            <h3 class="" style="">
                登录
                <span style="font-size:16px;display: none;">
                    没有帐号?
                    <a href="">注册</a>
                </span>
            </h3>
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="用户名" value="" >
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control " placeholder="密码" value="" >
                <div class="invalid-feedback"></div>
            </div>

            <div id="code_img" class="form-group @if(config('admin.seccode_admin_login')==1) @else none @endif">
                <div class="code_img">
                    <input type="text" name="code" class="form-control" value="" autocomplete="off" placeholder="验证码">
                    <img src="/center/seccode" onclick="code_img(this)" >
                </div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="d-flex justify-content-between">
                <span></span>
                <span style="display: none;"><a href="">忘记密码</a></span>
            </div>

            <div class="alert alert-warning d-none" id="msg"></div>
            <div class="login_btn">
                <button class="btn btn-primary " type="submit">登录</button>
            </div>

        </form>

        <div class="login_form">
            <div class="position-relative login_other" style="display: none;">
                <div class="login_hr"></div>
            </div>
            <hr class="login_hr">
            <p>©{{date('Y')}} - {{env('APP_URL')}}. All rights reserved.</p>
            <p>推荐使用 新版浏览器 访问本站</p>
        </div>
    </div>

</section>
<script>
$(function (){
    let form_id = '#login';
    $(form_id).submit(function (){
        const form = $(this)
        if(form[0].checkValidity()===false){
        }else{
            let url = form.attr("action");
            let type = form.attr("method");
            if(url && type){
                $(form_id+' input.form-control').removeClass('is-valid').removeClass('is-invalid');
                let btn_html = $(form_id+' button[type="submit"]').html();
                $.ajax({
                    type,url,
                    data: form.serialize(),
                    dataType: "json",
                    beforeSend:function () {
                        $(form_id+' button[type="submit"]').attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
                    },
                    success: function(res){
                        $(form_id+' input.form-control').addClass('is-valid');
                        if(!res.code) {
                            location.href = res.data.redirect
                        }else if(res.code===11000){
                            form_err_11000(res,form_id);
                        }else{
                            $("#msg").text(res.msg).removeClass('d-none');
                        }
                    },
                    complete:function(XMLHttpRequest,textStatus){
                        $(form_id+' button[type="submit"]').removeAttr('disabled').html(btn_html);
                    }
                })
            }else{
                console.log('no action')
            }
        }
        return false;
    })
});
</script>
@include('laravel-admin::common.footer')
