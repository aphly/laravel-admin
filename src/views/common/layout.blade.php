@include('laravel-admin::common.header')
<link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}">
<section class="admin container-fluid">
    <div class="row">
        <div class="ad_left d-none d-lg-block">
            <div class="navbar_brand_box">
                <span class="logo">管理中心</span>
            </div>
            <div class="menu">
                <dl class="accordion" id="s_nav">
                    <dd class="">
                        <a class="s_nav_t text-left dj"  data-title="首页" data-href="/admin/index/index">
                            <i class="uni app-haoyou z"></i> 面板
                        </a>
                    </dd>
                    <dd class="">
                        <a class="s_nav_t text-left" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                            <i class="uni app-haoyou z"></i> 网站设置 <i class="uni app-xia y"></i>
                        </a>
                        <div id="collapse5" class="collapse ">
                            <ul class="card-body">
                                <li class=""><a class="dj" data-title="网站设置" data-href="/admin/setting/index">网站设置</a></li>
                                <li class=""><a class="dj" data-title="短信设置" data-href="/admin/setting/sms">短信设置</a></li>
                                <li class=""><a class="dj" data-title="微信登录" data-href="/admin/setting/wechat">微信登录</a></li>
                                <li class=""><a class="dj" data-title="OSS设置" data-href="/admin/setting/oss">OSS设置</a></li>
                                <li class=""><a class="dj" data-title="支付宝" data-href="/admin/setting/payali">支付宝</a></li>
                                <li class=""><a class="dj" data-title="微信支付" data-href="/admin/setting/paywechat">微信支付</a></li>
                            </ul>
                        </div>
                    </dd>
                    <dd class="">
                        <a class="s_nav_t text-left" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            <i class="uni app-haoyou z"></i> 用户管理 <i class="uni app-xia y"></i>
                        </a>
                        <div id="collapse1" class="collapse ">
                            <ul class="card-body">
                                <li class=""><a class="dj" data-title="用户列表" data-href="/admin/manager/index">用户列表</a></li>
                                <li class=""><a class="dj" data-title="角色管理" data-href="/admin/role/index">角色管理</a></li>
                                <li class=""><a class="dj" data-title="权限管理" data-href="/admin/permission/index">权限管理</a></li>
                                <li class=""><a class="dj" data-title="菜单管理" data-href="/admin/menu/index">菜单管理</a></li>
                            </ul>
                        </div>
                    </dd>
                    <dd class="">
                        <a class="s_nav_t text-left" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                            <i class="uni app-haoyou z"></i> 邮件管理 <i class="uni app-xia y"></i>
                        </a>
                        <div id="collapse2" class="collapse ">
                            <ul class="card-body">
                                <li class=""><a class="dj" data-title="邮件设置" data-href="/admin/email/edit">邮件设置</a></li>
                                <li class=""><a class="dj" data-title="邮件测试" data-href="/admin/email/index">邮件测试</a></li>
                            </ul>
                        </div>
                    </dd>
                    <dd class="">
                        <a class="s_nav_t text-left" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <i class="uni app-haoyou z"></i> 缓存管理 <i class="uni app-xia y"></i>
                        </a>
                        <div id="collapse3" class="collapse ">
                            <ul class="card-body">
                                <li class=""><a class="dj" data-title="缓存管理" data-href="/admin/cache/index">缓存管理</a></li>
                            </ul>
                        </div>
                    </dd>
                    <dd class="">
                        <a class="s_nav_t text-left" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
                            <i class="uni app-haoyou z"></i> 队列管理 <i class="uni app-xia y"></i>
                        </a>
                        <div id="collapse6" class="collapse ">
                            <ul class="card-body">
                                <li class=""><a class="dj" data-title="队列模式" data-href="/admin/queue/set">队列模式</a></li>
                                <li class=""><a class="dj" data-title="队列管理" data-href="/admin/queue/index">队列管理</a></li>
                                <li class=""><a class="dj" data-title="失败队列" data-href="/admin/queue/index">失败队列</a></li>
                            </ul>
                        </div>
                    </dd>
                    <dd class="">
                        <a class="s_nav_t text-left" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                            <i class="uni app-haoyou z"></i> 任务计划 <i class="uni app-xia y"></i>
                        </a>
                        <div id="collapse4" class="collapse ">
                            <ul class="card-body">
                                <li class=""><a class="dj" data-title="任务计划" data-href="/admin/email/index">任务计划</a></li>
                            </ul>
                        </div>
                    </dd>

                    <dd class="">
                        <a class="s_nav_t text-left" data-toggle="collapse" data-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                            <i class="uni app-haoyou z"></i> App管理 <i class="uni app-xia y"></i>
                        </a>
                        <div id="collapse7" class="collapse ">
                            <ul class="card-body">
                                <li class=""><a class="dj" data-title="App管理" data-href="/admin/api/index">App管理</a></li>
                            </ul>
                        </div>
                    </dd>

                </dl>
            </div>
            <div class="menuclose d-lg-none" onclick="closeMenu()"></div>
        </div>
        <div class="ad_right">
            <div class="topbar d-flex justify-content-between">
                <div class="d-flex">
                    <div id="showmenu" class="uni app-px1 d-lg-none"></div>
                    <a href="/" class="portal" target="_blank">网站首页</a>
                </div>
                <div class="d-flex">
                    <div class="dropdown">
                        <a style="display: block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="user_dropdown">
                                <img class="lazy user_avatar" src="{{url('img/avatar.png')}}" data-original="">
                                <span class="user_name wenzi">xxxx</span>
                                <i class="uni app-xia"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="/admin/logout">退出</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a style="display: block" href="#" role="button" data-target=”#dropdownsettingbox” id="dropdownsetting" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="setting">
                                <i class="uni app-xitong"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" id="dropdownsettingbox" aria-labelledby="dropdownsetting">
                            <a class="dropdown-item">test</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iload_box">
                <div class="d-none alert alert-danger" id="error_msg" role="alert"></div>
                <div class="loading" id="loading">
                    <div class="loading-pointer-inner"><div class="pointer"></div> <div class="pointer"></div> <div class="pointer"></div></div>
                </div>
                <div id="iload"></div>
            </div>
        </div>
    </div>
</section>

<form method="post" action="/admin/cache/index" class="userform">
    @csrf
    <div class="modal fade" id="cacheModal" tabindex="-1" aria-labelledby="cacheModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cacheModalLabel">清空缓存</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    确认清空缓存吗
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">确认</button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    function iload(url,data='') {
        $('#loading').css('z-index',100);
        $("#iload").load(url,data,function () {
            $('#loading').css('z-index',-1);
        });
    }
    $(function (){
        iload('/admin/index/index');

        $("#iload").on('submit','.select_form',function (e){
            e.preventDefault()
            e.stopPropagation()
            const form = $(this)
            //console.log(form.serialize())
            let url = form.attr("action");
            iload(url+'?'+form.serialize());
        })

        $("#iload").on('submit','.save_form',function (e){
            e.preventDefault()
            e.stopPropagation()
            const form = $(this)
            if(form[0].checkValidity()===false){
            }else{
                let url = form.attr("action");
                let type = form.attr("method");
                if(url && type){
                    $('.save_form input.form-control').removeClass('is-valid').removeClass('is-invalid');
                    $.ajax({
                        type,url,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(res){
                            $('.save_form input.form-control').addClass('is-valid');
                            if(!res.code) {
                                $("#iload").load(res.data.redirect);
                                alert_msg(res)
                            }else if(res.code===11000){
                                for(var item in res.data){
                                    let str = ''
                                    res.data[item].forEach((elem, index)=>{
                                        str = str+elem+'<br>'
                                    })
                                    let obj = $('.save_form input[name="'+item+'"]');
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
                    console.log('no action')
                }
            }
        })

        $("#iload").on('submit','.del_form',function (e){
            e.preventDefault()
            e.stopPropagation()
            const form = $(this)
            if(form[0].checkValidity()===false){
            }else{
                let url = form.attr("action");
                let type = form.attr("method");
                if(url && type){
                    $('.save_form input.form-control').removeClass('is-valid').removeClass('is-invalid');
                    $.ajax({
                        type,url,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(res){
                            $('.save_form input.form-control').addClass('is-valid');
                            if(!res.code) {
                                alert_msg(res)
                                $("#iload").load(res.data.redirect);
                            }else{
                                alert_msg(res)
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

        $("#iload").on('click','a.ajax_get,a.page-link',function (e){
            e.preventDefault();
            let ajax = $("#iload");
            ajax.html('');
            $('#loading').css('z-index',100);
            let obj = $(this);
            if(obj && obj.data('href')){
                obj.addClass('active');
                ajax.load(obj.data('href'),function(responseTxt,statusTxt,xhr){
                    if(statusTxt=="success"){}
                    $('#loading').css('z-index',-1);
                });
            }else{
                console.log('error');
            }
        });


        $("#s_nav .dj").on('click',function (e){
            e.preventDefault();
            let ajax = $("#iload");
            ajax.html('');
            $('#loading').css('z-index',100);
            $("#s_nav .dj").removeClass('active');
            let obj = $(this);
            if(obj && obj.data('href')){
                obj.addClass('active');
                ajax.load(obj.data('href'),function(responseTxt,statusTxt,xhr){
                    $('title').html(obj.data('title'));
                    if(statusTxt=="success"){}
                    $('#loading').css('z-index',-1);
                    closeMenu();
                });
            }else{
                console.log('error');
            }
        });

        $('.accordion .s_nav_t').on('click', function () {
            let obj = $(this).children().filter(".y");
            if(obj.hasClass('app-xia')){
                obj.removeClass('app-xia').addClass('app-caret-up');
            }else{
                obj.removeClass('app-caret-up').addClass('app-xia');
            }
        });
        $('#showmenu').on('click',function (){
            let obj = $('.ad_left');
            if(obj.hasClass('d-none')){
                obj.removeClass('d-none d-lg-block')
                $(this).removeClass('app-px1').addClass('app-px')
            }else{
                obj.addClass('d-none d-lg-block')
                $(this).removeClass('app-px').addClass('app-px1')
            }
        })
        //$("img.lazy").lazyload({effect : "fadeIn",threshold :50});
    });

    function closeMenu(){
        $('.ad_left').addClass('d-none d-lg-block')
        $('#showmenu').removeClass('app-px').addClass('app-px1')
    }

    var aphly_viewerjs = document.getElementById('aphly_viewerjs');
    if(aphly_viewerjs){
        var aphly_viewer = new Viewer(aphly_viewerjs,{
            url: 'data-original',
            toolbar:false,
            title:false,
            rotatable:false,
            scalable:false,
            keyboard:false,
            filter(image) {
                if(image.className.indexOf("aphly_viewer") != -1){
                    return true;
                }else{
                    return false;
                }
            },
        });
    }
</script>
@include('laravel-admin::common.footer')
