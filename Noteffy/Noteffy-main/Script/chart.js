async function decrypt_data(enc_data) {
  let loc = window.location.href.split('/HTML/chart.html');
  let resp = await fetch(loc[0] + '/php/encrypt_cookie.php?' + (new URLSearchParams({ value: enc_data })), { method: 'GET', mode: 'cors' });
  resp = await resp.json();
  return resp['res'];
}
function $(id) {
  return document.getElementById(id);
}
function message(msg,type){ // this function gives user the error/success messages
  let container = document.createElement("div");
  container.className = type;
  let content = document.createElement("div");
  content.id = "content";
  content.innerText = msg;

  document.body.insertBefore(container,document.body.firstChild);
  container.appendChild(content);
  setTimeout(()=>{
      container.remove();
  },3000);
  return;
}
function clearCookies(){ // this function is used to clear the cookies of user to log him out
  let decodedCookie = decodeURIComponent(document.cookie);
  decodedCookie = decodedCookie.split(";");
  for (i = 0; i < decodedCookie.length; i++){
      let temp = decodedCookie[i].split("=");
      if (temp[0].trim() == "user") {
          console.log(temp[1]);
          document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          window.location.href = '../php/index.php';
      }
      if (temp[0].trim() == "user_number") {
          console.log(temp[1]);
          document.cookie = "user_number=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          window.location.href = '../php/index.php';
      }
  }
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
  let date = ["0"];
  let count = [0];
  
  for (i = 1; i <= jsonData.length; i++){
    if (!(date.includes(jsonData[i-1]['Date'])) && (user) == jsonData[i-1]["User"]) {
      date.push(jsonData[i-1]['Date']);
    }
    count[i] = 0;
  }
  for (i = 1; i <= jsonData.length; i++){
    if (date.includes(jsonData[i-1]['Date']) && jsonData[i-1]["User"] == (user)) {
      count[date.indexOf(jsonData[i-1]['Date'])]++;
    }
  }
  var obj = {
    "date": date,
    "count" :count
  }
  let sum = () => {
    let s = 0;
    count.forEach((ele) => {
      s += ele;
    })
    return s;
  }
  document.getElementById("score-number").innerText = sum()*100;
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
      $("user-avatar").setAttribute("src", "../media/uploads/logo" + pic['Users'][user]["Profile_Pic"] + "q.png");
      
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
        let temp = ele["Tasks"][i];
        temp = temp.replaceAll("\\", "");
          markUp += `<li>${temp}</li>`;
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
      if (changeRes.status == 200) {
        message("password updated", "message_success");
      }
      else
        message("password updated", "message_success");
        
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
    
    if (response['status']) {
      let infoContainer = $("info_container");
      let formChange = $("form_change");
      infoContainer.style.display = "block";
      formChange.style.display = "none";
      formChange.innerHTML = '';
      window.location.href = window.location.href;
      message("Profile pic changed successfully", "message_success");
    }
    else
      message("Error in updating profile picture", "message_failure");
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
<form action='../php/chart.php' method='post' enctype=multipart/form-data>
  <input type='file' name='avatar' value='upload'>
  <button value='upload' onclick='acceptAvatar(this.parentNode)'>upload</button>
</form>
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

  let response = await fetch(loc[0] + "/php/chart.php?" + (new URLSearchParams({ userName: `${username['enc']}` })), { method: "GET", mode: "cors" });
  while (response.status != 200) {
    console.log("hello");
  }
  response = await response.json();
  if (response['status'] == "success") {
    if (response['status'] == "success") {
      let infoContainer = $("info_container");
      let formChange = $("form_change");
      infoContainer.style.display = "block";
      formChange.style.display = "none";
      formChange.innerHTML = '';
      window.location.href = window.location.href;
      message("Name changed successfully", "message_success");
    }
    else
      message("Could not update the user name", "message_failure");
  }
}

function acceptAvatar(form) {
  let formdata = new FormData(form);
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let response = await fetch(form.action, { method: form.method, mode: "cors", body: formdata });
    response = await response.json();
    if (response['status']) {
      $("pic").src = `../media/uploads/${response['name']}`;
    }
    else
      message("Error uploading the image", "message_failure");
  })
}
async function deleteAccount() {
  let loc = window.location.href.split("/HTML/chart.html");
  let response = await fetch(loc[0] + "/php/chart.php?" + (new URLSearchParams({ delete: true })), { method: "GET", mode: "cors" });
  response = await response.json();
  console.log(response);
  if (response['data_status'] || response['details_status'] || response['organization_status']) {
    clearCookies();
  }
}