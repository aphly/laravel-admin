
<div class="top-bar cl">
    <h5 class="nav-title">微信登录</h5>
</div>
<div class="imain">
    <form method="post" action="{{!empty($siteconfig)?'/admin/setting/wechat':'/admin/setting/wechat?insert=1'}}" class="userform">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">公众号appid</label>
            <input type="text" name="mp_appid" class="form-control" value="{{$res['siteconfig']['mp_appid']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">公众号appkey</label>
            <input type="text" name="mp_appkey" class="form-control" value="{{$res['siteconfig']['mp_appkey']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">回调地址</label>
            <input type="text" name="redirect" class="form-control" value="{{$res['siteconfig']['redirect']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">开放appid</label>
            <input type="text" name="dev_appid" class="form-control" value="{{$res['siteconfig']['dev_appid']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">开放appkey</label>
            <input type="text" name="dev_appkey" class="form-control" value="{{$res['siteconfig']['dev_appkey']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">小程序appid</label>
            <input type="text" name="min_appid" class="form-control" value="{{$res['siteconfig']['min_appid']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">小程序appkey</label>
            <input type="text" name="min_appkey" class="form-control" value="{{$res['siteconfig']['min_appkey']}}">
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

