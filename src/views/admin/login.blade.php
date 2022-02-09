@include('laravel-admin::common.header')
<link rel="stylesheet" href="{{ URL::asset('css/pc.css') }}">
<section class="">
    <form method="post" action="/admin/login" class="userform">
        @csrf
        <div class="formtitle">
            <h2 class="text-center">后台登录</h2>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">用户名</label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
            @error('username')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">密码</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="">
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        @error('failedlogin')
        <div class="alert alert-warning" role="alert">
            {{ $message }}
        </div>
        @enderror

        <button class="btn btn-primary" type="submit">登录</button>
    </form>
</section>
<script>
$(function (){
    $('#password').change(function (){
        $(this).removeClass('is-invalid');
    });
});
</script>
@include('laravel-admin::common.footer')
