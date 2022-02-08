
<div class="top-bar cl">
    <h5 class="nav-title">微信支付设置</h5>
</div>
<div class="imain">
    <form method="post" action="{{!empty($siteconfig)?'/admin/setting/paywechat':'/admin/setting/paywechat?insert=1'}}" class="userform">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">微信支付状态</label>
            {!! $common->input_select('pay_wechat_status',$res['siteconfig']['pay_wechat_status'],$common->dropDown('is_status')) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">公众号appid</label>
            <input type="text" name="pay_wechat_appid" class="form-control" value="{{$res['siteconfig']['pay_wechat_appid']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">公众号appkey</label>
            <input type="text" name="pay_wechat_appsecret" class="form-control" value="{{$res['siteconfig']['pay_wechat_appsecret']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">商户号</label>
            <input type="text" name="pay_wechat_mchid" class="form-control" value="{{$res['siteconfig']['pay_wechat_mchid']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">商户私钥</label>
            <input type="text" name="pay_wechat_privateKey" class="form-control" value="{{$res['siteconfig']['pay_wechat_privateKey']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">证书序列号</label>
            <input type="text" name="pay_wechat_certNo" class="form-control" value="{{$res['siteconfig']['pay_wechat_certNo']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">APIv3密钥</label>
            <input type="text" name="pay_wechat_key" class="form-control" value="{{$res['siteconfig']['pay_wechat_key']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">小程序appid</label>
            <input type="text" name="pay_wechat_min_appid" class="form-control" value="{{$res['siteconfig']['pay_wechat_min_appid']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">小程序appkey</label>
            <input type="text" name="pay_wechat_min_appsecret" class="form-control" value="{{$res['siteconfig']['pay_wechat_min_appsecret']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">移动端appid (APP)</label>
            <input type="text" name="pay_wechat_app_appid" class="form-control" value="{{$res['siteconfig']['pay_wechat_app_appid']}}">
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

