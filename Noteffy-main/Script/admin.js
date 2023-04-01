function revealAdmin(){
    document.getElementById("top-container").style.opacity = "1";
    document.getElementById("admin-workspace-panel").style.opacity = "1";
    document.getElementById("button-info-container").style.display = "none";
    document.getElementById("unlock-images").style.display = "none";
}
function revealWorkspacePanel(){
if(document.getElementById("admin-nav-button-1").click){
    document.getElementById("admin-workspace-panel").style.display = "flex";
    document.getElementById("todo-admin-panel").style.display = "none";
}
}

function revealToDoPanel(){
if(document.getElementById("admin-nav-button-2").click){
    document.getElementById("admin-workspace-panel").style.display = "none";
    document.getElementById("todo-admin-panel").style.display = "flex";
}
}
function switchAdmin(){
    let decoded = decodeURIComponent(document.cookie);
    let vals = decoded.split(';');
    for(let u = 0;u < vals.length;u++){
        let key_val = vals[u].split('=');
        if(key_val[0].trim()=="user_number"){
            var loc = window.location.href.split('/php')[0];
            fetch(loc+"/php/main.php?"+(new URLSearchParams({'op':'chadmin'})),{
            method:"POST",mode:"cors",header:'Content-Type:application/json;charset=utf-8'
            }).then((dat)=>dat.json()).then((jsond)=>{
            if(jsond['Message']=="admin success"){
                //Unlock panel here
                window.location.reload();
                return 1;
            }else if(jsond['Message']=="admin present"){
                message("you are already any admin");return 2;
            }
            else{
                message("can't connect to the server right now");
                return -1;
            }
    });
        }
    }
}
async function checkAdmin(){
    let decoded = decodeURIComponent(document.cookie);
    let vals = decoded.split(';');
    for(let u = 0;u < vals.length;u++){
        let key_val = vals[u].split('=');
        if(key_val[0].trim()=="user_number"){
            var loc = window.location.href.split('/php')[0];
            var res = await fetch(loc+"/php/main.php?"+(new URLSearchParams({'op':'checkadmin'})),{
            method:"POST",mode:"cors",header:'Content-Type:application/json;charset=utf-8'
            });
            var js = await res.json();
            switch(js["Message"]){
                case 'admin true':
                    return 1;
                case 'admin false':
                    return 0;
                default:
                    return -1;
            }
        }
    }
}
function hideAdmin() {
    document.getElementById("top-container").style.opacity = "0";
    document.getElementById("admin-workspace-panel").style.opacity = "0";
    document.getElementById("button-info-container").style.display = "block";
    document.getElementById("unlock-images").style.display = "block";
}
function revealWorkspacePanel() {
    if (document.getElementById("admin-nav-button-1").click) {
        document.getElementById("admin-workspace-panel").style.display = "block";
        document.getElementById("todo-admin-panel").style.display = "none";
    }
}

function revealToDoPanel() {
    if (document.getElementById("admin-nav-button-2").click) {
        document.getElementById("admin-workspace-panel").style.display = "none";
        document.getElementById("todo-admin-panel").style.display = "block";
    }
}
function collapsetasks(ele){
    let todo = ele.parentElement;
    let tasks = ele.getAttribute("data-array");
    tasks = tasks.split(',');
    tasks = tasks.reverse();
    tasks.forEach((task)=>{
        let domtask = document.createElement("label");
        domtask.style.backgroundColor = ele.style.backgroundColor;
        domtask.style.opacity = '0.6';
        domtask.setAttribute('for','123');
        domtask.innerHTML = `${task} <img src = "../media/delete.png" onclick="completeAdminTask("${todo.children[0].getAttribute('data-cname')}",${task}})">`;
        if(ele.nextSibling!=null){
            todo.insertBefore(domtask,ele.nextSibling);
        }
        else{
            todo.appendChild(domtask);
        }
    });
    ele.style['filter'] = "drop-shadow(0 0 0.6rem white)";
    ele.setAttribute("onclick","uncollapsetasks(this)");
}
function uncollapsetasks(ele){
    let todo = ele.parentElement;
    let task = ele.nextSibling;
    ele.style['filter'] = null;
    ele.setAttribute("onclick","collapsetasks(this)");
    while(task.getAttribute("for")=="123"){
        let curr = task;
        task = task.nextSibling;
        curr.remove();
        if(task==null)
            break;
    }
}
async function displayAdminTodo(ele){
    let adminlist = document.querySelector('#todo-admin-panel');
    let options = {
        method:'GET',
        mode:'cors'
    };
    let queries = {
        'admin':true,
        'todo':true
    };
    var loc = window.location.href.split('/php')[0];
    let resplist = await fetch(loc+"/php/admin.php?"+(new URLSearchParams(queries)),options);
    let jsonlist = await resplist.json();
    if(jsonlist['To-do']!=null){
        jsonlist['To-do'].forEach(ele => {
            const color = Math.floor(Math.random()*16777215).toString(16);
            
            //Classroom name
            let classgroup = document.createElement('div');let cname = ele.Name;
            classgroup.classList = ['classg'];classgroup.style.opacity = 0.8;
            ele['Tasks'].forEach((task)=>{
                let tasknode = document.createElement('label');
                let tasks = task.Tasks;
                tasknode.setAttribute("data-cname",cname);
                tasknode.setAttribute("data-array",`${tasks})`);
                tasknode.setAttribute("onclick","collapsetasks(this)")
                tasknode.style.backgroundColor = color;
                tasknode.innerHTML = `${task.Title} Due: ${task.Time} on ${task.Date}`;
                classgroup.appendChild(tasknode);
            });
            adminlist.appendChild(classgroup);
        });
    }else{
        adminlist.innerHTML = `
        <h1>No tasks currently</h1>`;
    }
}
displayAdminTodo(document.getElementById("todo-admin-panel"));
