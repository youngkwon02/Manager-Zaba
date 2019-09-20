$(document).ready(function(){
    $('#searchBar').on('focus', function(){
        $('#searchBar').val('');
    })

    $('#searchBar').on('keyup', function(){
        var text = $('#searchBar').val();
        $.ajax({
            url: './searchAjax.php',
            type: 'POST',
            async: 'false',
            traditional: true,
            data: {
                "text" : text,
                "done" : 1
            },
            success: function(data) {
                // JSON data Parsing
                var result = JSON.parse(data);

                // result display controll]
                if(result.index > 0){
                    if(text === ''){
                        document.getElementById('result').style.display = 'none';
                    }else{
                        document.getElementById('result').style.display = 'grid';
                    }
                    // result_num print out
                    if(result.index-1 == 0){
                        var resultNum = '';
                    }else{
                        var resultNum = result.result0[1]+'님 외 '+(result.index-1)+'명';
                    }
                    $('#result_num').html(resultNum);
    
                    // result_name print out
                    var resultName = 'Name : '+result.result0[1];
                    $('#result_name').html(resultName);
    
                    // result_email print out
                    var resultEmail = 'E-mail : '+result.result0[0];
                    $('#result_email').html(resultEmail);
    
                    // result_birth print out
                    var resultBirth = 'Birth : '+result.result0[2];
                    $('#result_birth').html(resultBirth);
    
                    // result_nick print out
                    var resultNick = 'Nickname : '+result.result0[3];
                    $('#result_nick').html(resultNick);

                    // Send friend request
                    var sendButton = '<img onclick="sendFriendRequest()" src="./images/friendly.png" style="width: 50px; height: 50px">'
                    $('#sendRequest').html(sendButton);
                }else{
                    document.getElementById('result').style.display = 'none';
                }
            }
        });
    });

    var receiveDiv = document.getElementById('waitingReceiveRequest');
    var sendDiv = document.getElementById('waitingSendRequest');
    var isReceiveZero = receiveDiv.innerText === '받은 요청 : 0' ? true : false;
    var isSendZero = sendDiv.innerText === '보낸 요청 : 0' ? true : false;
    if(isReceiveZero === true){
        receiveDiv.style.display = 'none';
        sendDiv.style.gridColumnStart = '18';
        sendDiv.style.gridColumnEnd = '20';
    }
    if(isSendZero === true){
        sendDiv.style.display = 'none';
        receiveDiv.style.gridColumnStart = '18';
        receiveDiv.style.gridColumnEnd = '20';
    }

});

function sendFriendRequest(){
    var responser = document.getElementById('result_name').innerHTML;
    responser = "'"+responser.substring(7, responser.length)+"'";
    var message = "Are you sure you're sending a friend request to "+responser;
    var result = confirm(message);
    
    if(result === true){
        var responserEmail = document.getElementById('result_email').innerHTML;
        responserEmail = responserEmail.substring(9, responserEmail.length);
        window.location.href = "./sendFriendRequestAction.php?responserEmail="+responserEmail;
    }
}