@include('laravel::admin.header')

<div class=" container">
    <div class="d-flex justify-content-center" style="margin-top: 20%;">
        <div style="font-size: 20px;">
            @if($res['roleData']->count())
                <ul>
                @foreach($res['roleData'] as $val)
                    <li><a href="/admin/choose_role?role_id={{$val->role_id}}">{{$val->name}}</a></li>
                @endforeach
                </ul>
            @else
                请联系管理员
            @endif
        </div>
    </div>
</div>

@include('laravel::admin.footer')
