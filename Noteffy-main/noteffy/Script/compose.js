function closeF(){
    document.querySelector('form').remove();
    document.querySelector("#btn1").setAttribute("onclick","compose()");
}
function note_compose(){  //this function helps to create more notes for user
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
function task_compose(){  //this function helps to create more tasks for user
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); 
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;

    var t = new Date();
    time = String(t.getHours())+":"+String(t.getMinutes()); //current time
    let noteform = document.createElement("form");
    noteform.setAttribute("action","main.php");noteform.setAttribute("method","POST");
    noteform.setAttribute("onsubmit","return checkEmpty(this)");
    noteform.innerHTML = "<span id='Form_Caption'>ADD A NOTE</span>\
    <button id = 'close' style=\"font-size:2vw;\" onclick = \"closeF()\">x</button>\
    <label for='Date'>Date</label>\
    <input type='date' name='T_Date' id='Date'>\
    <label for='Time'>Time</label>\
    <input type='time' name='T_Time' id='Time'>\
    <label for='Title'>Title</label>\
    <input type='text' name='T_Title' id='Title' placeholder='Title'>\
    <label for='Task'>Tasks</label>\
    <textarea style='resize:none;' placeholder='Your Tasks' name='Task' id='Task'  contenteditable='true' rows=8 cols=10>1.)</textarea>\
    <input type='submit' value='save' id='btn'>"
    document.querySelector("body").appendChild(noteform);
    document.querySelector("#btn1").toggleAttribute("onclick","");
    document.getElementById("Date").value = today;
    document.getElementById("Time").value = time;
    var task =document.getElementById("Task");
    task.addEventListener("keyup",(e)=>{
        if(e.key==="Enter"){
            task.value+=String(task.value.split("\n").length)+".)";
        }
    })
}
function checkEmpty(ele){ // this function checks if the user have any note/tasks or not
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