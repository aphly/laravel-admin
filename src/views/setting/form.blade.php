
<div class="top-bar">
    <h5 class="nav-title">字典</h5>
</div>
<div class="imain">
    <form method="post" @if($res['setting']->id) action="/admin/setting/save?id={{$res['setting']->id}}" @else action="/admin/setting/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['setting']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Code</label>
                <input type="text" name="code" class="form-control " value="{{$res['setting']->code}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Key</label>
                <input type="text" name="key" class="form-control " value="{{$res['setting']->key}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Value</label>
                <textarea name="value" rows="10" class="form-control ">{{$res['setting']->value}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="status">
                <label for="">Value是否json</label>
                <select name="is_json" class="form-control">
                    @foreach($dict['yes_no'] as $key=>$val)
                        <option value="{{$key}}" @if($key==($res['setting']->is_json??2)) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="status">
                <label for="">模块</label>
                <select name="module_id" class="form-control">
                    @foreach($res['module'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['setting']->module_id) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

<script>

</script>
