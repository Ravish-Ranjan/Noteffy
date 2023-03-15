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
  if (count[0] >= 10) {
    document.location.href = "https://www.youtube.com/watch?v=FJ3N_2r6R-o"
  }
  return obj;
}

function getUser() {
  let decodedCookie = decodeURIComponent(document.cookie);
  decodedCookie = decodedCookie.split(";");
  for (i = 0; i < decodedCookie.length; i++){
    if (decodedCookie[i].split("=")[0].trim() == "user") {
      document.getElementById("title").innerText = decodedCookie[i].split("=")[1];
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

const ctx = document.getElementById('context');
// setTimeout(()=>{
//   document.getElementById("load").remove();
//   ctx.style.display = "block";
// },4000)
fetch("../data/task.json").then((res) => res.json()).then((json) => {
  let obj = calc_completed_task(json);
  Chart.defaults.font.size = 20;
  Chart.defaults.font.weight = "bold";
  Chart.defaults.color = "white";
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