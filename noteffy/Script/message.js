function message(msg,type){
    console.log("hello world");
    let container = document.createElement("div");
    container.className = type;
    let content = document.createElement("div");
    content.id = "content";
    content.innerText = msg;

    document.body.insertBefore(container,document.body.firstChild);
    container.appendChild(content);
    setTimeout(()=>{
        console.log("hello");
        container.remove();
    },1000);
    return;
}