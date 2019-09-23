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
        var filter = document.getElementById('all').style.color == 'rgba(0, 0, 255, 0.75)' ? 'all' : 'recent';
        if(text != ''){
            $.ajax({
                url: 'searchFriendList.php',
                type: 'POST',
                async: 'false',
                traditional: true,
                data: {
                    "text" : text,
                    "filter" : filter,
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
                            inner += '<div class="eleEtc">···</div>';
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

function filter(filter){
    if(filter === 'recent'){
        document.getElementById('recent').style.color = 'rgba(0, 0, 255, .75)';
        document.getElementById('all').style.color = 'rgba(0, 0, 0, .4)'; 
        window.location.href = "./friendListFilter.php?FILTER=recent";
    }else{
        document.getElementById('all').style.color = 'rgba(0, 0, 255, .75)';
        document.getElementById('recent').style.color = 'rgba(0, 0, 0, .4)';
        window.location.href = "./friendListFilter.php?FILTER=all";
    }
}

function filterColor(filter){
    if(filter === 'recent'){
        document.getElementById('recent').style.color = 'rgba(0, 0, 255, .75)';
        document.getElementById('all').style.color = 'rgba(0, 0, 0, .4)';
    }else{
        document.getElementById('all').style.color = 'rgba(0, 0, 255, .75)';
        document.getElementById('recent').style.color = 'rgba(0, 0, 0, .4)';
    }
}

function etcFunc(eleIndex){
    var eleFunc = document.getElementsByClassName('eleFunc');

    if(eleFunc[eleIndex].style.display === 'grid'){
        eleFunc[eleIndex].style.display = 'none';
    }else{
        eleFunc[eleIndex].style.display = 'grid';
    }
}

function sendMessage(eleIndex){

}

function setCalendarFilter(eleIndex){
    var targetName = document.getElementsByClassName('eleName')[eleIndex].innerText;

    var target = confirm(targetName+" 님의 일정을 표시하지 않겠습니까?");    
    if(target === true){
        var targetEmail = document.getElementsByClassName('eleMail')[eleIndex].innerText;
        window.location.href = "./setCalendarFilterAction.php?targetEmail="+targetEmail+"&targetName="+targetName;
    }
}

function removeCalendarFilter(eleIndex){
    var targetName = document.getElementsByClassName('eleName')[eleIndex].innerText;

    var target = confirm(targetName+" 님의 일정을 표시하시겠습니까?");    
    if(target === true){
        var targetEmail = document.getElementsByClassName('eleMail')[eleIndex].innerText;
        window.location.href = "./removeCalendarFilterAction.php?targetEmail="+targetEmail+"&targetName="+targetName;        
    }
}

function deleteFriend(eleIndex){
    var deleteName = document.getElementsByClassName('eleName')[eleIndex].innerText;
    var del = confirm(deleteName+" 님과 친구를 끊으시겠습니까?");
    
    if(del === true){
        var deleteEmail = document.getElementsByClassName('eleMail')[eleIndex].innerText;
        window.location.href = "./deleteFriendAction.php?deleteEmail="+deleteEmail+"&direction=friendList.php";    
    }

}