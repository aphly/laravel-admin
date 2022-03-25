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
function attr_addDiv() {
    let id = randomId(8);
    let html = `<li class="d-flex" data-id="${id}">
                        <div class="attr1"><input type="text" name="json[${id}][name]"></div>
                        <div class="attr2"><input type="text" name="json[${id}][value]"></div>
                        <div class="attr3"><input type="text" name="json[${id}][img]"></div>
                        <div class="attr4"><input type="number" name="json[${id}][sort]"></div>
                        <div class="attr0"><input type="number" name="json[${id}][group]" value="0"></div>
                        <div class="attr5" onclick="attr_delDiv(this)"><i class="uni app-lajitong"></i></div>
                    </li>`;
    $('.add_div ul').append(html);
}
function attr_delDiv(_this) {
    $(_this).parent().remove()
}
