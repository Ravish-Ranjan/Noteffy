function closeF(){
    document.querySelector('form').remove();
    document.querySelector("#btn1").setAttribute("onclick","compose()");
}
function compose(){  
    let noteform = document.createElement("form");
    noteform.setAttribute("action","main.php");noteform.setAttribute("method","POST");
    noteform.setAttribute("onsubmit","return checkEmpty(this)");
    noteform.innerHTML = "<span id='Form_Caption'>ADD A NOTE</span>\
    <button id = 'close' style=\"font-size:2vw;\" onclick = \"closeF()\">x</button>\
    <label for='Date'>Date</label>\
    <input type='date' value='2023-07-16' name='Date' id='Date'>\
    <label for='Title'>Title</label>\
    <input type='text' name='Title' id='Title' placeholder='Title'>\
    <label for='Note'>Content</label>\
    <textarea style='resize:none;' name='Note' id='Note' rows=10 cols=10></textarea>\
    <input type='submit' value='save' id='btn'>"
    document.querySelector("body").appendChild(noteform);
    document.querySelector("#btn1").toggleAttribute("onclick","");
}
function checkEmpty(ele){
    let childs = ele.children,flag = true;
    for(i of childs){
        if(['INPUT','TEXTAREA'].indexOf(i.nodeName)!=-1 && i.value==''){
            i.style['border'] = "2px solid darkred";
            flag = false;
        }
        else if(['INPUT','TEXTAREA'].indexOf(i.nodeName)!=-1 && i.value!=''){
            i.style['border-color'] = "2px solid darkgreen";
        }
    }
    if(flag){
        document.querySelector("#btn1").toggleAttribute("onclick","compose()");
    }
    return flag;
}