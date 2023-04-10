async function api(){
    let response = await fetch("data/Details.json");
    response = await response.json();
    let rand = Math.floor(Math.random() * 2);
    document.getElementById("content").innerText = response["Users"][rand]["Email"];
}
api();