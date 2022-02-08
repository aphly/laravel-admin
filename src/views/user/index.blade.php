<style>

</style>
<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<div class="imain">
     <form method="post" action="/admin/user/index" >
        @csrf
        <div class="itop clearfix">
            <div class="shai "></div>
            <div class="float-right"><a data-href="/admin/user/add" class="badge badge-info">新增  </a></div>
        </div>
         <div class="table_scroll" >
             <table class="table table-borderless text-nowrap " >
                 <thead>
                     <tr>
                         <th scope="col">ID</th>
                         <th scope="col">用户名</th>
                         <th scope="col">头像</th>
                         <th scope="col">手机号</th>
                         <th scope="col">状态</th>
                         <th scope="col">操作</th>
                     </tr>
                 </thead>
                 <tbody>
                 @foreach($res['data'] as $v)
                 <tr>
                     <td><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</td>
                     <td>{{$v['username']}}</td>
{{--                     <td><img src="{{$common->filePath($v['avatar'])}}" class="avatar"></td>--}}
                     <td>{{$v['phone']}}</td>
                     <td>{{$v['status']}}</td>
                     <td>
                         <a class="badge badge-success" data-href="/admin/user/{{$v['id']}}/role">授权</a>
                         <a class="badge badge-info" data-href="/admin/user/edit/{{$v['id']}}">编辑</a>
                         <a class="badge badge-info" data-href="/admin/user/{{$v['id']}}/avatar">头像</a>
                         <a class="badge badge-danger" data-href="/admin/user/del/{{$v['id']}}">删除</a>
                     </td>
                 </tr>
                 @endforeach
                 </tbody>
                 <tr>
                     <td colspan="0"><input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                         <button class="badge badge-danger" type="submit">删除</button></td>
                 </tr>
                 <tr>
                     <td colspan="0">{{$res['data']->links('common.pagination')}}</td>
                 </tr>

             </table>
         </div>
    </form>

</div>

