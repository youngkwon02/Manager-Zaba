var sign_up = function() {
    var signin = document.getElementById('sign_board');
    var signupForm = document.getElementById('div_signup_form');
    if(signin.style.display == 'none') {
        signin.style.display = 'block';
        signupForm.style.display = 'none';
        document.getElementById('sign_up').style.display = 'block';
    } else {
        signin.style.display = 'none';
        signupForm.style.display = 'block';
        document.getElementById('sign_up').style.display = 'none';
    }
}

var send_form = function() {
    var email = $("#signup_email").val();
    var password = $("#signup_password").val();
    var passck = $("#signup_password_check").val();
    var name = $("#signup_name").val();
    var birth = $("#signup_birth").val();
    $.ajax({
        url: "signupAction.php",
        type: "POST",
        async: false,
        data: {
            "done" : 1,
            "signup_email" : email,
            "signup_password" : password,
            "signup_password_check" : passck,
            "signup_name" : name,
            "signup_birth" : birth
        },
        success: function(data) {
            console.log('Ajax: Data_Sended');
            console.log(data);
            var parsedData = JSON.parse(data);
            if(parsedData.isSuccess === 1) {
                sign_up();
            } else {
                var arr = document.getElementsByClassName('div_error');
                for(var i = 0; i<5; i++) {
                    arr[i].innerHTML = '';
                }
                if(parsedData.name_error != '\n'){
                    arr[0].innerHTML = parsedData.name_error;
                }
                if(parsedData.birth_error != '\n'){
                    arr[1].innerHTML = parsedData.birth_error;
                }
                if(parsedData.email_error != '\n'){
                    arr[2].innerHTML = parsedData.email_error;
                }
                if(parsedData.passwd_error != '\n'){
                    arr[3].innerHTML = parsedData.passwd_error;
                }
                if(parsedData.passwdck_error != '\n'){
                    arr[4].innerHTML = parsedData.passwdck_error;
                }
            }
        }
    })
}
