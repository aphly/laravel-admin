
<div class="top-bar">
    <h5 class="nav-title">角色管理</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/role/index" >
        @csrf
        <div class="itop ">
            <div class="shai "></div>
            <div class=" "><a href="/admin/role/add" class="btn btn-success">新增</a></div>
        </div>
        <ul class="list-group list-group-flush">
            <li class="liheader list-group-item">
                <span>ID</span>
                <span>角色名称</span>
                <span>操作</span>
            </li>
            @foreach($res['data'] as $v)
                <li class="list-group-item">
                    <input type="checkbox" class="form-check-input deletebox" name="delete[]" value="{{$v['id']}}">
                    <span>{{$v['id']}}</span>
                    <span>{{$v['name']}}</span>
                    <span>
                    <a class="badge badge-success" href="/admin/role/{{$v['id']}}/permission">权限</a>
                    <a class="badge badge-info" href="/admin/role/edit/{{$v['id']}}">编辑</a>
                    <a class="badge badge-danger" href="/admin/role/del/{{$v['id']}}">删除</a>
                </span>
                </li>
            @endforeach
        </ul>

        <div class="other">
            <div class="tleft">
                <input type="checkbox" class="form-check-input deleteboxall"  onclick="checkAll(this)">
                <button class="btn btn-danger" type="submit">删除</button>
            </div>
            {{$res['data']->links('common.pagination')}}
        </div>
    </form>

</div>
