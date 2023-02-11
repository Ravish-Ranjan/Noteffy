function transitionFunction(){ // this function toggles the signIn/signUp function front end
    if(document.getElementById('toggle-checkbox').checked){
        document.getElementById("title-heading").innerHTML="Sign up";
        document.getElementById("sign-in-bg").style.backgroundImage = "url(../media/bg2.png)";
        document.getElementById("mascot-1").src="../media/goldmascot1.png";
        document.getElementById("mascot-1").style.animation = 'none';
        document.getElementById("mascot-1").offsetHeight; 
        document.getElementById("mascot-1").style.animation = null;
        document.getElementById("form-container1").style.display = "none";
        document.getElementById("form-container2").style.display = "block";
    } 
    else{
        document.getElementById("title-heading").innerHTML="Sign in";
        document.getElementById("sign-in-bg").style.backgroundImage = "url(../media/bg1.png)";
        document.getElementById("mascot-1").src="../media/goldbody2.png";
        document.getElementById("mascot-1").style.animation = 'none';
        document.getElementById("mascot-1").offsetHeight; 
        document.getElementById("mascot-1").style.animation = null;
        document.getElementById("form-container1").style.display = "block";
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
    if(queries.get("name")){
        document.querySelectorAll(".form1-input")[0].value = queries.get("name");
    }
    
}
