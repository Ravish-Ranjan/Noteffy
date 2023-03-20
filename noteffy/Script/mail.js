http = 

console.log("hello world");
const hostname = '127.0.0.1';
const test = readFileSync("./Script/test.js");

const server = createServer((req,res)=>{
    res.statusCode = 200;
    res.setHeader("Content-Type","text/HTML");
    res.end(test);
})
server.listen(3000,hostname,()=>{
    console.log("the server is running");
})

