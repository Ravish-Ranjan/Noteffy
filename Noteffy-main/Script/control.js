let ctx = document.getElementById("rendcont");
let cont = ctx.getContext("2d");
let data = {};

function $(id) {
    return document.getElementById(id);
}
function drawstat(id) {
    let d = new Date();
    let dd = d.toLocaleDateString("en-US", { month: "long" });
    console.log(dd);
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
    if (response['result'] == "success") {
        let workspace_select = document.querySelectorAll(".workspace-select");
        console.log(workspace_select);
        workspace_select.forEach((selector) => {
            if (selector.options.length == 1) {
                response['cls'].forEach((ele) => {
                    let option = document.createElement("option");
                    option.text = ele;
                    option.value = ele;
                    selector.options.add(option, selector.options.length);
                })
            }
        });
    }
}
getClasses();

let classSelection = document.querySelectorAll(".workspace-select");
classSelection.forEach((selector) => {
    selector.addEventListener("input", async (elem) => {
        console.log(elem);
        let classSelection = elem.target;
        let cardn = (elem.target.id == 'workspace-select-explore' ? 'explore-panel' : 'chart-panel');
        let card = document.getElementById(cardn);
        let originalMarkup = card.innerHTML;
        let markup = '';

        let loc = window.location.href.split("/HTML/control.html");
        let response = await fetch(loc[0] + "/php/admin.php?" + (new URLSearchParams({ className: elem.target.value })), { method: "GET", mode: "cors" });
        response = await response.json();
        response['name'].forEach((name) => {
            markup += `   <div id="explore-user-card">
    <img src="../media/logoorangep.png" onhover="drawstat(${response['id'][response['name'].indexOf(name)]})" id="user-card-avatar">
    <p class="user-name-card">${name}</p>
    </div>`;
        });
        card.innerHTML = markup;
    });
});




function fillCanv() {
    cont.font = "40px codec";
    let rect = ctx.getBoundingClientRect();
    let img = new Image();
    cont.fillText("Noteffy", 10, rect.height / 2.5);
}

// fetch("../data/task.php").then((res) => res.json()).then((json) => {
//     let datx = [1,2,3,4,5,6,7,9];
//     let daty1 = datx.map((ele)=>{
//         return Math.pow(ele,2);
//     });
//     let daty2 = datx.map((ele)=>{
//         return Math.pow(ele,3);
//     });
//     let daty3 = datx.map((ele)=>{
//         return Math.pow(ele,4);
//     });
//     Chart.defaults.font.size = 20;
//     Chart.defaults.font.weight = "bold";
//     Chart.defaults.color = "black";
//     Chart.defaults.backgroundColor = "gray";
//     const cht = new Chart(ctx, {
//       type: 'line',
//       data: {
//         labels: datx,
//         datasets: [
//           { label: 'Priority 1',
//             data: daty1,
//             backgroundColor:"red" ,
//             font:{
//               size:20,
//             },
//             borderColor:"#bdbdbd",
//           },
//           { label: 'Priority 2',
//             data: daty2,
//             backgroundColor:"blue" ,
//             font:{
//               size:20,
//             },
//             borderColor:"#bdbdbd",
//           },
//           { label: 'Priority 3',
//             data: daty3,
//             backgroundColor:"green" ,
//             font:{
//               size:20,
//             },
//             borderColor:"#bdbdbd",
//           }
//         ]
//       },
//       options: {
//         bezierCurve:true,
//         scales: { y: { beginAtZero: true },
//         x: { beginAtZero: false } },
//         layout: { padding: 10 },
//         plugins: {
//           legend: {
//               labels: {
//                   font: {
//                       size: 18,
//                   }
//               }
//           }
//       }
//       }
//     });
//   })
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
        d.setMonth(d.getMonth() + 1);
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
        d.setMonth(d.getMonth() - 1);
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

    let days = (new Date(d.getFullYear(), d.getMonth() + 1, 0).getDate())
    for (let day = 0; day < days; day++) {
        let li = document.createElement("li");
        if (day == (new Date().getDate())) {
            let span = document.createElement("span");
            span.setAttribute("class", "active");
            span.innerText = day + 1;
            li.appendChild(span);
        }
        else {
            li.innerText = day + 1;
        }
        days_select.appendChild(li);
    }
}