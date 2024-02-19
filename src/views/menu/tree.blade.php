
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>

<div class="imain">
    <div class="tree_div max_width">
        <div class="min_width d-flex justify-content-between">
            <div class="show_all">
                <div class="show_title">菜单列表</div>
                <div id="tree" class="treeview"></div>
            </div>
            <div class="show_op" >
                <div id="tree_btn"></div>
                <div id="tree_form" style="display: none;">
                    <form method="post" >
                        @csrf
                        <input type="hidden" name="pid" class="form-control" value="0" >
                        <div class="">
                            <div class="form-group module_div">
                                <label for="">模块</label>
                                <select name="module_id" class="form-control">
                                    <option value="0">-</option>
                                    @foreach($res['module'] as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">名称</label>
                                <input type="text" name="name" class="form-control " value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">类型</label>
                                <select name="type" class="form-control" id="type">
                                    @foreach($dict['menu_type'] as $key=>$val)
                                        <option value="{{$key}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group" id="route"></div>
                            <div class="form-group">
                                <label for="">icon</label>
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
                                <input type="number" name="sort" class="form-control " value="0">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-primary submit" >保存</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var my_tree = new MyTree({
        root:0,
        tree_form : '#tree_form',
        list : @json($res['list']),
        select:{},
        type:'add',
        tree_save_url:'/admin/menu',
        tree_del_url:'/admin/menu/del',
        tree_del_url_return:'/admin/menu/tree',
        _token:'{{csrf_token()}}'
    })
    $(function () {
        function mount() {
            my_tree.tree_btn()
            let treeData = my_tree.treeFormat(my_tree.op.list)
            $('#tree').jstree({
                "core": {
                    "themes": {
                        "dots": false,
                        "icons": false
                    },
                    "data": treeData
                },
                "checkbox": {
                    "keep_selected_style": false
                },
                "state": {
                    "opened":true,
                },
                "plugins": ["themes","state"]
            }).on('select_node.jstree', function (el, _data) {
            }).on("changed.jstree", function (el, data) {
                my_tree.op.select = my_tree.getSelectObj(data)
                my_tree.tree_btn()
            })
        }
        mount()
        $('#tree_btn').on('click','.tree_del',function () {
            my_tree.tree_del($(this).data('id'))
        })
        $('#tree_btn').on('click','.tree_add',function () {
            make_menu_type(1)
            my_tree.tree_form_add($(this).data('pid'))
        })
        $('#tree_btn').on('click','.tree_edit',function () {
            let id = $(this).data('id');
            make_menu_type(my_tree.op.list[id]['type'])
            my_tree.tree_form_edit(id)
        })
        $('#tree_form').on('change','#type',function () {
            make_menu_type($(this).val())
        })
        $('#tree_form').on('click','.submit',function () {
            my_tree.tree_save()
        })
    })
    function make_menu_type(val) {
        let html_allRoutes = ''
        @foreach($res['allRoutes'] as $key=>$val)
            html_allRoutes += `<optgroup label="{{$key}}">`
        @foreach($val as $v)
            html_allRoutes += `<option value="{{$v['url']}}" >{{$v['url']}}</option>`
        @endforeach
            html_allRoutes += `</optgroup>`
        @endforeach
        if(val==1){
            $('#route').html(`<label for="">路由路径</label>
                                <input type="text" name="route" class="form-control " value="">
                                <div class="invalid-feedback"></div>`)
        }else if(val==2 || val==3){
            $('#route').html(`<label for="">路由路径</label>
                                <select name="route" class="form-control" >
                                    <option value="" >无</option>
                                    ${html_allRoutes}
                                </select>
                                <div class="invalid-feedback"></div>`)
        }
    }
</script>
