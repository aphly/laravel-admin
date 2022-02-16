<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/manager/index" class="select_form">
        @csrf
        <div class="shai ">
            <input type="search" name="search" value="">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class=""><a data-href="/admin/manager/add" class="badge badge-info">新增</a></div>
    </div>

    <form method="post" action="/admin/manager/del" class="del_form">
    @csrf
    <div class="table_scroll" >
         <table class="table table-borderless text-nowrap " >
             <thead>
                 <tr>
                     <th style="width: 100px">ID</th>
                     <th style="width: 100px">用户名</th>
                     <th style="width: 100px">头像</th>
                     <th style="width: 100px">手机号</th>
                     <th style="width: 100px">状态</th>
                     <th style="width: 200px">操作</th>
                 </tr>
             </thead>
             <tbody>
             @foreach($res['data'] as $v)
             <tr>
                 <td><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</td>
                 <td>{{$v['username']}}</td>
                 <td><img src="{{$v['avatar']}}" class="avatar"></td>
                 <td>{{$v['phone']}}</td>
                 <td>{{$v['status']}}</td>
                 <td>
                     <a class="badge badge-success get" data-href="/admin/manager/{{$v['id']}}/role">授权</a>
                     <a class="badge badge-info get" data-href="/admin/manager/{{$v['id']}}/edit">编辑</a>
                     <a class="badge badge-info get" data-href="/admin/manager/{{$v['id']}}/avatar">头像</a>
                 </td>
             </tr>
             @endforeach
             </tbody>
             <tr>
                 <td colspan="3">
                     <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                     <button class="badge badge-danger" type="submit">删除</button>
                 </td>
                 <td colspan="3">{{$res['data']->links('laravel-admin::common.pagination')}}</td>
             </tr>
         </table>
    </div>
    </form>
</div>

