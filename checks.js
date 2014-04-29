var doSubmit = true;
$("#password2").keyup(function(){
    doSubmit = false;
    $("#createUser").submit();
});
$("#createUser").submit(function() {

    if (checkMail($("#mail").val())){
        var password = checkPasswords($("#password1").val(), $("#password2").val());
        switch (password) {
            case 1:
                $("#matches").text("");
                if (doSubmit)
                    return true;
                else {
                    doSubmit = true;
                    return false;
                }
                break;
            case 2:
                $("#matches").text("Your password has to be at least 8 characters");
                return false;
                break;
            case 3:
                $("#matches").text("Passwords do not match");
                return false;
                break;
            default:
                $("#matches").text("An unknown error has occured, please try again later");
                return false;
        }
        return false;
    } else {
        $("#matches").text("Please correct your email");
        return false;
    }
    
});
function checkPasswords(pass1, pass2) {
    if (pass1 == pass2) {
        if (pass1.length >= 8) { //Passwords match and are allowed
            return 1;
        } else { //Passwords are not the right length
            return 2;
        }
    } else { //Password do not match
        return 3;
    }
}
function checkMail(mail) {
    if(mail.indexOf(".") != -1 && mail.indexOf("@") != -1 )
        return true; //Mail is probably valid
    return false; //Mail is not valid
}