let _res;

function processAjaxData(urlPath,title='',state={}){
    if(title){
        window.document.title = title;
    }
    window.history.pushState(state,title,urlPath);
}

function checkAll(_this) {
    $("input[type='checkbox']").prop("checked", $(_this).prop('checked'));
}

function alert_msg(res,redirect=false,time=2000){
    _res = res
    $('#loading').css('z-index',-1);
    $("#alert_msg").remove();
    let html = '<div id="alert_msg"><div class="alert_msg"><div class="alert_msg_header"><strong class="mr-auto">Tips</strong><small></small><span onclick="$(\'#alert_msg\').remove();">×</span></div><div class="alert_msg_body">'+res.msg+'</div></div></div>';
    let body = $('body');
    body.append(html);
    _autosize($('#alert_msg'))
    setTimeout("after_alert_msg("+redirect+")",time);
}

function after_alert_msg(redirect){
    $("#alert_msg").remove()
    if(redirect){
        if(!_res.code && _res.data.redirect){
            location.href = _res.data.redirect
        }else{
            location.reload()
        }
    }
}

function _autosize(ele){
    if(ele.height() <= $(window).height()) {
        ele.css("top", ($(window).height() - ele.height()) / 2);
    }
    if(ele.width() <= $(window).width()) {
        ele.css("left", ($(window).width() - ele.width()) / 2);
    }
}

var urlOption={
    '_set':function (name,val,jump=false) {
        //str
        let url = ''
        let thisURL = String(document.location);
        let url_arr = thisURL.split('?');
        if(url_arr[1]){
            if(url_arr[1].indexOf(name+'=') !== -1){
                let url_arr_p = url_arr[1].split('&');
                let arr = [];
                url_arr_p.forEach(i=>{
                    if(i.indexOf(name+'=') !== -1){
                        arr.push(name+'='+val)
                    }else{
                        arr.push(i)
                    }
                })
                let url_p = arr.join('&');
                url = url_arr[0]+'?'+url_p;
            }else{
                url = url_arr[0]+'?'+url_arr[1]+'&'+name+'='+val;
            }
        }else{
            url = url_arr[0]+'?'+name+'='+val;
        }
        if(jump){
            location.href = url;
        }else{
            return url;
        }
    },
    // '__set':function (str,jump=false) {
    //     //arr
    //     let res = ''
    //     let thisURL = String(document.location);
    //     let url_arr = thisURL.split('?');
    //     if(url_arr[1]){
    //         let url_arr_p = url_arr[1].split('&');
    //         url_arr_p.push(str);
    //         let arr = [...new Set(url_arr_p)];
    //         let url_p = arr.join('&');
    //         res = url_arr[0]+'?'+url_p;
    //     }else{
    //         res = url_arr[0]+'?'+str;
    //     }
    //     if(jump){
    //         location.href = res;
    //     }else{
    //         return res;
    //     }
    // },
    '_get':function (name) {
        let reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        let r = window.location.search.substr(1).match(reg);
        if(r!=null)return  unescape(r[2]); return null;
    },
    '_del':function (name,jump=false) {
        //str
        let url = ''
        let thisURL = String(document.location);
        let url_arr = thisURL.split('?');
        if(url_arr[1]){
            if(url_arr[1].indexOf(name+'=') !== -1){
                let url_arr_p = url_arr[1].split('&');
                let arr = [];
                url_arr_p.forEach(i=>{
                    if(i.indexOf(name+'=') !== -1){
                    }else{
                        arr.push(i)
                    }
                })
                let url_p = arr.join('&');
                url = url_arr[0]+'?'+url_p;
            }else{
                url = url_arr[0]+'?'+url_arr[1];
            }
        }else{
            url = url_arr[0];
        }
        if(jump){
            location.href = url;
        }else{
            return url;
        }
    // },
    // '__del':function (str,jump=false) {
    //     let res = ''
    //     let thisURL = String(document.location);
    //     let url_arr = thisURL.split('?');
    //     if(url_arr[1]){
    //         let url_arr_p = url_arr[1].split('&');
    //         let arr =  url_arr_p.filter(item=>{
    //             return item!=str
    //         })
    //         let url_p = arr.join('&');
    //         res = url_arr[0]+'?'+url_p;
    //     }
    //     if(jump){
    //         location.href = res;
    //     }else{
    //         return res;
    //     }
    }
}

function toTree(data) {
    let result = []
    if(!Array.isArray(data)) {
        return result
    }
    data.forEach(item => {
        delete item.nodes;
    });
    let map = {};
    data.forEach(item => {
        map[item.id] = item;
    });
    data.forEach(item => {
        let parent = map[item.pid];
        if(parent) {
            (parent.nodes || (parent.nodes = [])).push(item);
        } else {
            result.push(item);
        }
    });
    return result;
}

function treeData(data,select_ids=0) {
    let new_array = []
    data.forEach((item,index) => {
        let selectable = item.is_leaf?true:false;
        if(select_ids){
            let selected=in_array(item.id,select_ids)?true:false;
            new_array.push({id:item.id,text:item.name,pid:item.pid,state:{selected},selectable})
        }else{
            new_array.push({id:item.id,text:item.name,pid:item.pid,selectable})
        }
        delete item.nodes;
    });
    return new_array;
}

function in_array(search,array){
    for(var i in array){
        if(array[i]==search){
            return true;
        }
    }
    return false;
}

function randomId(n,all=false) {
    let str;
    if(all){
        str = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    }else{
        str = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    }
    let res = '';
    for (let i = 0; i < n; i++) {
        let id = Math.ceil(Math.random() * (str.length-1));
        res += str[id];
    }
    return res;
}

window.onload = function() {
    const bowen = document.querySelectorAll(".bowen")
    bowen.forEach(btn => {
        btn.addEventListener('click', function (e) {
            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;

            let ripples = document.createElement('span');
            ripples.style.left = x + 'px';
            ripples.style.top = y + 'px';
            this.appendChild(ripples);
            setTimeout(() => {
                ripples.remove();
            }, 400);
        })
    })
}

let mobileTouch = {
    getDirection(startX, startY, endX, endY) {
        let dy = startY - endY;
        let result = 0;
        if (dy > 0) { //向上滑动
            result = 1;
        } else if (dy < 0) {//向下滑动
            result = 2;
        } else {
            result = 0;
        }
        return result;
    },
    listentouch(callback) {
        let startX, startY;
        document.addEventListener(
            "touchstart",
            function(ev) {
                startX = ev.touches[0].pageX;
                startY = ev.touches[0].pageY;
            },
            false
        );
        let _this = this
        document.addEventListener(
            "touchend",
            function(ev) {
                let endX, endY;
                endX = ev.changedTouches[0].pageX;
                endY = ev.changedTouches[0].pageY;
                let direction = _this.getDirection(startX, startY, endX, endY);
                callback(direction);
            },
            false
        );
    }
}

let _session = {
    set(key,value){
        sessionStorage.setItem(key,JSON.stringify(value));
    },
    get(key){
        let value = sessionStorage.getItem(key);
        return JSON.parse(value);
    }
}

$(function () {
    $("body").on('click','[data-stopPropagation]',function (e) {
        e.stopPropagation();
    });
})
