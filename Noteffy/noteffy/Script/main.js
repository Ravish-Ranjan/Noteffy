if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

function clearCookies(){
    document.cookie = "user=;";
}
function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
}
function pos() {
    openTab(event, 'Notes')
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
function openTab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("main");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tbs");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
    const bg = ["url(\"../media/bg1.png\")","url(\"../media/bg2.png\")"];
    console.log(document.body.style.backgroundImage);
    if (document.body.style.backgroundImage == bg[0]){
        document.body.style.backgroundImage = bg[1];
    }
    else{
        document.body.style.backgroundImage = bg[0];
    }
  }