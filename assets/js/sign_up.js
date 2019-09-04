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
                alert('Sign up Success');
            } else {
                alert('Sign up Fail!');
            }
        }
    })
}
