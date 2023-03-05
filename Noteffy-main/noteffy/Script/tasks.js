function getTasks(tasks) {
    let text = document.getElementById("tasks" + tasks);
    let ul = text.firstChild;
    let temp = ""+document.getElementById("title"+tasks).innerText+"\n";
    for (i = 0; i < ul.childNodes.length; i++){
        if (ul.childNodes[i].innerText != undefined) {
            temp += ul.childNodes[i].innerText+"\n";
        }
    }
    navigator.clipboard.writeText(temp);
    message("copied to clipboard", "message_success");
}