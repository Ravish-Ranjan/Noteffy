if ( window.history.replaceState ) { // this function changes the state of a page
    window.history.replaceState( null, null, window.location.href );
}

function clearCookies(){ // this function is used to clear the cookies of user to log him out
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const namePos = cookie.indexOf("=");
        const name = namePos > -1 ?cookie.substr(0, namePos):cookie;
        if(name=='user'){
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }
}
function setCookie(tabname){
    const d = new Date();
    d.setTime(d.getTime() + (5*10*1000));
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
function pos() { // this function styles the notes/tasks to be displayed in scattered/random manner
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
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabname).style.display = "block";
    evt.currentTarget.className += " active";
    // if
    // const bg = ["url(\"../media/bg1.png\")","url(\"../media/bg2.png\")"];
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