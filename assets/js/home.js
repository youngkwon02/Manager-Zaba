function click_menu(x){
    x.classList.toggle("change");
    var menuTab = document.getElementById('menuTab');
    var header = document.getElementById('header');
    var todo = document.getElementById('todo');
    var todoP = document.getElementById('todoP');
    var todoBox = document.getElementById('todoBox');
    var memo = document.getElementById('memo');
    var memoText = document.getElementById('memoText');
    var calendar = document.getElementById('calendar');
    if(menuTab.style.display !== 'block') {
        menuTab.style.display = 'block';
        // For modify width when click menu bar
        header.style.width = "85%";
        todo.style.width = "85%";
        todoP.style.gridColumnStart='1';
        todoP.style.gridColumnEnd='11';
        todoBox.style.width = "85%";
        memo.style.width = "85%";
        memoText.style.width="400px";
        calendar.style.width = "85%";
    } else {
        menuTab.style.display = 'none';
        // For modify width when click menu bar
        header.style.width = "100%";
        todo.style.width = "100%";
        todoP.style.gridColumnStart='2';
        todoP.style.gridColumnEnd='10';
        todoBox.style.width = "100%";
        memo.style.width = "100%";
        memoText.style.width="500px";
        calendar.style.width = "100%";
    }
}

// 모두 parameter를 num으로 했으나, 하나의 num이 여러 line을 가질경우 문제가 발생.
// line을 계산해서 parameter로 line을 넘김으로 해결

function resize_todo(num) {
    var box = document.getElementById('todoBox');
    var k = 300 + (num-4)*50;
    box.style.height = k+'px';
}

function resize_todoP(num) {
    var pTag = document.getElementById('todoP');

    if(num > 4){
        var p = 148 + (num-4)*50;
    }else {
        var p =148;
    }    
    pTag.style.height = p+'px';
}

function resize_todoNote(num) {
    var note = document.getElementById('listTab'); 
    var k = 480 + (num-15)*23.25;
    note.style.height = k+'px';
}

function save_memo() {
    var title = document.getElementById('memoTitle');
    var text = document.getElementById('memoText');
    $.ajax({
        url: "saveMemoAction.php",
        type: "POST",
        async: false,
        data: {
            "done" : 1,
            "title" : title,
            "text" : text
        },
        success: function(data) {
        }
    })
}