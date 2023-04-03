
<div class="top-bar">
    <h5 class="nav-title">角色编辑</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/role/edit?id={{$res['info']['id']}}" @else action="/admin/role/add" @endif class="save_form">
        @csrf
        <input type="hidden" name="form_edit" value="1">
        <div class="">
            <div class="form-group" >
                <label for="">模块</label>
                <select name="module_id" class="form-control" >
                    @foreach($res['module'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->module_id) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">描述</label>
                <input type="text" name="desc" class="form-control " value="{{$res['info']['desc']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" >
                <label for="">数据权限</label>
                <select name="data_perm" class="form-control">
                    @foreach($dict['data_perm'] as $key=>$val)
                        <option value="{{$key}}" @if($res['info']['data_perm']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" >
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($res['info']['status']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
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
