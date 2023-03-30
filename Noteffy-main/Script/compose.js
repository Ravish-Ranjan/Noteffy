function closeF(x){
    if(x==1){    
        document.querySelector('.FORM').remove();
    }
    else if(x==2){    
        document.querySelector('.FORM2').remove();
    }
        document.querySelector("#btn1").setAttribute("onclick","compose()");
}
function note_compose(date, title, note, note_no) {  //this function helps to create more notes for user
    if (document.getElementsByClassName("FORM").length != 0) {
        document.getElementsByClassName("FORM")[0].remove();
        return;
    }
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); 
    var yyyy = today.getFullYear();
    let action = "main.php";
    if (note_no.length != 0)
        action += "?note_no=" + note_no;
    if (date.length == 0)
        today = yyyy + '-' + mm + '-' + dd;
    else
        today = date;
    let noteform = document.createElement("form");
    noteform.setAttribute("action", action); noteform.setAttribute("method", "POST");
    noteform.setAttribute("class", "FORM");
    noteform.setAttribute("onsubmit", "return checkEmpty(this)");
    noteform.innerHTML = `<span id='Form_Caption'>New Note</span>\
    <button id = 'close' onclick = \"closeF()\"><img src='../media/cancelicon.png' id='cancel-icon-img'></button>\
    <input type='date' name='Date' id='Date'>\
    <input type='text' name='Title' id='Title' placeholder='Title' value=${title}>\
    <textarea style='resize:none;' placeholder='What is in my mind?' name='Note' id='Note' rows=8 cols=7 >${note}</textarea>\
    <center><input type='submit' value='Save' id='btn'></center>`
    document.querySelector("body").appendChild(noteform);
    document.querySelector("#btn1").toggleAttribute("onclick", "");
    document.getElementById("Date").value = today;
}
async function task_compose(date, tm, title, tk, task_no,flag = 0,ele = null) {  //this function helps to create more tasks for user
    if (document.getElementsByClassName("FORM").length != 0) {
        document.getElementsByClassName("FORM")[0].remove();
        return;
    }
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); 
    var yyyy = today.getFullYear();
    let classname = ele.parentElement.querySelector("h2").innerHTML;
    let action = "main.php"+((flag==1)?encodeURI(`?admin=true&class=${classname}`):"");

    if (task_no.length != 0)
        action += "?task_no=" + task_no;
    if (tk.length == 0)
        tk += "1.)";
    if (date.length == 0)
        today = yyyy + '-' + mm + '-' + dd;
    else
        today = date;
    
    var params = {
        'op':'getmembers',
        'class':classname
    }
    var options = {
        method:"GET",
        mode:"cors"
    }
    let list;
    if(flag == 1){
        let resp = await fetch("../php/admin.php?"+ (new URLSearchParams(params).toString()),options);
        let userjs = await resp.json();
        list = `<select name="assignedmems[]" id="assmem" multiple>`;
        for(let u = 0;u < userjs.list.length;u++){
            list+=`<option name = "res" value = "${Object.keys(userjs.list[u])}">${Object.values(userjs.list[u])}</option>`
        }
        list+=`</select>`;
    }
    var t = new Date();
    if (tm.length == 0)
        time = String(t.getHours()) + ":" + String(t.getMinutes()); //current time
    else
        time = tm;
    let noteform = document.createElement("form");
    noteform.setAttribute("class", "FORM");noteform.setAttribute("enctype","multipart/form-data");
    noteform.setAttribute("action",action);noteform.setAttribute("method","POST");
    if(flag==1){noteform.setAttribute("ad","true");}
    noteform.setAttribute("onsubmit","return checkEmpty(this)");
    noteform.innerHTML = `<span id='Form_Caption'>New Task</span>\
    <button id = 'close' style=\"font-size:2vw;\" onclick = \"closeF()\">x</button>\
    <input type='date' name='T_Date' id='Date'>\
    <input type='time' name='T_Time' id='Time'>`+((flag==1)?list:``)+
    `<input type='text' name='T_Title' id='Title' placeholder='Title' value=${title}>\
    <label for='Task'>Tasks</label>\
    <textarea style='resize:none; margin:0;' placeholder='Your Tasks' name='Task' id='Task' contenteditable='true' rows=8 cols=7>${tk}</textarea>\
    <center><input type='submit' value='save' id='btn'></center>`
    document.querySelector("body").appendChild(noteform);
    document.querySelector("#btn1").toggleAttribute("onclick","");
    document.getElementById("Date").value = today;
    document.getElementById("Time").value = time;
    var task =document.getElementById("Task");
    task.addEventListener("keyup",(e)=>{
        if(e.key==="Enter"){
            task.value+=String(task.value.split("\n").length)+".)";
        }
        if (task.value.length == 0)
            task.value += "1.)";
    })
}
function showCreateWorkspace(){
    if(document.getElementById("create-workspace-bbt")){
        document.getElementById("create-workspace-panel").style.display = 'block';
        document.getElementById("bbt-container").style.display = 'none';
        console.log(FORM2);
    }
}
function showJoinWorkspace(){
    if(document.getElementById("join-workspace-bbt")){
        document.getElementById("join-workspace-panel").style.display = 'block';
        document.getElementById("bbt-container").style.display = 'none';
    }
}
function class_compose(classname,desc,member_limit) {  //this function helps to create more workspaces for user
    if (document.getElementsByClassName("FORM2").length != 0) {
        document.getElementsByClassName("FORM2")[0].remove();
        return;
    }
    //Change this to fetch a code from API
    let chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for(var u = 0;u < 9;u++){
        let c = Math.floor(Math.random()*chars.length);
        code+=chars[c];
    }
    let noteform = document.createElement("form");let action = "main.php";
    noteform.setAttribute("action", action); noteform.setAttribute("method", "POST");
    noteform.setAttribute("class", "FORM2");
    noteform.setAttribute("onsubmit", "event.preventDefault();return checkEmpty(this)");
    noteform.innerHTML = 
    `<span id='Form_Caption'>Workspace Selector</span>\
    <button id = 'close' onclick = \"closeF(2)\"><img src='../media/cancelicon.png' id='cancel-icon-img'></button>\
    <div id='bbt-container'>
        <button id="create-workspace-bbt" onclick='showCreateWorkspace()'>Create Workspace</button>\
        <button id="join-workspace-bbt" onclick='showJoinWorkspace()'>Join Workspace</button>\
    </div>
    <div id='create-workspace-panel'>
        <input type='text' name='ClassName' id='CName' placeholder='Name'>\
        <textarea name = "ClassDesc" style='resize:none;' placeholder='This is my classroom?' name='' id='Cdesc' rows=4 cols=7 ></textarea>\
        <input type='text' name='ClassLimit' id='CLim' placeholder='ClassLimit'>\
        <input type='text' name='ClassCode' id='CCode' value='${code}' readonly>\
        <center><input type='submit' value='Save' id='btn' onclick='submit() '></center>
        </div>
        <div id='join-workspace-panel'>
        <input type='text' name='JClassCode' placeholder='Enter Workspace Code' id='CCode' value=''>\
        <center><input type='submit' value='JOIN' id='btn' onclick='submit()'></center>
        </div>
        `
    document.querySelector("body").appendChild(noteform);
    // document.querySelector("#btn1").toggleAttribute("onclick", "");
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
