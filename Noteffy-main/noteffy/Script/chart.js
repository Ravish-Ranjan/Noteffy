function calc_completed_task(jsonData) {
  let date = [];
  let count = [0];
  for (i = 0; i < jsonData.length; i++){
    if (!(date.includes(jsonData[i]['Date']))) {
      date.push(jsonData[i]['Date']);
    }
    count[i] = 0;
  }
  for (i = 0; i < jsonData.length; i++){
    if (date.includes(jsonData[i]['Date']))
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
          beginAtZero: false
        }
      }
    }
  });
})