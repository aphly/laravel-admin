<div class="top-bar">
    <h5 class="nav-title">接口编辑
    </h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/api/edit?id={{$res['info']->id}}" @else action="/admin/api/add" @endif  class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="form_edit" value="1">
            <div class="form-group">
                <label for="">模块</label>
                <select name="module_id" class="form-control">
                    @foreach($res['module'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->module_id) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">类型</label>
                <select name="type" id="is_leaf" class="form-control">
                    <option value="1" @if($res['info']['type']==1) @else selected @endif>目录</option>
                    <option value="2" @if($res['info']['type']==2) selected @endif>接口</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" >
                <label for="">标识</label>
                <select name="route" class="form-control" >
                    <option value="" >无</option>
                    @foreach($res['rbacRoutes'] as $key=>$val)
                        <optgroup label="{{$key}}">
                            @foreach($val as $v)
                                <option value="{{$v['url']}}" @if($res['info']->route==$v['url']) selected @endif>{{$v['route']}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
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
                <input type="number" name="sort" class="form-control " value="{{$res['info']['sort']??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
<script>

</script>

