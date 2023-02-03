if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
}
function pos() {
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