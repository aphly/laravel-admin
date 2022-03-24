
<div class="top-bar">
    <h5 class="nav-title">字典新增
        @if($res['pid'])
            <span>- {{$res['parent']['name']}}</span>
        @endif
    </h5>
</div>
<div class="imain">
    <form method="post" @if($res['pid']) action="/admin/dictionary/add?pid={{$res['pid']}}" @else action="/admin/dictionary/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control">
                    <option value="1">字典</option>
                    <option value="0">目录</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">名称</label>
                <input type="text" name="name" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">图标</label>
                <input type="text" name="icon" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">状态</label>
                <select name="status" class="form-control">
                    <option value="1" >开启</option>
                    <option value="0" >关闭</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">排序</label>
                <input type="text" name="sort" class="form-control " value="0">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <div onclick="attr_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> 添加属性</div>
                <div class="add_div">
                    <ul class="add_div_ul">
                        <li class="d-flex">
                            <div class="attr1">名称</div>
                            <div class="attr2">值</div>
                            <div class="attr3">图标</div>
                            <div class="attr4">排序</div>
                            <div class="attr5">操作</div>
                        </li>
                    </ul>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>

</style>
<script>

</script>

