
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/failed_login/edit?id={{$res['info']->id}}" @else action="/admin/failed_login/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">IP</label>
                <input type="text" name="ip" class="form-control " value="{{$res['info']->ip}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">input</label>
                <textarea name="input" class="form-control ">{{$res['info']->input}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
