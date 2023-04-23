
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .role_id{padding:10px 20px;}
    .role_id li{height: 30px;line-height: 30px;}
    .role_level{color:#999;}
    .role_name{margin-right: 20px;}
    .role_id label{cursor: pointer;}
</style>
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
                            <input id="role_id_{{$val['id']}}" type="checkbox" name="role_id[]"
                                   data-name="{{$val['name']}}"
                                   @if(in_array($val['id'],$res['select_ids'])) checked @endif
                                   value="{{$val['id']}}">
                            <label for="role_id_{{$val['id']}}">
                                <span class="role_name">{{$val['name']}}</span>
                                <span class="role_level">
                                @if(isset($res['role_level'][$val['level_id']]))
                                    {{$res['role_level'][$val['level_id']]['name']}}
                                @endif
                                </span>
                            </label>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div class="role">
                <div class="role_title">主角色</div>
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
                    <div class="d-flex flex-row-reverse">
                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(".role_id input").change(function() {
            let arr = [];
            $(".role_id input:checked").each(function () {
                arr.push({role_id:$(this).val(),'name':$(this).data('name')})
            })
            makeInput(arr)
        });
    })
    function makeInput(arr1) {
        let html = '';
        let select = '';
        for(let i in arr1){
            html += `<input type="hidden" name="role_id[]" value="${arr1[i].role_id}">`
            select +=`<option value="${arr1[i].role_id}">${arr1[i].name}</option>`
        }
        $("#select_ids").html(html);
        $("#level_id").html(select);
    }

</script>
