
<div class="top-bar">
    <h5 class="nav-title">角色</h5>
</div>
<div class="imain">
    <div class="userinfo">
        用户名：{{$res['info']->username}}
    </div>
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">角色列表</div>
                <div >
                    <ul class="role_id">
                    @foreach($res['roleList'] as $val)
                        <li>
                            <input type="checkbox" name="role_id[]"
                                   @if(in_array($val['id'],$res['select_ids'])) checked @endif
                                   value="{{$val['id']}}">
                            {{$val['name']}}
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div>
                <div class="role_title">主责</div>
                <form method="post" action="/admin/manager/role?uuid={{$res['info']->uuid}}" class="save_form">
                    @csrf
                    <div class=" select_ids" id="select_ids"></div>
                    <div style="margin-bottom: 20px;">
                        <select name="main_role_id" id="level_id" class="form-control">
                            @foreach($res['manager_role'] as $val)
                                <option value="{{$val['role']['id']}}"
                                        @if($res['info']->level_id==$val['role']['level_id']) selected @endif
                                >{{$val['role']['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit">保存</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

    })
    function makeInput(arr1) {
        let html = '';
        let select = '';
        for(let i in arr1){
            html += `<input type="hidden" name="role_id[]" value="${arr1[i]}">`
            select +=`<option value="${arr1[i]}"></option>`
        }
        $("#select_ids").html(html);
        $("#level_id").html(select);
    }

</script>
