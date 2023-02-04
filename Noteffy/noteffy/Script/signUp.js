function transitionFunction(){
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