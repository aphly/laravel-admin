
<div class="top-bar">
    <h5 class="nav-title">模块</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/module/edit?id={{$res['info']->id}}" @else action="/admin/module/add" @endif class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="status" class="form-control " value="{{$res['info']->status??0}}">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Key</label>
                <input type="text" name="key" class="form-control " value="{{$res['info']->key}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Classname</label>
                <input type="text" name="classname" class="form-control " value="{{$res['info']->classname}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['info']->sort??0}}">
                <div class="invalid-feedback"></div>
            </div>

            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
