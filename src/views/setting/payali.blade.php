

<div class="top-bar cl">
    <h5 class="nav-title">支付宝设置</h5>
</div>
<div class="imain">
    <form method="post" action="{{!empty($siteconfig)?'/admin/setting/payali':'/admin/setting/payali?insert=1'}}" class="userform">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">支付宝状态</label>
            {!! $common->input_select('pay_alipay_status',$res['siteconfig']['pay_alipay_status'],$common->dropDown('is_status')) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">应用appid</label>
            <input type="text" name="pay_alipay_appid" class="form-control" value="{{$res['siteconfig']['pay_alipay_appid']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">支付宝账号ID</label>
            <input type="text" name="pay_alipay_seller_id" class="form-control" value="{{$res['siteconfig']['pay_alipay_seller_id']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">支付宝公钥 (RSA2)</label>
            <input type="text" name="pay_alipay_publickey" class="form-control" value="{{$res['siteconfig']['pay_alipay_publickey']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">应用私钥 (RSA2)</label>
            <input type="text" name="pay_alipay_merchantprivatekey" class="form-control" value="{{$res['siteconfig']['pay_alipay_merchantprivatekey']}}">
        </div>

        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

