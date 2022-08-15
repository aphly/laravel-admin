
<div class="top-bar">
    <h5 class="nav-title">文章</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/news/save?id={{$res['info']->id}}" @else action="/admin/news/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">标题</label>
                <input type="text" name="title" class="form-control " value="{{$res['info']->title}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group d-none" >
                <label for="">内容</label>
                <textarea name="content" id="content" class="form-control ">{{$res['info']->content}}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group ">
                <label for="">内容</label>
                <div class="ckeditor">
                    <div id="toolbar-container"></div>
                    <div id="editor" class="editor">
                        {!! $res['info']->content !!}
                    </div>
                </div>
            </div>

            <div class="form-group" id="status">
                <label for="">状态</label>
                <select name="module_id" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">查看数</label>
                <input type="number" name="view" class="form-control " value="{{$res['info']->view}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

<script>
    $(function () {
        DecoupledEditor.create(document.querySelector( '#editor' ),{
            //toolbar: [ "fontSize","fontFamily","fontColor","fontBackgroundColor","alignment","bold","italic","strikethrough","underline","blockQuote","link","indent","outdent","numberedList","bulletedList","uploadImage","mediaEmbed","insertTable","undo","redo"],
            toolbar: [ "fontSize","fontFamily","fontColor","fontBackgroundColor","alignment","bold","italic","strikethrough","underline","blockQuote","link","indent","outdent","numberedList","bulletedList","insertTable","undo","redo"],
            ckfinder: {uploadUrl: '/'}
        }).then(editor => {
            const toolbarContainer = document.querySelector( '#toolbar-container' );
            toolbarContainer.appendChild( editor.ui.view.toolbar.element );
            editor.model.document.on('change:data', function () {
                $('#content').html(editor.getData());
            });
        }).catch( error => {
            console.log( error );
        });
    })
</script>
