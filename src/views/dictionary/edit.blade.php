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
                <label for="exampleInputEmail1">值</label>
                <input type="text" name="value" class="form-control "  value="{{$res['info']['value']}}">
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
                <input type="number" name="sort" class="form-control " value="{{$res['info']['sort']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <div onclick="attr_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> 添加属性</div>
                <div class="add_div">
                    <ul class="add_div_ul">
                        <li class="d-flex">
                            <div class="attr1">名称</div>
                            <div class="attr2">值</div>
                            <div class="attr3">图标</div>
                            <div class="attr4">排序</div>
                            <div class="attr0">组</div>
                            <div class="attr8">扩1</div>
                            <div class="attr9">扩2</div>
                            <div class="attr5">操作</div>
                        </li>
                        @if($res['info']['json'])
                        @foreach($res['info']['json'] as $k=>$v)
                            <li class="d-flex" data-id="{{$k}}">
                                <div class="attr1"><input type="text" name="json[{{$k}}][name]" value="{{$v['name']}}"></div>
                                <div class="attr2"><input type="text" name="json[{{$k}}][value]" value="{{$v['value']}}"></div>
                                <div class="attr3"><input type="text" name="json[{{$k}}][img]" value="{{$v['img']}}"></div>
                                <div class="attr4"><input type="number" name="json[{{$k}}][sort]" value="{{$v['sort']}}"></div>
                                <div class="attr0"><input type="number" name="json[{{$k}}][group]" value="{{$v['group']}}"></div>
                                <div class="attr8"><input type="text" name="json[{{$k}}][ext1]" value="{{$v['ext1']}}"></div>
                                <div class="attr9"><input type="text" name="json[{{$k}}][ext2]" value="{{$v['ext2']}}"></div>
                                <div class="attr5" >
                                    <i class="uni app-lajitong" onclick="attr_delDiv(this)"></i>
                                    {{$k}}
                                </div>
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

