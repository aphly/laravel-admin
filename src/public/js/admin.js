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
