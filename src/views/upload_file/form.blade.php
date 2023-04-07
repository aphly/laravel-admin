
<div class="top-bar">
    <h5 class="nav-title">文件编辑</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/upload_file/edit?id={{$res['info']->id}}" @else action="/admin/upload_file/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">UUID</label>
                <input type="text" name="uuid" class="form-control " value="{{$res['info']->uuid}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">level_id</label>
                <input type="text" name="level_id" class="form-control " value="{{$res['info']->level_id}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">path</label>
                <input type="text" name="path" class="form-control " value="{{$res['info']->path}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
