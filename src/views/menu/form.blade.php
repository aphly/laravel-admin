<div class="top-bar">
    <h5 class="nav-title">菜单编辑</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/menu/edit?id={{$res['info']['id']}}" @else action="/admin/menu/edit" @endif class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="form_edit" value="1">
            <div class="form-group">
                <label for="">模块</label>
                <select name="module_id" class="form-control" disabled="disabled">
                    @foreach($res['module'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->module_id) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control" disabled="disabled">
                    <option value="1" @if($res['info']['is_leaf']) selected @endif>菜单</option>
                    <option value="0" @if($res['info']['is_leaf']) @else selected @endif>目录</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">链接地址</label>
                <select name="url" class="form-control" >
                    <option value="" >无</option>
                    @foreach($res['rbacRoutes'] as $key=>$val)
                        <optgroup label="{{$key}}">
                            @foreach($val as $v)
                            <option value="{{$v['uri']}}" @if($res['info']->url==$v['uri']) selected @endif>{{$v['uri']}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">图标 class</label>
                <input type="text" name="icon" class="form-control " value="{{$res['info']['icon']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
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
                <input type="text" name="sort" class="form-control " value="{{$res['info']['sort']}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

