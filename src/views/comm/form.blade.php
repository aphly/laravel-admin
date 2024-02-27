
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/comm/edit?id={{$res['info']->id}}" @else action="/admin/comm/add" @endif class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="status" class="form-control " value="{{$res['info']->status??0}}">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Host</label>
                <input type="text" name="host" class="form-control " value="{{$res['info']->host}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">通信密钥</label>
                <input type="text" name="auth_key" class="form-control " value="{{$res['info']->auth_key}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['info']['sort']??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
