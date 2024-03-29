
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/dict/edit?id={{$res['info']->id}}" @else action="/admin/dict/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">key</label>
                <input type="text" name="key" class="form-control " value="{{$res['info']->key}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['info']->sort??0}}">
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
            <div class="form-group filter">
                <div onclick="dict_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> 字典值</div>
                <div class="add_div">
                    <ul class="add_div_ul">
                        <li class="d-flex">
                            <div class="filter1">名称</div>
                            <div class="filter2">值</div>
                            <div class="filter3">排序</div>
                            <div class="filter5">操作</div>
                        </li>
                        @if($res['dictValue'])
                            @foreach($res['dictValue'] as $key=>$val)
                                <li class="d-flex">
                                    <div class="filter1"><input type="text" name="value[{{$val->id}}][name]" value="{{$val->name}}"></div>
                                    <div class="filter2"><input type="text" name="value[{{$val->id}}][value]" value="{{$val->value}}"></div>
                                    <div class="filter3"><input type="number" name="value[{{$val->id}}][sort]" value="{{$val->sort}}"></div>
                                    <div class="filter5" onclick="dict_delDiv(this)"><i class="uni app-lajitong"></i></div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>
    .filter .filter1{width: 20%;margin: 5px 2%;}
    .filter .filter2{width: 30%;margin: 5px 2%;}
    .filter .filter3{width: 10%;margin: 5px 2%;}
    .filter .filter5{display: flex;align-items: center;cursor: pointer;}
    .filter .filter5:hover{color: red;}
</style>
<script>
    function dict_addDiv() {
        let id = randomStr(8);
        let html = `<li class="d-flex" data-id="${id}">
                        <div class="filter1"><input type="text" name="value[${id}][name]"></div>
                        <div class="filter2"><input type="text" name="value[${id}][value]"></div>
                        <div class="filter3"><input type="number" name="value[${id}][sort]" value="0"></div>
                        <div class="filter5" onclick="dict_delDiv(this)"><i class="uni app-lajitong"></i></div>
                    </li>`;
        $('.add_div ul').append(html);
    }
    function dict_delDiv(_this) {
        $(_this).parent().remove()
    }
</script>
