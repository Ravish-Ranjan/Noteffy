

function generateOTP(email,usern,pwd,pwd2){
    var params = {
        'op':'generate',
        'Usern':usern,
        'Email':email
    }
    var options = {
        method:"GET",
        mode:"cors"
    }
    fetch("../php/otpapi.php?"+ (new URLSearchParams(params).toString()),options);
    document.querySelector("#form-container2").innerHTML = `\\\
    <div id="otpform">\\\
    <label>Enter OTP</label>\
    <ul>\
    <li><input placeholder="Enter" type="text" oninput = "nextDig(this)" maxlength = 1 name="OTP1" required><br><br></li>\
    <li><input placeholder="Enter" type="text" oninput = "nextDig(this)" maxlength = 1 name="OTP2" required><br><br></li>\
    <li><input placeholder="Enter" type="text" oninput = "nextDig(this)" maxlength = 1 name="OTP3" required><br><br></li>\
    <li><input placeholder="Enter" type="text" maxlength = 1 name="OTP4" required><br><br></li></ul>\
    <input type = "hidden" name = "OTP"></input>\
    <button type "submit" onclick = "concatOTP();validateOTP('${usern}','${email}','${pwd}','${pwd2}');">Submit</button>\
    </button>\
    `;
    return false;
}
function deleteOTP(username){
    var loc = window.location.href.split('HTML/signUp.html')[0];
    fetch(loc+"php/otpapi.php?"+(new URLSearchParams({'op':'delete','Uname':username})),{
        method:"GET",mode:"cors"
    }).then((dat)=>dat.json()).then((jsond)=>{
        if(jsond['Message']=="deletion successful"){
            console.log("Delete successful");
        }else{
            console.log("Delete unsuccesful");
        }
    });
}
function validateOTP(usern,email,pwd,pwd2){
    var otp = document.querySelector("#otpform input[type='hidden']").value;
    var params = {
        'op':'validate',
        'Uname':usern,
        'Email':email,
        'OTP':otp
    }
    var options = {
        method:"GET",
        mode:"cors"
    }
    var loc = window.location.href.split('HTML/signUp.html')[0];
    var redirect = "";
    fetch(loc+"php/otpapi.php?"+ (new URLSearchParams(params).toString()),options).then((res)=>{
        return res.json();
    }).then((data)=>{
        if(data['Message']=='otp matched'){
            console.log(loc+"php/main.php");
            //Set a GET variable that indicates that main has to recieve JSON like API 
            fetch(loc+"php/main.php?signup=true",{
                method:'POST',
                header:{
                    'Content-Type':'application/json'
                },
                body:JSON.stringify({
                    Username:usern,
                    Email:email,
                    Password:pwd,
                    Password1:pwd2
                })
        }).then((res)=>res.json()).then((data)=>{
            console.log(data);
            if(data['Message']=='failure'){
                console.log("Passwords dont match");
                deleteOTP(usern);
                window.location.href = "signUp.html?err=pnm&flag=1";
            }
            else if(data['Message']=='success'){
                console.log("Hit");
                deleteOTP(usern);
                window.location.href = "signUp.html?flag=0";
            }
        });
        }
        else if(data['Message']=='otp unmatched'){
            console.log("OTPs dont match");
            deleteOTP(usern);
            window.location.href = "signUp.html?err=iotp&flag=1";
        }
        // window.location.href = redirect;
    });
    return false;
}