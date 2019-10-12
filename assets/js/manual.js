function navMove(section){
    window.location.href="./manualSectionSetting.php?section="+section;
}

function backPage(section){
    window.location.href="./manualPageMoveAction.php?method=back&section="+section;
}

function nextPage(section){
    window.location.href="./manualPageMoveAction.php?method=next&section="+section;    
}