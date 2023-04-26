function showsidespace(){
    document.getElementById("spaceside").style.display = "block";
}
function showsidestation(){
    document.getElementById("stationside").style.display = "block";
}
function hidesidespace(){
    document.getElementById("spaceside").style.display = "none";
}
function hidesidestation(){
    document.getElementById("stationside").style.display = "none";
}
function workspacemain(){
    let count = 5;
    inhtml = "";
    for (let i = 0; i < count; i++) {
        inhtml += "<div class=\"class\">\
                            <div class=\"backg\"><h2>ClassName</h2></div>\
                            <div class=\"options\">\
                                <button>opt1</button>\
                                <button>opt2</button>\
                            </div>\
                    </div>";
    }
    let mainsp = document.getElementById("mainspace");
    let mainsty = {
        "flexDirection":"row",
        "flexWrap":"wrap"
    }
    Object.assign(mainsp.style,mainsty);
    document.getElementById("mainspace").innerHTML = inhtml;
}
function workstationmain(){
    let count = 10;
    inhtml = "";
    for (let i = 0; i < count; i++) {
        inhtml += "<div class=\"tile\">\
                        <h2>Content</h2>\
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatibus \
                        </p>\
                        <div class=\"control\">\
                            <button>Copy</button>\
                            <button>Delete</button>\
                        </div>\
                    </div>";
    }
    document.getElementById("mainstation").innerHTML = inhtml;
}
function workspacetodo(){
    let count = 10;
    inhtml = "";
    for (let i = 0; i < count; i++) {
        inhtml += `<div id=\"work\" class=\"work\">\
                            <h2>Work ${i+1}</h2>\
                    </div>`;
    }
    document.getElementById("mainspace").innerHTML = inhtml;
    document.querySelector(".workspace>.main").style.flexDirection="row";
}
