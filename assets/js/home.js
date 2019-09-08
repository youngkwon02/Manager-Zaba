function click_menu(x){
    x.classList.toggle("change");
    var menuTab = document.getElementById('menuTab');
    var header = document.getElementById('header');
    if(menuTab.style.display !== 'block') {
        menuTab.style.display = 'block';
        // For modify width when click menu bar
        header.style.width = "72%";
    } else {
        menuTab.style.display = 'none';
        // For modify width when click menu bar
        header.style.width = "100%";
    }
}
