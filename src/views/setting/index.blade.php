
<div class="top-bar cl">
    <h5 class="nav-title">网站设置</h5>
</div>
<div class="imain">
    <form method="post" action="{{!empty($siteconfig)?'/admin/setting/index':'/admin/setting/index?insert=1'}}" class="userform">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">网站名称</label>
            <input type="text" name="sitename" class="form-control" value="{{$res['siteconfig']['sitename']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">网站域名</label>
            <input type="text" name="siteurl" class="form-control" value="{{$res['siteconfig']['siteurl']}}">
        </div>

        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

