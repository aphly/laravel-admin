
<div class="top-bar">
    <h5 class="nav-title">配置</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/config/edit?id={{$res['info']->id}}" @else action="/admin/config/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Type</label>
                <input type="text" name="type" class="form-control " value="{{$res['info']->type}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Key</label>
                <input type="text" name="key" class="form-control " value="{{$res['info']->key}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">Value</label>
                <textarea name="value" rows="10" class="form-control ">{{$res['info']->value}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="status">
                <label for="">模块</label>
                <select name="module_id" class="form-control">
                    @foreach($res['module'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->module_id) selected @endif>{{$val}}</option>
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
