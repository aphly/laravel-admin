<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" id="menu_form" @if($res['info']->id) action="/admin/menu/edit?id={{$res['info']['id']}}" @else action="/admin/menu/add" @endif class="save_form">
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
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">类型</label>
                <select name="type" class="form-control" id="type">
                    @foreach($dict['menu_type'] as $key=>$val)
                        <option value="{{$key}}" @if($res['info']['type']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="route">
            </div>
            <div class="form-group">
                <label for="">icon</label>
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
<script>
    $(function () {
        make_menu_type({{$res['info']['type']}})
        $('#menu_form').on('change','#type',function () {
            make_menu_type($(this).val())
        })
    })
    function make_menu_type(type_val) {
        let html_allRoutes = ''
        @foreach($res['allRoutes'] as $key=>$val)
            html_allRoutes += `<optgroup label="{{$key}}">`
        @foreach($val as $v)
            html_allRoutes += `<option value="{{$v['url']}}" @if($res['info']['route']==$v['url']) selected @endif>{{$v['url']}}</option>`
        @endforeach
            html_allRoutes += `</optgroup>`
        @endforeach
        if(type_val==1){
            $('#route').html(`<label for="">路由路径</label>
                                <input type="text" name="route" class="form-control " value="">
                                <div class="invalid-feedback"></div>`)
        }else if(type_val==2 || type_val==3){
            $('#route').html(`<label for="">路由路径</label>
                                <select name="route" class="form-control" >
                                    <option value="" >无</option>
                                    ${html_allRoutes}
                                </select>
                                <div class="invalid-feedback"></div>`)
        }
    }
</script>
