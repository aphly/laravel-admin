<div class="top-bar">
   <h5 class="nav-title">首页</h5>
</div>
<div>
    <form method="post" action="/admin/test" id="test" class="">
        <div class="formtitle">
            <h2 class="text-center">后台登录</h2>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">用户名</label>
            <input type="text" name="username" class="form-control" value="">
            <div class="invalid-feedback"></div>
        </div>

        <div class="alert alert-warning d-none" id="msg"></div>
        <button class="btn btn-primary" type="submit">test</button>
    </form>
</div>
<script>
    $(function (){
        $("#test").submit(function (event){
            event.preventDefault()
            event.stopPropagation()
            const form = $(this)
            if(form[0].checkValidity()===false){
            }else{
                let url = form.attr("action");
                let type = form.attr("method");
                if(url && type){
                    $('#test input.form-control').removeClass('is-valid').removeClass('is-invalid');
                    $.ajax({
                        type,url,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(res){
                            console.log(res)
                            //$('#test input.form-control').addClass('is-valid');
                            // if(!res.code) {
                            //     location.href = res.data.redirect
                            // }else{
                            //     $("#msg").text(res.msg).removeClass('d-none');
                            // }
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
