function closeF(){
    document.querySelector('form').remove();
    document.querySelector("#btn1").setAttribute("onclick","compose()");
}
function compose(){  
    console.log(123);
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); 
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    let noteform = document.createElement("form");
    noteform.setAttribute("action","main.php");noteform.setAttribute("method","POST");
    noteform.setAttribute("onsubmit","return checkEmpty(this)");
    noteform.innerHTML = "<span id='Form_Caption'>ADD A NOTE</span>\
    <button id = 'close' style=\"font-size:2vw;\" onclick = \"closeF()\">x</button>\
    <label for='Date'>Date</label>\
    <input type='date' name='Date' id='Date'>\
    <label for='Title'>Title</label>\
    <input type='text' name='Title' id='Title' placeholder='Title'>\
    <label for='Note'>Content</label>\
    <textarea style='resize:none;' placeholder='Your Note' name='Note' id='Note' rows=8 cols=10></textarea>\
    <input type='submit' value='save' id='btn'>"
    document.querySelector("body").appendChild(noteform);
    document.querySelector("#btn1").toggleAttribute("onclick","");
    document.getElementById("Date").value = today;
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