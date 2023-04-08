async function decrypt_data(enc_data) {
  let loc = window.location.href.split('/HTML/chart.html');
  let resp = await fetch(loc[0] + '/php/encrypt_cookie.php?' + (new URLSearchParams({ value: enc_data })), { method: 'GET', mode: 'cors' });
  resp = await resp.json();
  return resp['res'];
}
function $(id) {
  return document.getElementById(id);
}
function hash_name($word,$lim){
  $exp = $word.split('');
  $tot = 0;
  $exp.forEach(($letter)=>{
      $tot+=$letter.charCodeAt(0);
  });
  return 1+($tot%$lim);
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
function calc_completed_task(jsonData,user) {
  let date = [];
  date[0] = "";
  let count = [1];
  
  for (i = 0; i < jsonData.length; i++){
    if (!(date.includes(jsonData[i]['Date'])) && (user) == jsonData[i]["User"]) {
      date.push(jsonData[i]['Date']);
    }
    count[i] = 0;
  }
  for (i = 0; i < jsonData.length; i++){
    if (date.includes(jsonData[i]['Date']) && jsonData[i]["User"] == (user)) {
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
  let name = await decrypt_data(getUser());
  let colors = ["red","teal","yellow"];
  document.getElementById("user-name").innerText = name;
  $("cur-user").innerText = name;
  let pic = await fetch("../data/Details.json");
  pic = await pic.json();

  let user = -1;
  let decodedCookie = decodeURIComponent(document.cookie);
  decodedCookie = decodedCookie.split(";");
  for (j = 0; j < decodedCookie.length; j++){
    c = decodedCookie[j].split("=");
    if (c[0].trim() == "user_number") {
      user = c[1];
    }
  }
  if (user != -1) {
    user = await decrypt_data(user);
    if (!pic['Users'][user]["Profile_Pic"])
      $("user-avatar").setAttribute("src", "../media/logo" + colors[hash_name(name, 3)] + "q.png");
    else 
      $("user-avatar").setAttribute("src", "../media/logo" + pic['Users'][user]["Profile_Pic"] + "q.png");
      
  }
}
userName(); //fetching the username 
const ctx = document.getElementById('context');

// fetching data for chart
fetch("../data/task.json").then((res) => res.json()).then(async (json) => {
  let user = -1;
  let decodedCookie = decodeURIComponent(document.cookie);
  decodedCookie = decodedCookie.split(";");
  for (j = 0; j < decodedCookie.length; j++){
    c = decodedCookie[j].split("=");
    if (c[0].trim() == "user_number") {
      user = c[1];
    }
  }
  if (user != -1) {
    user = await decrypt_data(user);
  }
  else
    return;
  let obj = calc_completed_task(json,user);
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
  display = document.getElementById("graveyard-space");
  fetch("../data/Data.json").then((res) => res.json()).then((recycle) => {
    Array.from(recycle["User_Data"][userNumber]["recycle"]).map((ele) => {
      let markUp =  
      `<div class="divi" style="background-image:url(../media/newNote.png);">
        <div class="topic">
          <img id="pin" src="../media/gravePin.png" alt="pin">
        </div>
        <div class="screen"><ul style="list-style-type:none;">`
        for (i = 0; i < ele["Tasks"].length; i++){
          markUp += `<li>${ele["Tasks"][i]}</li>`;
        }
        markUp += `</ul></div>
        </div>
      </div>`;
      display.innerHTML += markUp;
  });
})
}
graveyard();

// change password
async function changePassword(form) {
  let loc = window.location.href.split("/HTML/chart.html");
  let oldPass = form['oldpass'].value;
  let newPass1 = form['newpass1'].value;
  let newPass = form['newpass2'].value;
  let btn = form['submit']
  let userName = await decrypt_data(getUser());
  if (newPass1 == newPass) {
    oldPass = await fetch(loc[0] + "/php/encrypt_cookie.php?" + (new URLSearchParams({ encrypt: `${oldPass}`, key: userName.padEnd(32, "#") })));
    oldPass = await oldPass.json();

    let response = await fetch(loc[0] + "/php/chart.php?" + (new URLSearchParams({ pass: oldPass['enc'] })), { method: "GET", mode: "cors" });
    response = await response.json();
    let status = await decrypt_data(response['status']);
    if (status== "success" && btn.innerText == "Check Password") {
      btn.innerText = "Change Password";
      btn.style.backgroundColor = "lime";
    }
    else if (btn.innerText != "Check Password") {
      newPass = await fetch(loc[0] + "/php/encrypt_cookie.php?" + (new URLSearchParams({ encrypt: `${newPass}`, key: userName.padEnd(32, "#") })));
      newPass = await newPass.json();

      let changeRes = await fetch(loc[0] + "/php/chart.php?" + (new URLSearchParams({ new_pass: newPass['enc'],old_pass:oldPass['enc'] })), { method: "GET", mode: "cors" });
      changeRes = await changeRes.json();
      let infoContainer = $("info_container");
      let formChange = $("form_change");
      infoContainer.style.display = "block";
      formChange.style.display = "none";
      formChange.innerHTML = '';
    }
    else {
      setTimeout(() => {
        btn.style.backgroundColor = "black";
        form['oldpass'].style.border = "none";
      },3000)
      btn.style.backgroundColor = "orange";
      form['oldpass'].style.border = "2px solid red";
    }
  }
  else {
    setTimeout(() => {
      btn.style.backgroundColor = "black";
      form['oldpass'].style.border = "none";
    },3000)
    btn.style.backgroundColor = "orange";
    form['newpass2'].style.border = "2px solid red";
  }
}
function generatePassForm() {
  let infoContainer = $("info_container");
  let formChange = $("form_change");
  infoContainer.style.display = "none";
  formChange.style.display = "block";
  formChange.innerHTML += `<form onsubmit="event.preventDefault()" id='passChange'>
  <label>Old Password</label>
  <input type="password" name="oldpass" required>
  <label>New Password</label>
  <input type="password" name="newpass1" required>
  <label>Confirm New Password</label>
  <input type="password" name="newpass2" required>
  <button value="change" name='submit' onclick="changePassword(this.parentNode);" class="btn">Check Password</button>
  </form>`
  }
  
  async function changeAvatar(form) {
    let loc = window.location.href.split("/HTML/chart.html");
    console.log($("pic").src);
    let response = await fetch(loc[0] + "/php/chart.php?" + (new URLSearchParams({ img: `${$("pic").src}` })), { method: "GET", mode: "cors" });
    response = await response.json();
    console.log(response['status']);
    let infoContainer = $("info_container");
    let formChange = $("form_change");
    infoContainer.style.display = "block";
    formChange.style.display = "none";
    formChange.innerHTML = '';
    window.location.href = "../php/main.php";
  }
  function generatePicDiv() {
    let infoContainer = $("info_container");
    let formChange = $("form_change");
    infoContainer.style.display = "none";
    formChange.style.display = "block";
    let obj = {
    iter: 0,
    pictures : ["red", "teal", "yellow"]
  }
  
  
  formChange.innerHTML = `<div id="images">
<div id='prev'>&#10094;</div>
<img src="../media/logoredq.png" id='pic' name='pic'>
  <div id='next'>&#10095;</div>
</div>
<center><button class="btn" onclick="changeAvatar()">Change</button></center>
 `
  $("prev").addEventListener("click", () => {
    let pic = $("pic");
    if (obj.iter-1 != -1) {
      obj.iter = (obj.iter - 1) % obj.pictures.length;
    }
    else
    obj.iter = 2;
    pic.src = `../media/logo${obj.pictures[obj.iter]}q.png`;
  })
  $("next").addEventListener("click", () => {
    let pic = $("pic");
    obj.iter = (obj.iter + 1) % obj.pictures.length;
    pic.src = `../media/logo${obj.pictures[obj.iter]}q.png`;
  })
}
function generateUserNameForm() {
  let infoContainer = $("info_container");
  let formChange = $("form_change");
  infoContainer.style.display = "none";
  formChange.style.display = "block";
  formChange.innerHTML += `<form onsubmit="event.preventDefault()" id='passChange'>
  <label>Enter New User Name</label>
  <input type="text" name="UserName" required>
  <button value="change" name='submit' onclick="changeUserName(this.parentNode)" class="btn">Change UserName</button>
  </form>`
}
async function changeUserName(form) {
  let loc = window.location.href.split("/HTML/chart.html");

  let username = await fetch(loc[0] + "/php/encrypt_cookie.php?" +(new URLSearchParams({ encrypt: form['UserName'].value,key:"" })), { method: "GET", mode: "cors" })
  username = await username.json();

  let response = await fetch(loc[0] + "/php/chart.php?" +(new URLSearchParams({ userName: `${username['enc']}` })), { method: "GET", mode: "cors" });
  response = await response.json();
}