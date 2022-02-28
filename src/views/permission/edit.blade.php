<div class="top-bar">
    <h5 class="nav-title">权限编辑
        @if($res['pid'])
            <span>- {{$res['parent']['name']}}</span>
        @endif
    </h5>
</div>
<div class="imain">
    <form method="post" @if($res['pid']) action="/admin/permission/{{$res['info']['id']}}/edit?pid={{$res['pid']}}" @else action="/admin/permission/{{$res['info']['id']}}/edit" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control" disabled="disabled">
                    <option value="1" @if($res['info']['is_leaf']) selected @endif>权限</option>
                    <option value="0" @if($res['info']['is_leaf']) @else selected @endif>目录</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="controller" @if($res['info']['is_leaf']) @else style="display: none;" @endif>
                <label for="exampleInputEmail1">控制器</label>
                <input type="text" name="controller" class="form-control " placeholder="Aphly\LaravelAdmin\Controllers\IndexController@index" value="{{$res['info']['controller']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="status" @if($res['info']['is_leaf']) @else style="display: none;" @endif>
                <label for="exampleInputEmail1">状态</label>
                <select name="status" class="form-control">
                    <option value="1" @if($res['info']['status']) selected @endif>开启</option>
                    <option value="0" @if($res['info']['status']) @else selected @endif>关闭</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">排序</label>
                <input type="text" name="sort" class="form-control " value="{{$res['info']['sort']}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
<script>
    $('#is_leaf').change(function () {
        if($(this).val()==='1'){
            $('#controller').show();
            $('#status').show();
        }else{
            $('#controller').hide();
            $('#status').hide();
        }
    })
</script>

