$(document).ready(function(){

    $('#searchBar').on('focus', function(){
        if($('#searchBar').val() === '친구 리스트 검색'){
            $('#searchBar').val('');
            document.getElementById('clear').innerText = null;        
        }
    });

    $('#searchBar').on('focusout', function(){
        if($('#searchBar').val() === ''){
            $('#searchBar').val('친구 리스트 검색');
        }
    });

    $('#searchBar').on('keyup', function(){
        if($('#searchBar').val() != '친구 리스트 검색' && $('#searchBar').val() != ''){
            document.getElementById('clear').innerText = "X";            
        }else if($('#searchBar').val() == ''){
            document.getElementById('clear').innerText = null;
        }

        var text = $('#searchBar').val();
        if(text != ''){
            $.ajax({
                url: 'searchFriendList.php',
                type: 'POST',
                async: 'false',
                traditional: true,
                data: {
                    "text" : text,
                    "filter" : 'all',
                    "done" : 1
                },
                success: function(data){
                    var obj = JSON.parse(data);
                    var listInner = document.getElementById('listInner');
                    var listEle = document.getElementsByClassName('listEle');
                    for(var i=0; i<listEle.length; i++){
                        listEle[i].style.display = 'grid';
                        listInner.style.overflowY = 'scroll';
                        if(i<obj.length){
                            var firstName = obj[i][1].substr(0, 1);
                            var inner = '<div class="eleImg">'+firstName+'</div>';
                            inner += '<div class="eleName">'+obj[i][1]+'</div>';
                            inner += '<div class="eleMail">'+obj[i][0]+'</div>';
                            inner += '<div class="eleEtc" onclick="sendMessage('+i+')">선택</div>';
                            listEle[i].innerHTML = inner
                        }
                    }

                    for(var i=obj.length; i<listEle.length; i++){
                        listEle[i].style.display = 'none';
                        listInner.style.overflowY = 'hidden';
                    }
                }
            });
        }else{
            var listInner = document.getElementById('listInner');
            var listEle = document.getElementsByClassName('listEle');
            for(var i=0; i<listEle.length; i++){
                listEle[i].style.display = 'grid';
                listInner.style.overflowY = 'scroll';
            }
        }
    });

    $('#clear').on('click', function(){
        $('#searchBar').val('');
        document.getElementById('clear').innerText = null;            
    });
});

function listScroll(){
    var listInner = document.getElementById('listInner');
    listInner.style.overflowY = 'scroll';
}


function sendMessage(eleIndex){
    var targetEmail = document.getElementsByClassName('eleMail')[eleIndex].innerText;
    window.location.href = "./messageWriteToFriend.php?targetEmail="+targetEmail;

}