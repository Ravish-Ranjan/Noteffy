function calc_completed_task(jsonData) {
  let date = [];
  let count = [0];
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
    if (date.includes(jsonData[i]['Date']) && jsonData[i]["User"])
      count[date.indexOf(jsonData[i]['Date'])]++;
  }
  var obj = {
    "date": date,
    "count" :count
  }
  return obj;
}


const ctx = document.getElementById('context');
setTimeout(()=>{
  document.getElementById("load").remove();
  ctx.style.display = "block";
},4000)
fetch("../data/task.json").then((res) => res.json()).then((json) => {
  let obj = calc_completed_task(json);
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: obj.date,
      datasets: [{
        label: 'Number of tasks completed',
        data: obj.count,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        },
        x: {
          beginAtZero: true
        }
      }
    }
  });
})