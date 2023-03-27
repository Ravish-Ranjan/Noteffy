async function decrypt_data(enc_data) {
  let loc = window.location.href.split('/HTML/chart.html');
  let resp = await fetch(loc[0] + '/php/encrypt_cookie.php?' + (new URLSearchParams({ value: enc_data })), { method: 'GET', mode: 'cors' });
  resp = await resp.json();
  return resp['res'];
}
function generate() {
  var avatarId = getUser();
  var svgCode = multiavatar(avatarId);
  return svgCode
}
function crt(){
  let data = generate();
  document.getElementById("data").innerHTML = data;
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
}
function calc_completed_task(jsonData) {
  let date = [];
  date[0] = "";
  let count = [1];
  let user;
  let decodedCookie = decodeURIComponent(document.cookie);
  decodedCookie = decodedCookie.split(";");
  for (j = 0; j < decodedCookie.length; j++){
    c = decodedCookie[j];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    c = c.split("=");
    if (c[0].split() == "user_number") {
      user = c[c.length-1];
    }
  }
  for (i = 0; i < jsonData.length; i++){
    if (!(date.includes(jsonData[i]['Date'])) && user == jsonData[i]["User"]) {
      date.push(jsonData[i]['Date']);
    }
    count[i] = 0;
  }
  for (i = 0; i < jsonData.length; i++){
    if (date.includes(jsonData[i]['Date']) && jsonData[i]["User"] == user) {
      count[date.indexOf(jsonData[i]['Date'])]++;
    }
  }
  var obj = {
    "date": date,
    "count" :count
  }
  document.getElementById("score-number").innerText = count[count.length-1];
  return obj;
}

function getUser() {
  let decodedCookie = decodeURIComponent(document.cookie);
  decodedCookie = decodedCookie.split(";");
  for (i = 0; i < decodedCookie.length; i++){
    if (decodedCookie[i].split("=")[0].trim() == "user") {
      return decodedCookie[i].split("=")[1];
    }
  }
  return  "Your user name";
}

function getrandcolor(){
  let clrs = [  "#a1c4fd",
                "#84fab0",
                "#e0c3fc",
                "#5ee7df"]
  let cl =  clrs[Math.floor(Math.random()*clrs.length)];
  document.getElementById("container").style.backgroundColor = cl;
  return cl;
}
let userName = async () => {
  document.getElementById("user-name").innerText = await decrypt_data(getUser());
}
userName(); //fetching the username 
const ctx = document.getElementById('context');

// fetching data for chart
fetch("../data/task.json").then((res) => res.json()).then((json) => {
  let obj = calc_completed_task(json);
  Chart.defaults.font.size = 20;
  Chart.defaults.font.weight = "bold";
  Chart.defaults.color = "black";
  Chart.defaults.backgroundColor = "gray";
  const cht = new Chart(ctx, {
    type: 'line',
    data: { 
      labels: obj.date,
      datasets: [
        { label: 'Number of tasks completed',
          data: obj.count,borderWidth: 10,
          backgroundColor:"black" ,
          font:{
            size:20,
          },
          borderColor:"#bdbdbd",
        },
      ]
    },
    options: { 
      scales: { y: { beginAtZero: true },
      x: { beginAtZero: false } },
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
})
// fetching date joined
fetch("../data/Data.json").then((res) => res.json()).then((data)=> {
  let decodedCookie = decodeURIComponent(document.cookie);
  let userNumber;
  decodedCookie = decodedCookie.split(";");
  for (let i = 0; i < decodedCookie.length; i++){
    let temp = decodedCookie[i].split("=");
    if (temp[0].trim() == "user_number") {
      userNumber = temp[1].trim();
    }
  }
  let drypt = async () => {
    userNumber = await decrypt_data(userNumber, '');
    document.getElementById("card-text-2").innerText = data["User_Data"][userNumber]["Date_Joined"];
    document.getElementById("card-text-4").innerText = data["User_Data"][userNumber]["Notes"].length;
    let task_counter = 0;
    for (let i = 0; i < data["User_Data"][userNumber]["To-do"].length; i++){
      let d = new Date();
      let temp = d.getFullYear();
      temp += '-0' + (d.getMonth()+1);
      temp += '-' + d.getDate();
      if (data["User_Data"][userNumber]["To-do"][i]["Date"] == temp)
      task_counter++;
    }
    document.getElementById("card-text-6").innerText = task_counter;

  }
  drypt();
})
// graveyard
graveyard = async () => {
    let decodedCookie = decodeURIComponent(document.cookie);
    let userNumber;
    decodedCookie = decodedCookie.split(";");
    for (let i = 0; i < decodedCookie.length; i++){
      let temp = decodedCookie[i].split("=");
      if (temp[0].trim() == "user_number") {
        userNumber = temp[1].trim();
      }
  }
  userNumber = await decrypt_data(userNumber, '');
  display = document.getElementById("2");
  fetch("../data/Data.json").then((res) => res.json()).then((recycle) => {
    Array.from(recycle["User_Data"][userNumber]["recycle"]).map((ele) => {
      let markUp =  `<div class="divi" style="background-image:url(../media/newNote.png);">
      <div class="topic">
          <img id="pin" src="../media/gravePin.png" alt="pin">
      </div>
      <div class="screen"><ul style="list-style-type:none;">`
      for (i = 0; i < ele["Tasks"].length; i++){
        markUp += `<li>${ele["Tasks"][i]}</li>`;
      }
      markUp += `</ul></div>
          <div class="control">
              <button onclick="">
              <a>
                  <img title='edit the task' src="../media/edit.png" alt="loading image">
              </a>
              </button>
              <button onclick="">
                  <img title='copy the task to clipboard' src="../media/share.png" alt="loading image">
              </button>
              <button onclick="">
                  <a  style='text-decoration:none;'>
                      <img title='delete the task' src="../media/delete.png" alt="loading image">
                  </a>
              </button>
          </div>
      </div>
    </div>`;
      display.innerHTML += markUp;
  });
})
}
graveyard();