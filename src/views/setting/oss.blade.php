
<div class="top-bar cl">
    <h5 class="nav-title">OSS设置</h5>
</div>
<div class="imain">
    <form method="post" action="{{!empty($siteconfig)?'/admin/setting/oss':'/admin/setting/oss?insert=1'}}" class="userform">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">状态</label>
            {!! $common->input_select('oss_status',$res['siteconfig']['oss_status'],$common->dropDown('is_status')) !!}

        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">文件大小</label>
            <input type="text" name="oss_size" class="form-control" value="{{$res['siteconfig']['oss_size']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">未使用个数</label>
            <input type="text" name="oss_unused" class="form-control" value="{{$res['siteconfig']['oss_unused']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">原图上传</label>
            <input type="text" name="oss_zoom" class="form-control" value="{{$res['siteconfig']['oss_zoom']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">图片质量</label>
            <input type="text" name="oss_quality" class="form-control" value="{{$res['siteconfig']['oss_quality']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">图片宽度</label>
            <input type="text" name="oss_width" class="form-control" value="{{$res['siteconfig']['oss_width']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">文件扩展名</label>
            <input type="text" name="oss_ext" class="form-control" value="{{$res['siteconfig']['oss_ext']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">通信协议</label>
            <input type="text" name="oss_http" class="form-control" value="{{$res['siteconfig']['oss_http']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">域名</label>
            <input type="text" name="oss_host" class="form-control" value="{{$res['siteconfig']['oss_host']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Bucket 域名</label>
            <input type="text" name="oss_bucket" class="form-control" value="{{$res['siteconfig']['oss_bucket']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">阿里云 oss AccessKey ID</label>
            <input type="text" name="oss_accesskey_id" class="form-control" value="{{$res['siteconfig']['oss_accesskey_id']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">AccessKeySecret</label>
            <input type="text" name="oss_accesskey_secret" class="form-control" value="{{$res['siteconfig']['oss_accesskey_secret']}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Bucket名称</label>
            <input type="text" name="oss_bucketname" class="form-control" value="{{$res['siteconfig']['oss_bucketname']}}">
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

