$(document).ready(function(){
    $('#messageSearch').on('focus', function(){
        if(document.getElementById('messageSearch').value == 'Search message'){
            document.getElementById('messageSearch').value = '';
        }
    });

    $('#allCheck').on('change', function(){
        var allCheck = document.getElementById('allCheck');
        var checkbox = document.getElementsByClassName('checkbox');
        if(allCheck.checked === true){
            for(var i = 0; i < checkbox.length; i++){
                checkbox[i].checked = true;
            }
        }else{
            for(var i = 0; i < checkbox.length; i++){
                checkbox[i].checked = false;
            }
        }
    });
});

function sendMessage(eleIndex){
    var targetEmail = document.getElementsByClassName('target')[eleIndex-1].innerText;
    window.location.href = "./messageWriteToFriend.php?targetEmail="+targetEmail;
}

function readMessage(messageSeq){
    window.location.href="messageReadAction.php?messageSeq="+messageSeq;
}

function friendSearch(){
    window.location.href="./receiverSearch.php";
}

function writeMessage(){
    window.location.href="./writeMessage.php";
}

function allMessageBox(){
    window.location.href="./allMessage.php";
}

function changeSelect(func){
    window.location.href="changeSelect.php?func="+func;
}

function selectDelete(page){
    var conf = confirm("선택하신 편지를 삭제하시겠습니까?\n(상대방에게는 삭제되지 않습니다.)");
    if(conf === true){
        var targetBoxIndexArr = [];
        var checkboxNum = document.getElementsByClassName('checkbox');
        checkboxNum = checkboxNum.length;

        var i = (20*(page-1)) + 1;
        for(var k = 0; k<checkboxNum; k++){
            var id = "check"+i;
            if(document.getElementById(id).checked === true){
                targetBoxIndexArr.push(i);
            }
            i++;
        }
        window.location.href="./messageManagement.php?method=selectDelete&target="+targetBoxIndexArr;
    }
}

function selectRecover(page){
    var conf = confirm("선택하신 편지를 복원하시겠습니까?");
    if(conf === true){
        var targetBoxIndexArr = [];
        var checkboxNum = document.getElementsByClassName('checkbox');
        checkboxNum = checkboxNum.length;

        var i = (20*(page-1)) + 1;
        for(var k = 0; k<checkboxNum; k++){
            var id = "check"+i;
            if(document.getElementById(id).checked === true){
                targetBoxIndexArr.push(i);
            }
            i++;
        }
        window.location.href="./messageManagement.php?method=selectRecover&target="+targetBoxIndexArr;
    }
}

function selectRemove(page){
    var conf = confirm("선택하신 편지를 완전히 삭제하시겠습니까?");
    if(conf === true){
        var targetBoxIndexArr = [];
        var checkboxNum = document.getElementsByClassName('checkbox');
        checkboxNum = checkboxNum.length;

        var i = (20*(page-1)) + 1;
        for(var k = 0; k<checkboxNum; k++){
            var id = "check"+i;
            if(document.getElementById(id).checked === true){
                targetBoxIndexArr.push(i);
            }
            i++;
        }
        window.location.href="./messageManagement.php?method=selectRemove&target="+targetBoxIndexArr;
    }
}

function selectImportant(page){
    var conf = confirm("선택하신 편지를 중요편지로 설정하시겠습니까?");
    if(conf === true){
        var targetBoxIndexArr = [];
        var checkboxNum = document.getElementsByClassName('checkbox');
        checkboxNum = checkboxNum.length;

        var i = (20*(page-1)) + 1;
        for(var k = 0; k<checkboxNum; k++){
            var id = "check"+i;
            if(document.getElementById(id).checked === true){
                targetBoxIndexArr.push(i);
            }
            i++;
        }
        window.location.href="./messageManagement.php?method=selectImportant&target="+targetBoxIndexArr;
    }
}

function allDelete(){
    var conf = confirm("현재 편지함의 모든 편지를 삭제하시겠습니까?");
    if(conf === true){
        window.location.href="messageManagement.php?method=allDelete";
    }
}

function allRemove(){
    var conf = confirm("현재 편지함의 모든 편지를 완전히 삭제하시겠습니까?");
    if(conf === true){
        window.location.href="messageManagement.php?method=allRemove";
    }
}

function toggleImportant(index){
    window.location.href="messageManagement.php?method=toggleImportant&target="+index;
}

function navigateTo(tab){
    if(tab === 'mailBox'){
        window.location.href="./allMessage.php";
    }else if(tab === 'writeMessage'){
        window.location.href="./writeMessage.php";
    }else{
        window.location.href="./home.php";
    }
}