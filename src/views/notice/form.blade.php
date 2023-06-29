
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/notice/edit?id={{$res['info']->id}}" @else action="/admin/notice/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">标题</label>
                <input type="text" name="title" required class="form-control " value="{{$res['info']->title}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group d-none" >
                <label for="">内容</label>
                <textarea name="content" id="content" class="form-control ">{{$res['info']->content}}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group ">
                <label for="">内容</label>
                <div id="editor—wrapper" style="z-index: 10">
                    <div id="editor-toolbar"></div>
                    <div id="editor-container"></div>
                </div>
            </div>

            <div>
                <label for="">公告层级</label>
                <input type="hidden" id="level_id"  name="level_id" class="form-control " value="{{$res['info']['level_id']}}">
                <input type="text" id="level_name" onclick="$('.tree_box').toggle();" readonly class="form-control tree_box_pre" value="{{$res['levelList'][$res['info']['level_id']]['name']??''}}">
                <div class="tree_box">
                    <div class="tree_p">
                        <div id="tree" ></div>
                    </div>
                </div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group" id="status">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">查看数</label>
                <input type="number" name="viewed" class="form-control " value="{{$res['info']->viewed??0}}">
                <div class="invalid-feedback"></div>
            </div>

            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

<script>
    var my_tree = new MyTree({
        root:0,
        list : @json($res['levelList']),
        select:{}
    })
    $(function () {
        function mount(){
            let treeData = my_tree.treeFormat(my_tree.op.list,[{{$res['info']->level_id}}])
            $('#tree').jstree({
                "core": {
                    "themes":{
                        "dots": false,
                        "icons":false
                    },
                    "data": treeData
                },
                "plugins": ["themes"]
            }).on('select_node.jstree', function(el,_data) {
            }).on("changed.jstree", function(el,data) {
                my_tree.op.select = my_tree.getSelectObj(data)
                $('#level_id').val(my_tree.op.select[0].data.id)
                $('#level_name').val(my_tree.op.select[0].text)
                $('.tree_box').hide();
            })
        }

        const { createEditor, createToolbar } = window.wangEditor
        const editorConfig = {
            onChange(editor) {
                $('#content').html(editor.getHtml());
            },
            MENU_CONF: {}
        }
        editorConfig.MENU_CONF['uploadImage'] = {
            server: '/admin/notice/img',
            fieldName: 'noticeImg',
            maxFileSize: {{$res['imgSize']}}*1024*1024,
            maxNumberOfFiles: 10,
            allowedFileTypes: ['image/*'],
            meta: {
                _token: '{{csrf_token()}}'
            },
            metaWithUrl: true,
            withCredentials: false,
            timeout: 5 * 1000,
        }
        const editor = createEditor({
            selector: '#editor-container',
            html: `{!! $res['info']->content !!}`,
            config: editorConfig,
            mode: 'simple',
        })
        const toolbarConfig = {}
        const toolbar = createToolbar({
            editor,
            selector: '#editor-toolbar',
            config: toolbarConfig,
            mode: 'simple',
        })
        mount()
    })

</script>
