<style>
    .opalert{position:fixed;left:0;top:10%;width:100%}
    .opalert .alert{width:200px;text-align:center;margin:0 auto}
</style>

@if (session('status')=='success')
    <div class="opalert none">
        <div class="alert badge-success" role="alert">
            <p class="mb-0"><i class="bi bi-check2-circle"></i> 操作成功</p>
        </div>
    </div>
@elseif (session('status')=='fail')
    <div class="opalert none">
        <div class="alert badge-danger" role="alert">
            <p class="mb-0"><i class="bi bi-check2-circle"></i> 操作失败</p>
        </div>
    </div>
@endif
<script>
$(function (){
    var opalert=$('.opalert');
    if(opalert){
        opalert.show();
        setTimeout(function (){opalert.hide();},1000);
    }
});
</script>
<script src="{{ URL::asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
