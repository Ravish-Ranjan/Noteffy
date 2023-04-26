let ctx = document.getElementById("rendcont");
let cont = ctx.getContext("2d");
let cht;
Chart.defaults.font.size = 20;
Chart.defaults.font.family = "codec";
Chart.defaults.font.weight = "bold";
Chart.defaults.color = "white";
Chart.defaults.backgroundColor = "rgba(255,255,255,0.0)";
let data = {};let events = [];

ctx.addEventListener('', (e) => {
    console.log(e);
    ctx['animation'] = "fade 1.5s linear";
});
document.querySelector("#temp").addEventListener('input', (elem) => {
    let val = elem.target.value;
    if (val <= 15) {
        elem.target.value = 0;
    }
    else if (val <= 50) {
        elem.target.value = 30;
    }
    else if (val <= 85) {
        elem.target.value = 70;
    }
    else {
        elem.target.value = 100;
    }
    drawstat(ctx.getAttribute("datai"));
});
function $(id) {
    return document.getElementById(id);
}
function cleanDate(date) {
    return date.toISOString().split('T')[0];
}
function drawstat(id, nm) {
    // ctx.style['background'] = "url('../media/background_5.png')";
    ctx.style['background'] = 'rgb(255,57,57)';
    ctx.style['background-size'] = "fit";
    ctx.style['background-repeat'] = "no-repeat";
    ctx.setAttribute('datai', id);
    if (nm != null)
        document.getElementById("chart-label").innerHTML = `${nm}'s Performance`;
    let ed = new Date(); let sd = new Date(ed); sd.setDate(sd.getDay() - 30);
    let dates = []; let counter = new Date(sd);
    //Initialize x-axis labels
    while (cleanDate(counter) != cleanDate(ed)) {
        dates.push(cleanDate(counter));
        counter.setDate(counter.getDate() + 1);
    }
    if (cht != null) {
        cht.destroy();
    }
    let ctask1 = [], ctask2 = [], ctask3 = [];

    var val = document.querySelector("#temp").value; let start = 0, label = '';
    switch (val) {
        case '0': start = 0; label = 'Last month'; break;
        case '30': start = 8; label = 'Last 3 weeks'; break;
        case '70': start = 16; label = 'Last 2 weeks'; break;
        case '100': start = 24; label = 'Last week'; break;
    }
    var dates1 = dates.slice().splice(start);
    data.forEach((ustat) => {
        if (ustat.user == id) {
            let comptask1 = ustat.comptasks1;
            let comptask2 = ustat.comptasks2;
            let comptask3 = ustat.comptasks3;
            dates1.forEach((date) => {
                if (comptask1.dates.indexOf(date) >= 0)
                    ctask1.push(comptask1.count[comptask1.dates.indexOf(date)]);
                else
                    ctask1.push(0);
                if (comptask2.dates.indexOf(date) >= 0)
                    ctask2.push(comptask2.count[comptask2.dates.indexOf(date)]);
                else
                    ctask2.push(0);
                if (comptask3.dates.indexOf(date) >= 0)
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
            labels: dates1,
            datasets: [
                {
                    label: 'Priority 1',
                    data: ctask1,
                    backgroundColor: "#f72839",
                    font: {
                        size: 40,
                    },
                    borderColor: "#f72839",
                },
                {
                    label: 'Priority 2',
                    data: ctask2,
                    backgroundColor: "blue",
                    font: {
                        size: 30,
                    },
                    borderColor: "blue",
                },
                {
                    label: 'Priority 3',
                    data: ctask3,
                    backgroundColor: "green",
                    tension: 0.1,
                    font: {
                        size: 20,
                    },
                    borderColor: "green",
                }
            ]
        },
        options: {
            bezierCurve: true,
            scales: {
                y: {
                    max: 30,
                    beginAtZero: true,
                    grid: {
                        color: "white", display: true
                    }
                },
                x: {
                    beginAtZero: false,
                    grid: {
                        color: "white", display: true
                    }
                }
            },
            layout: { padding: 10 },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 18,
                        }
                    },
                },
                title: {
                    display: true,
                    text: label
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
    if (tabname) {
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
    console.log(response);
    if (response['result'] == "success") {
        let workspace_select = document.querySelectorAll(".workspace-select");
        workspace_select.forEach((selector) => {
            if (selector.options.length == 1) {
                if (selector.id == "workspace-select-insight-2") {
                    response['member_cls'].forEach((ele) => {
                        let option = document.createElement("option");
                        option.text = ele;
                        option.value = ele;
                        selector.options.add(option, selector.options.length);
                    })
                }
                else {
                    response['cls'].forEach((ele) => {
                        let option = document.createElement("option");
                        option.text = ele;
                        option.value = ele;
                        selector.options.add(option, selector.options.length);
                    })
                }
            }
        });
    }
}
getClasses();

let classSelection = document.querySelectorAll(".workspace-select");

classSelection.forEach((selector) => {
    selector.addEventListener("input", async (elem) => {

        let cardn = (elem.target.id == 'workspace-select-explore' ? 'explore-panel' : 'chart-panel');
        let card = document.getElementById(cardn);
        let markup = '';

        let loc = window.location.href.split("/HTML/control.html");
        let response = null;
        try{
            response = await fetch(loc[0] + "/php/admin.php?" + (new URLSearchParams({ className: elem.target.value })), { method: "GET", mode: "cors" });
            response = await response.json();
        }
        catch (e) {
            if (ctx.style['background'] != "url('../media/statsGIF.gif')") {
                ctx.style['background'] = "url('../media/statsGIF.gif')";
            }
            ctx.style['background-size'] = "100%";
            ctx.style['background-repeat'] = "no-repeat";
            ctx.style['background-position'] = "50% 50%";
            if (cht != null) {
                cht.destroy();
            }
            return;
        }
        if (response['name'].length == 0) {
            if (cardn == 'chart-panel') {
                if (ctx.style['background'] != "url('../media/statsGIF.gif')") {
                    ctx.style['background'] = "url('../media/statsGIF.gif')";
                }
                ctx.style['background-size'] = "100%";
                ctx.style['background-repeat'] = "no-repeat";
                ctx.style['background-position'] = "50% 50%";
                if (cht != null) {
                    cht.destroy();
                }
            }
        }
        document.getElementById("chart-label").innerHTML = `Assess your students`;
        response['name'].forEach((name) => {
            markup += `     <div id="explore-user-card" onclick="drawstat(${response['id'][response['name'].indexOf(name)]},'${name}')">
                                <img src="../media/logoorangep.png" id="user-card-avatar">
                                <p class="user-name-card">${name}</p>
                            </div>`;
        });
        card.innerHTML = markup;
        // card.innerHTML = markup;
        data = response['stats'];
    })
});

function fillCanv() {
    cont.font = "40px codec";
    let rect = ctx.getBoundingClientRect();
    let url = window.location.href.split('/HTML')[0] + "/media/noteffyTitle.png";
    var img = new Image();
    img.src = url;
    img.onload = () => {
        cont.fill();
    }
}
function initializeDate() {
    let days = $("days");
    let month_select = $("month_select");
    let year_select = $("year_select");

    let d = new Date();
    month_select.innerText = d.toLocaleDateString("en-US", { month: "long" }).toUpperCase();
    year_select.innerText = d.getFullYear();
}
function nextMonth() {
    let days = $("days");
    let month_select = $("month_select");
    let year_select = $("year_select");

    let date = `${year_select.innerText}-${month_select.innerText}-1`;
    let d = new Date(date);
    if (d.getMonth() + 1 != 12) {
        d.setMonth(d.getMonth() + 1);
    }
    else {
        d.setFullYear(d.getFullYear() + 1);
        d.setMonth(1);
    }
    month_select.innerText = d.toLocaleDateString("en-US", { month: "long" }).toUpperCase();
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
                d.setMonth(d.getMonth() - 1);
            }
            else {
                d.setFullYear(d.getFullYear() - 1);
                d.setMonth(12);
            }
            month_select.innerText = d.toLocaleDateString("en-US", { month: "long" }).toUpperCase();
            year_select.innerText = d.getFullYear();
            getDays();

        }
        async function getDays() {
            events = await fetchEvents();
            console.log(events);
            let days_select = $("days");
            days_select.innerHTML = ``;

            let month_select = $("month_select").innerText;
            let year_select = $("year_select").innerText;

            let date = `${year_select}-${month_select}-1`;
            let d = new Date(date);

            let firstDay = parseInt(d.getDay());
            let days = (new Date(d.getFullYear(), d.getMonth() + 1, 0).getDate())
            for (let day = 0; day < days; day++) {
                let months = ["JANUARY","FEBRUARY","MARCH","APRIL","MAY","JUNE","JULY","AUGUST","SEPTEMBER","OCTOBER","NOVEMBER","DECEMBER"];
                let sdate = [year_select,String(months.indexOf(month_select)+1).padStart(2,'0'),String(day+1).padStart(2,'0')].join("-");
                let li = document.createElement("li");
                let ave  = events.filter((ev)=>{
                    console.log(sdate);console.log(ev.Date);
                    if(ev.Date==sdate)
                    return true;
                    else
                    return false;
                });
                if (firstDay > 1) {
                    firstDay--;
                    day--;
                }
                else if (ave.length>0) {
                    let span = document.createElement("span");
                    span.setAttribute("class", "active");
                    li.addEventListener("click",(e)=>{
                        showEvent(ave[0]);
                    });
                    console.log(ave[0]);
                    span.innerText = day + 1;
                    li.appendChild(span);
                }
                else {
                    li.innerText = day + 1;
                    li.addEventListener("click",(e)=>{
                        createSchedule(sdate);
                    });
                }
                days_select.appendChild(li);
            }
}
async function fetchEvents(){
    let loc = window.location.href.split("/HTML/control.html");
    let response = await fetch(loc[0] + "/php/admin.php?" + (new URLSearchParams({ events: "true"})), { method: "GET", mode: "cors" });
    response = await response.json();
    if (response['Message'] == "success") {
        events = response['events'];
    }
    return events;
}
async function fetchEvents(){
    let loc = window.location.href.split("/HTML/control.html");
    let response = await fetch(loc[0] + "/php/admin.php?" + (new URLSearchParams({ events: "true"})), { method: "GET", mode: "cors" });
    response = await response.json();
    if (response['Message'] == "success") {
        events = response['events'];
    }
    return events;
}