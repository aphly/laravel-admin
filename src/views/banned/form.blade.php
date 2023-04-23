
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/banned/edit?id={{$res['info']->id}}" @else action="/admin/banned/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">IP</label>
                <input type="text" name="ip" class="form-control " value="{{$res['info']->ip}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['user_status'] as $key=>$val)
                        <option value="{{$key}}" @if($res['info']->status==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
