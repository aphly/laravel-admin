

<div class="top-bar cl">
    <h5 class="nav-title">短信设置</h5>
</div>
<div class="imain">
    <form method="post" action="{{!empty($siteconfig)?'/admin/setting/sms':'/admin/setting/sms?insert=1'}}" class="userform">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">阿里云accessKeyId</label>
            <input type="text" name="sms_ali_id" class="form-control" value="{{$res['siteconfig']['sms_ali_id']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">阿里云accessKeySecret</label>
            <input type="text" name="sms_ali_key" class="form-control" value="{{$res['siteconfig']['sms_ali_key']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">短信签名</label>
            <input type="text" name="sms_ali_sign" class="form-control" value="{{$res['siteconfig']['sms_ali_sign']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">模版CODE</label>
            <input type="text" name="sms_ali_tcode" class="form-control" value="{{$res['siteconfig']['sms_ali_tcode']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">每天同手机号最大短信数</label>
            <input type="text" name="sms_ali_mnum" class="form-control" value="{{$res['siteconfig']['sms_ali_mnum']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">每天同ip最大手机数</label>
            <input type="text" name="sms_ali_ipsms" class="form-control" value="{{$res['siteconfig']['sms_ali_ipsms']}}">
        </div>

        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

