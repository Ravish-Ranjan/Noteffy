function getContent(task_no) {
    let content = document.getElementById("content" + task_no);
    navigator.clipboard.writeText(content.innerText);
    message("coppied to clipboard", "message_success");
}