function toMyTree(data,id=0) {
    let new_array = []
    data.forEach((item,index) => {
        if(item.id===id){
            new_array.push({id:item.id,text:item.name,pid:item.pid,state:{selected:true}})
        }else{
            new_array.push({id:item.id,text:item.name,pid:item.pid})
        }
        delete item.nodes;
    });
    return new_array;
}
function selectData(data,select_ids=false) {
    let new_array = []
    data.forEach((item,index) => {
        let color = item.status?'inherit':'#ddd';
        if(select_ids){
            let selected=in_array(item.id,select_ids)?true:false;
            new_array.push({id:item.id,text:item.name,pid:item.pid,state:{selected},color})
        }else{
            new_array.push({id:item.id,text:item.name,pid:item.pid,color})
        }
        delete item.nodes;
    });
    return new_array;
}

//fast_show_start
function fast_show_btn($role=false) {
    $(fast_form).hide();
    if(id){
        if(listById[id].is_leaf){
            if($role){
                $('#show_btn').html(`<div class="d-flex fast_form_btn justify-content-between">
                                        <div class="d-flex">
                                            <span onclick="fast_show_make_form('edit')">编辑</span>
                                            <a class="badge badge-success ajax_get" data-href="/admin/role/${id}/permission">授权</a>
                                            <a class="badge badge-success ajax_get" data-href="/admin/role/${id}/menu">菜单</a>
                                        </div> <div class="fast_del" onclick="fast_del()">删除</div>
                                    </div>`)
            }else{
                $('#show_btn').html(`<div class="d-flex fast_form_btn justify-content-between"><div class="d-flex"><span onclick="fast_show_make_form('edit')">编辑</span></div> <div class="fast_del" onclick="fast_del()">删除</div></div>`)
            }
        }else{
            $('#show_btn').html(`<div class="d-flex fast_form_btn justify-content-between"><div class="d-flex"><span onclick="fast_show_make_form('add')">新增</span> <span onclick="fast_show_make_form('edit')">编辑</span></div> <div class="fast_del" onclick="fast_del()">删除</div></div>`)
        }
    }else{
        $('#show_btn').html(`<div class="d-flex fast_form_btn"><span onclick="fast_show_make_form('add')">新增</span></div>`)
    }
}
function fast_show_make_form(type) {
    $(fast_form).show();
    $(fast_form+' .module_id').hide()
    for (let i in hide_id) {
        $(hide_id[i]).show();
    }
    if(type==='add'){
        $(fast_form+' select[name="is_leaf"]').removeAttr("disabled");
        if(id){
            for(let i in listById[id]) {
                $(fast_form + ' input[name="' + i + '"]').val('');
                $(fast_form + ' select[name="' + i + '"]').val(1);
                $(fast_form + ' textarea[name="' + i + '"]').val('');
            }
            $(fast_form+' input[name="pid"]').val(listById[id]['id']);
            //$(fast_form+' .p_name').val(listById[id]['name']);
        }else{
            $(fast_form+' form')[0].reset();
            $(fast_form+' input[name="pid"]').val(0);
            $(fast_form+' .module_id').show()
            $(fast_form+' .module_id select').removeAttr("disabled");
        }
    }else{
        $(fast_form+' select[name="is_leaf"]').attr("disabled","disabled");
        if(id){
            for(let i in listById[id]){
                $(fast_form+' input[name="'+i+'"]').val(listById[id][i]);
                $(fast_form+' select[name="'+i+'"]').val(listById[id][i]);
                $(fast_form+' textarea[name="'+i+'"]').val(listById[id][i]);
                // if(i=='pid'){
                //     let pid = listById[id][i];
                //     $(fast_form+' .p_name').val(listById[pid]['name']);
                // }
            }
            if(!listById[id]['pid']){
                $(fast_form+' .module_id').show()
                $(fast_form+' .module_id select').attr("disabled","disabled");
            }
            if(!listById[id]['is_leaf']) {
                for (let i in hide_id) {
                    $(hide_id[i]).hide();
                }
            }
        }
    }
}
function fast_save() {
    let url = fast_save_url+'?id='+id
    let btn_html = $(fast_form+' button[type="submit"]').html();
    $.ajax({
        url,
        dataType:'json',
        type:'post',
        data:$(fast_form+' form').serialize(),
        beforeSend:function () {
            $(fast_form+' button[type="submit"]').attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
        },
        success:function (res) {
            if(!res.code) {
                alert_msg(res)
                $("#iload").load(res.data.redirect);
            }else if(res.code===11000){
                form_err_11000(res,fast_form);
            }else{
                alert_msg(res)
            }
        },
        complete:function(XMLHttpRequest,textStatus){
            $(fast_form+' button[type="submit"]').removeAttr('disabled').html(btn_html);
        }
    })
}

function fast_del() {
    if(confirm('确认删除吗') && id){
        $.ajax({
            url:fast_del_url,
            dataType:'json',
            type:'post',
            data:{'delete[]':id,_token},
            success:function (res) {
                alert_msg(res)
                if(!res.code) {
                    $("#iload").load(fast_del_url_return);
                }
            }
        })
    }
}
//fast_show_end

function attr_addDiv() {
    let id = randomId(8);
    let html = `<li class="d-flex" data-id="${id}">
                        <div class="attr1"><input type="text" name="json[${id}][name]"></div>
                        <div class="attr2"><input type="text" name="json[${id}][value]"></div>
                        <div class="attr3"><input type="text" name="json[${id}][img]"></div>
                        <div class="attr4"><input type="number" name="json[${id}][sort]"></div>
                        <div class="attr5" onclick="attr_delDiv(this)"><i class="uni app-lajitong"></i></div>
                    </li>`;
    $('.add_div ul').append(html);
}
function attr_delDiv(_this) {
    $(_this).parent().remove()
}
