function generate(){
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
  for (let i = 0; i < divs.length-1; i++) {
      if (divs[i].style.display=="block") {
          document.getElementById("comp"+String(i+1)).style.display="block" ;
      }        
      else{
          document.getElementById("comp"+String(i+1)).style.display="none" ;
      }
  }
  chan(parseInt(tabname)+1);
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
  return document.getElementById("title").innerText = "Your user name";
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
document.getElementById("user-name").innerText = getUser();
const ctx = document.getElementById('context');
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