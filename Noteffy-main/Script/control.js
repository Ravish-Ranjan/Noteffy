let ctx = document.getElementById("rendcont");
let cont = ctx.getContext("2d");
let cht;
Chart.defaults.font.size = 20;
Chart.defaults.font.family = "codec";
Chart.defaults.font.weight = "bold";
Chart.defaults.color = "white";
Chart.defaults.backgroundColor = "rgba(255,255,255,0.0)";
let data = {};

function cleanDate(date){
    return date.toISOString().split('T')[0];
}
function drawstat(id,nm) {
    ctx.style['background'] = "url('../media/workspaceAsset4.png')";
    ctx.style['background-size'] = "700px";
    ctx.style['background-repeat'] = "repeat";
    document.getElementById("chart-label").innerHTML = `${nm}'s Performance last month`;
    let ed = new Date();let sd = new Date(ed);sd.setDate(sd.getDay()-30);
    let dates = [];let counter =new Date(sd);
    //Initialize x-axis labels
    while(cleanDate(counter)!=cleanDate(ed)){
        dates.push(cleanDate(counter));
        counter.setDate(counter.getDate()+1);
    }
    if(cht!=null){
        cht.destroy();
    }
    let ctask1 = [],ctask2 = [],ctask3 = [];
    
    data.forEach((ustat)=>{
    if(ustat.user==0){
        let comptask1 = ustat.comptasks1;
        let comptask2 = ustat.comptasks2;
        let comptask3 = ustat.comptasks3;
        dates.forEach((date)=>{
            // console.log(comptask1.count[comptask1.dates.indexOf(date)],comptask2.count[comptask2.dates.indexOf(date)]);
            if(comptask1.dates.indexOf(date)>=0)
                ctask1.push(comptask1.count[comptask1.dates.indexOf(date)]);
            else
                ctask1.push(0);
            if(comptask2.dates.indexOf(date)>=0)
                ctask2.push(comptask2.count[comptask2.dates.indexOf(date)]);
            else
                ctask2.push(0);
            if(comptask3.dates.indexOf(date)>=0)
                ctask3.push(comptask3.count[comptask3.dates.indexOf(date)]);
            else
                ctask3.push(0);
        });
        return;
    }
});
    cht = new Chart(cont, {
              type: 'line',
              data: {
                labels: dates,
                datasets: [
                  { label: 'Priority 1',
                    data: ctask1,
                    backgroundColor:"red" ,
                    font:{
                      size:40,
                    },
                    borderColor:"red",
                  },
                  { label: 'Priority 2',
                    data: ctask2,
                    backgroundColor:"blue" ,
                    font:{
                      size:30,
                    },
                    borderColor:"blue",
                  },
                  { label: 'Priority 3',
                    data: ctask3,
                    backgroundColor:"green" ,
                    tension:0.1,
                    font:{
                      size:20,
                    },
                    borderColor:"green",
                  }
                ]
              },
              options: {
                bezierCurve:true,
                scales: { y: {
                     beginAtZero: true,
                     grid:{
                        color:"white",display:true
                     }},
                     x: { beginAtZero: false ,
                        grid:{
                           color:"white",display:true
                        }  }
                    },
                layout: { padding: 10 },
                plugins: {
                  legend: {
                      labels: {
                          font: {
                              size: 18,
                          }
                      }
                  }
              }
              }
   });
   fillCanv();
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
    divs = document.getElementsByClassName("main")
    if(tabname){
      fillCanv();
    }
}
let Username = async () => {
    let user_name = "User Name";
    let decodedCookie = decodeURIComponent(document.cookie);
    decodedCookie = decodedCookie.split(";");
    Array.from(decodedCookie).map((ele) => {
        let temp = ele.split("=");
        if (temp[0].trim() == "user") {
            user_name = temp[1].trim();
        }
    })
    user = await fetch(window.location.href.split("/HTML/control.html")[0] + "/php/encrypt_cookie.php?" + (new URLSearchParams({ value: user_name })), { method: "GET", mode: "cors" });
    user = await user.json();
    user = user['res'];
    // document.getElementById("user-name-card-explore").innerText = user;

    let classSelection = document.getElementById("workspace-select-explore");
    let default_option = document.createElement("option");
    default_option.text = "Your classes";
    classSelection.options.add(default_option, 0);
}
Username()
let getClasses = async () => {
    let loc = window.location.href.split("/HTML/control.html");
    let response = await fetch(loc[0] + "/php/admin.php?" + (new URLSearchParams({ classes: "true" })), { method: "GET", mode: "cors" });
    response = await response.json();
    if (response['result'] == "success") {
        let workspace_select = document.querySelectorAll(".workspace-select");
        workspace_select.forEach((selector)=>{
            response['cls'].forEach((ele) => {
            let option = document.createElement("option");
            option.text = ele;
            selector.options.add(option, selector.options.length);
        })
        });
    }
}
getClasses();

let classSelection = document.querySelectorAll(".workspace-select");

classSelection.forEach((selector)=>{selector.addEventListener("input",async (elem)=>{
    
    let cardn = (elem.target.id=='workspace-select-explore'?'explore-panel':'chart-panel');
    let card = document.getElementById(cardn);
    let markup = '';

    let loc = window.location.href.split("/HTML/control.html");
    let response = await fetch(loc[0] + "/php/admin.php?" + (new URLSearchParams({ className: elem.target.value })), { method: "GET", mode: "cors" });
    response = await response.json();
    response['name'].forEach((name) => {
    markup += `   <div id="explore-user-card" onclick="drawstat(${response['id'][response['name'].indexOf(name)]},'${name}')">
    <img src="../media/logoorangep.png" id="user-card-avatar">
    <p class="user-name-card">${name}</p>
    </div>`;
    });
    card.innerHTML = markup;
    data = response['stats'];
});
});

function fillCanv(){
  cont.font = "40px codec";
  let rect = ctx.getBoundingClientRect();
  let url = window.location.href.split('/HTML')[0]+"/media/noteffyTitle.png";
  console.log(url);
  var img = new Image();
  img.src = url;
  img.onload = ()=>{
    cont.fill();
  }
}
function initializeDate() {
    let days = $("days");
    let month_select = $("month_select");
    let year_select = $("year_select");
    
    let d = new Date();
    month_select.innerText = d.toLocaleDateString("en-US", { month: "long" });
    year_select.innerText = d.getFullYear();
}
function nextMonth() {
    let days = $("days");
    let month_select = $("month_select");
    let year_select = $("year_select");
    
    let date = `${year_select.innerText}-${month_select.innerText}-1`;
    let d = new Date(date);
    if (d.getMonth() + 1 != 12) {
        d.setMonth(d.getMonth()+1);
    }
    else {
        d.setFullYear(d.getFullYear() + 1);
        d.setMonth(1);
    }
    month_select.innerText = d.toLocaleDateString("en-US", { month: "long" })
    year_select.innerText = d.getFullYear();
    getDays();

}
function previousMonth() {
    let days = $("days");
    let month_select = $("month_select");
    let year_select = $("year_select");
    
    let date = `${year_select.innerText}-${month_select.innerText}-1`;
    let d = new Date(date);
    if (d.getMonth() - 1 != 0) {
        d.setMonth(d.getMonth()-1);
    }
    else {
        d.setFullYear(d.getFullYear() - 1);
        d.setMonth(12);
    }
    month_select.innerText = d.toLocaleDateString("en-US", { month: "long" })
    year_select.innerText = d.getFullYear();
    getDays();
    
}
function getDays() {
    let days_select = $("days");
    days_select.innerHTML = ``;
    
    let month_select = $("month_select").innerText;
    let year_select = $("year_select").innerText;
    
    let date = `${year_select}-${month_select}-1`;
    let d = new Date(date);

    let days = (new Date(d.getFullYear(), d.getMonth()+1, 0).getDate())
    for (let day = 0; day < days; day++){
        let li = document.createElement("li");
        if (day == (new Date().getDate())) {
            let span = document.createElement("span");
            span.setAttribute("class", "active");
            span.innerText = day+1;
            li.appendChild(span);
            console.log("hello")
        }
        else {
            li.innerText = day + 1;
        }
        days_select.appendChild(li);
    }
}
getDays();