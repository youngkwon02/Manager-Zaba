function makeListScroll(listName){
    var doc = document.getElementById(listName);
    doc.style.overflowY = 'scroll';
}

function acceptRequest(requesterEmail, responserEmail){
    window.location.href="./acceptRequestAction.php?requesterEmail="+requesterEmail+"&responserEmail="+responserEmail;
}

function rejectRequest(requesterEmail, responserEmail){
    window.location.href="./rejectRequestAction.php?requesterEmail="+requesterEmail+"&responserEmail="+responserEmail;
}

function cancelRequest(requesterEmail, responserEmail){
    window.location.href="./cancelRequestAction.php?requesterEmail="+requesterEmail+"&responserEmail="+responserEmail;
}