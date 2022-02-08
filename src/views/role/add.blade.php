
<div class="top-bar">
    <h5 class="nav-title">角色新增</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/role/add" class="userform">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">角色名称</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

