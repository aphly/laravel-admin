
<div class="top-bar">
    <h5 class="nav-title">修改头像 {{$res['info']['nickname']}}</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/user/{{$res['info']['uuid']}}/avatar" class="upload_form" onsubmit="uploadAvatar(event,this)" enctype="multipart/form-data">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">头像图片</label>
                <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" id="avatar" name="avatar" class="form-control-file " >
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

<script>
    function uploadAvatar(e,_this){
        e.preventDefault()
        e.stopPropagation()
        const form = $(_this)
        let formData = new FormData();
        formData.append('avatar', $("#avatar")[0].files[0]);
        formData.append('_token', '{{csrf_token()}}');
        let url = form.attr("action");
        let type = form.attr("method");
        if(url && type){
            $('.upload_form input.form-control').removeClass('is-valid').removeClass('is-invalid');
            $.ajax({
                type,url,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    $('.upload_form input.form-control').addClass('is-valid');
                    if(!res.code) {
                        $("#iload").load(res.data.redirect);
                        alert_msg(res)
                    }else if(res.code===11000){
                        for(var item in res.data){
                            let str = ''
                            res.data[item].forEach((elem, index)=>{
                                str = str+elem+'<br>'
                            })
                            let obj = $('.upload_form input[name="'+item+'"]');
                            obj.removeClass('is-valid').addClass('is-invalid');
                            obj.next('.invalid-feedback').html(str);
                        }
                    }else{
                        alert_msg(res)
                    }
                },
                complete:function(XMLHttpRequest,textStatus){
                    //console.log(XMLHttpRequest,textStatus)
                }
            })
        }else{
            console.log('no action'+url+type)
        }
    }
</script>
