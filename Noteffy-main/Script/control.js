let ctx = document.getElementById("rendcont");
let cont = ctx.getContext("2d");

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
    getClassMember();
}
getClasses();

let getClassMember = () => {
    let classSelection = document.getElementById("workspace-select-explore");
    let card = document.getElementById('explore-panel');
    let originalMarkup = card.innerHTML;
    classSelection.addEventListener("input", async (e) => {
        let markup = originalMarkup;
        let loc = window.location.href.split("/HTML/control.html");
        let response = await fetch(loc[0] + "/php/admin.php?" + (new URLSearchParams({ className: e.target.value })), { method: "GET", mode: "cors" });
        response = await response.json();
        response['name'].forEach((name) => {
            markup += `   <div id="explore-user-card">
                <img src="../media/logoorangep.png" id="user-card-avatar">
                 <p class="user-name-card">${name}</p>
             </div>`
        })
        card.innerHTML = markup;
    })
}


function fillCanv(){
  cont.font = "30px Arial";
  let rect = ctx.getBoundingClientRect();
  let img = new Image();
  img.onload = ()=>{
  img.src = '../media/noteffyTitle.png';
  cont.drawImage(img,10,50);
  }
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