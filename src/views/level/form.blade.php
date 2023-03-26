<div class="top-bar">
    <h5 class="nav-title">层级编辑</h5>
</div>

<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/level/save?id={{$res['info']->id}}" @else action="/admin/level/save" @endif class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="form_edit" class="form-control" value="1">
            @if(!empty($res['parent_info']))
            <div class="form-group">
                <label for="">父级</label>
                <input type="text" class="form-control" value="{{$res['parent_info']->name}}" disabled>
            </div>
            @endif
            <div class="form-group">
                <label for="">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control" disabled>
                    @if($res['info']->is_leaf)
                        <option value="1">子级</option>
                    @else
                        <option value="0">目录</option>
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

