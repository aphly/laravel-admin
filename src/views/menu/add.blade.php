
<div class="top-bar">
    <h5 class="nav-title">菜单新增
        @if($res['pid'])
            <span>- {{$res['parent']['name']}}</span>
        @endif
    </h5>
</div>
<div class="imain">
    <form method="post" @if($res['pid']) action="/admin/menu/add?pid={{$res['pid']}}" @else action="/admin/menu/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control">
                    <option value="1">菜单</option>
                    <option value="0">目录</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="url">
                <label for="">链接地址</label>
                <input type="text" name="url" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">图标 class</label>
                <input type="text" name="icon" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                    <option value="{{$key}}" >{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="text" name="sort" class="form-control " value="0">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

