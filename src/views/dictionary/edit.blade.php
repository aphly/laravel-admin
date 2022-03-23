<div class="top-bar">
    <h5 class="nav-title">字典编辑</h5>
</div>
<div class="imain">
    <form method="post" @if($res['pid']) action="/admin/dictionary/{{$res['info']['id']}}/edit?pid={{$res['pid']}}" @else action="/admin/dictionary/{{$res['info']['id']}}/edit" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control" disabled="disabled">
                    <option value="1" @if($res['info']['is_leaf']) selected @endif>字典</option>
                    <option value="0" @if($res['info']['is_leaf']) @else selected @endif>目录</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">图标</label>
                <input type="text" name="icon" class="form-control "  value="{{$res['info']['icon']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
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
            <div class="form-group">
                <div onclick="addDiv()">+</div>
                <div class="add_div">
                    <ul>
                        <li class="d-flex">
                            <div>名称</div>
                            <div>值</div>
                            <div>图标</div>
                            <div>排序</div>
                            <div>操作</div>
                        </li>
                        @foreach($res['info']['json'] as $k=>$v)
                            <li class="d-flex" data-id="{{$k}}">
                                <div><input type="text" name="json[{{$k}}][name]" value="{{$v['name']}}"></div>
                                <div><input type="text" name="json[{{$k}}][value]" value="{{$v['value']}}"></div>
                                <div><input type="text" name="json[{{$k}}][img]" value="{{$v['img']}}"></div>
                                <div><input type="text" name="json[{{$k}}][sort]" value="{{$v['sort']}}"></div>
                                <div onclick="delDiv(this)">x</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
<script>
    function addDiv() {
        let id = randomId(8);
        let html = `<li class="d-flex" data-id="${id}">
                        <div><input type="text" name="json[${id}][name]"></div>
                        <div><input type="text" name="json[${id}][value]"></div>
                        <div><input type="text" name="json[${id}][img]"></div>
                        <div><input type="text" name="json[${id}][sort]"></div>
                        <div onclick="delDiv(this)">x</div>
                    </li>`;
        $('.add_div ul').append(html);
    }
    function delDiv(_this) {
        $(_this).parent().remove()
    }
</script>
