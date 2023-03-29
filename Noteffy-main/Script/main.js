if ( window.history.replaceState ) { // this function changes the state of a page
    window.history.replaceState( null, null, window.location.href );
}

function clearCookies(){ // this function is used to clear the cookies of user to log him out
    let decodedCookie = decodeURIComponent(document.cookie);
    decodedCookie = decodedCookie.split(";");
    for (i = 0; i < decodedCookie.length; i++){
        let temp = decodedCookie[i].split("=");
        if (temp[0].trim() == "user") {
            console.log(temp[1]);
            document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            window.location.href = '../php/index.php';
        }
        if (temp[0].trim() == "user_number") {
            console.log(temp[1]);
            document.cookie = "user_number=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            window.location.href = '../php/index.php';
        }
    }
}
function setCookie(tabname){
    const d = new Date();
    d.setTime(d.getTime() + (24*60*60*1000));
    document.cookie = "name="+tabname+";expires="+ d.toUTCString()+";path=/";
}
function chan(at){
    for (let i = 0; i < 3; i++) {                  
        document.getElementsByClassName("main")[i].style.display="none";
    }
    document.getElementById(at-1).style.display="block";
    setCookie(at);
}
function getRandomArbitrary(min, max) { //this function gets random value in given range
    return Math.random() * (max - min) + min;
}
async function pos() { // this function styles the notes/tasks to be displayed in scattered/random manner
    window.scrollTo(window.innerWidth,0);
    var cadmin = await checkAdmin();
<<<<<<< HEAD
    if(cadmin==1){
        revealAdmin();
=======
    if(cadmin!=1){
        hideAdmin();
>>>>>>> d27cbda633a52179e4284439dce4592fd4256091
    }
    decodedCookie = decodeURIComponent(document.cookie);
    decodedCookie = decodedCookie.split(";");
    flag = false;
    for (j = 0; j < decodedCookie.length; j++){
        if (decodedCookie[j].split("=")[0].trim() == "name") {
            chan(decodedCookie[j].split("=")[1]);
            flag = true;
        }
    }
    if (!flag)
        chan(1);
    var count = $(".divi").length;
    for (let i = 0; i < count; i++){
        var styles ={
            "top":getRandomArbitrary(40,0),
            "right":getRandomArbitrary(-90,0),
            "rotate":getRandomArbitrary(-13,13)+"deg"
        };
        var obj = document.getElementsByClassName("divi");
        Object.assign(obj[i].style,styles);
    }
}
function openTab(evt, tabname) { // this function is used to move arround the tabs in the main page
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("main");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tbs");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace("active", "");
    }
    
    document.getElementById(tabname).style.display = "block";
    evt.currentTarget.className += " active";

    Array.from(tablinks).map((ele)=>{
        if(!(ele.className.includes('active'))){
            ele.style.opacity = "0.5";
        }
        else{
            ele.style.opacity = "1";
        }
    });
    divs = document.getElementsByClassName("main")
    for (let i = 0; i < divs.length-1; i++) {
        if (divs[i].style.display=="block") {
            document.getElementById("comp"+String(i+1)).style.display="block" ;
        }        
        else{
            document.getElementById("comp"+String(i+1)).style.display="none" ;
        }
    }
    chan(parseInt(tabname)+1);
}
function showmenu(){
    document.getElementById("sidepanel").style.display = "block";
    document.getElementById("logo").style.filter = "blur(10px)";
    for (i = 1; i < document.getElementById("wrapper").childElementCount; i++){
        document.getElementById("wrapper").children[i].style.filter = "blur(10px)";
    }
}
function hidemenu(){
    document.getElementById("logo").style.filter = "blur(0px)";
    for (i = 1; i < document.getElementById("wrapper").childElementCount; i++){
        document.getElementById("wrapper").children[i].style.filter = "blur(0px)";
    }
    document.getElementById("sidepanel").style.display= "none";
}
function signUp() {
    
    window.location.href = "../HTML/signUp.html";
}
function revealAdmin(){
    document.getElementById("top-container").style.opacity = "1";
    document.getElementById("admin-workspace-panel").style.opacity = "1";
    document.getElementById("button-info-container").style.display = "none";
    document.getElementById("unlock-images").style.display = "none";
}
function revealWorkspacePanel(){
if(document.getElementById("admin-nav-button-1").click){
    document.getElementById("admin-workspace-panel").style.display = "block";
    document.getElementById("todo-admin-panel").style.display = "none";
}
}

function revealToDoPanel(){
if(document.getElementById("admin-nav-button-2").click){
    document.getElementById("admin-workspace-panel").style.display = "none";
    document.getElementById("todo-admin-panel").style.display = "block";
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
<<<<<<< HEAD
                revealAdmin();
                return 1;
            }else if(jsond['Message']=="admin present"){
                message("you are already any admin","message_success");return 2;
            }
            else{
                message("can't connect to the server right now","message_failure");
=======
                window.location.reload();
                return 1;
            }else if(jsond['Message']=="admin present"){
                message("you are already any admin");return 2;
            }
            else{
                message("can't connect to the server right now");
>>>>>>> d27cbda633a52179e4284439dce4592fd4256091
                return -1;
            }
    });
        }
    }
}
async function checkAdmin(){
    let decoded = decodeURIComponent(document.cookie);
    let vals = decoded.split(';');
<<<<<<< HEAD
=======
    console.log(123);
>>>>>>> d27cbda633a52179e4284439dce4592fd4256091
    for(let u = 0;u < vals.length;u++){
        let key_val = vals[u].split('=');
        if(key_val[0].trim()=="user_number"){
            var loc = window.location.href.split('/php')[0];
            var res = await fetch(loc+"/php/main.php?"+(new URLSearchParams({'op':'checkadmin'})),{
            method:"POST",mode:"cors",header:'Content-Type:application/json;charset=utf-8'
            });
<<<<<<< HEAD
            var js = await res.json();;
=======
            var js = await res.json();
            console.log(js["Message"]);
>>>>>>> d27cbda633a52179e4284439dce4592fd4256091
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
