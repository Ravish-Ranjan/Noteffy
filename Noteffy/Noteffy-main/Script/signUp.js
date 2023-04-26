
function transitionFunction(){ // this function toggles the signIn/signUp function front end
    if(document.getElementById('toggle-checkbox').checked){
        document.getElementById("title-heading").innerHTML="Sign up";
        document.getElementById("sign-in-bg").style.backgroundImage = "url(../media/bg2.png)";
        document.getElementById("mascot-1").src="../media/goldmascot1.png";
        document.getElementById("mascot-1").style.animation = 'none';
        document.getElementById("mascot-1").offsetHeight; 
        document.getElementById("mascot-1").style.animation = null;
        document.getElementById("form-container1").style.display = "none";
        document.getElementById("form-container2").style.display = "flex";
    } 
    else{
        document.getElementById("title-heading").innerHTML="Sign in";
        document.getElementById("sign-in-bg").style.backgroundImage = "url(../media/bg1.png)";
        document.getElementById("mascot-1").src="../media/goldbody2.png";
        document.getElementById("mascot-1").style.animation = 'none';
        document.getElementById("mascot-1").offsetHeight; 
        document.getElementById("mascot-1").style.animation = null;
        document.getElementById("form-container1").style.display = "flex";
        document.getElementById("form-container2").style.display = "none";
    }      
}

function config(){ // this function gives different messages for user to understand the states
    const queries = new URLSearchParams(window.location.search);
    let code = queries.get("err"),act = queries.get("activity");
    //For error messages
    switch(code){
    case('uid'):
        message("Username does not exist","error");break;
    case 'upwd':
        message("The password entered was incorrect","error");break;
    case 'invm':
        message("The mail you used was invalid","error");break;
    case 'pnm':
        message("The passwords you entered didn't match","error");break;
    case 'iotp':
        message("The OTP you entered was incorrect","error");break;
    default:
        break;
    }

    //For directing signup/signin
    if(act=='signup'){
        //Subject to change if styling changes
        document.getElementById('toggle-checkbox').checked = true;
        transitionFunction();
    }
    else{}

    //For caching correct data
    if(queries.get("mail")){
        document.querySelectorAll(".form2-input")[0].value = queries.get("mail");
    }
    
}
// flag is 1 if user is trying to signUp and 0 if user is trying to signIn
function check_in_log() {
    const queries = new URLSearchParams(window.location.search);
    flag = queries.get("flag");
    console.log(1==flag);
    if (flag == 1) {
        document.getElementById('toggle-checkbox').checked = true;
        transitionFunction();
    }
    else {
        document.getElementById('toggle-checkbox').checked = false;
        console.log(flag);
        transitionFunction();
    }
}
function concatOTP(){
    let otp = "";
    let digits = document.querySelectorAll("#otpform ul li input");
    digits.forEach(
        (digit) =>{
            otp = otp.concat(digit.value);
        }
    );
    document.querySelectorAll("#otpform input[type = \"hidden\"]")[0].value = otp;
    return true;
}
function nextDig(ele){
    if(ele.value!=""){
        ele.parentElement.nextSibling.nextSibling.children[0].focus();
    }
}
function validatesignup(ele){
    var mail = document.querySelector("input[name='Email']").value;
    var pwd = document.querySelector("input[name='Password']").value;var pwd2 = document.querySelector("input[name='Password1']").value;

    if(pwd!=pwd2){
        message("Passwords do not match","error");return false;
    }

    return true;
}