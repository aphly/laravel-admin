
<div class="top-bar">
    <h5 class="nav-title">模块</h5>
</div>
<div class="imain">
    <form method="post" @if($res['module']->id) action="/admin/module/save?id={{$res['module']->id}}" @else action="/admin/module/save" @endif class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="status" class="form-control " value="{{$res['module']->status??0}}">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['module']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Key</label>
                <input type="text" name="key" class="form-control " value="{{$res['module']->key}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Classname</label>
                <input type="text" name="classname" class="form-control " value="{{$res['module']->classname}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['module']->sort??0}}">
                <div class="invalid-feedback"></div>
            </div>

            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
