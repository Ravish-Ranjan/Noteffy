function getTasks(tasks) {
    let text = document.getElementById("tasks" + tasks);
    let ul = text.firstChild;
    let temp = "*" + document.getElementById("title" + tasks).innerText + "*\n\n";
    for (i = 0; i < ul.childNodes.length; i++) {
        if (ul.childNodes[i].innerText != undefined) {
            temp += ul.childNodes[i].innerText + "\n";
        }
    }
    navigator.clipboard.writeText(temp);
    message("copied to clipboard", "message_success");
}
function removeTask_fromCookie(task_no, userNo) {
    let decodedCookie = decodeURIComponent(document.cookie);
    decodedCookie = decodedCookie.split(';');
    for (let i = 0; i < decodedCookie.length; i++) {
        const temp = decodedCookie[i].split('=')
        if (temp[0].trim() == 'comp_task') {
            let t = JSON.parse(temp[1]);
            console.log(t[userNo][task_no]);
        }
    }
}