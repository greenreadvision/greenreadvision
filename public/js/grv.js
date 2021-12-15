$(window).load(function () {
    $('.menu').css("left", "0");
});
$(document).ready(function () {
    var project =document.getElementById('menu-project')
    var purchase =document.getElementById('menu-purchase')
    var invoice =document.getElementById('menu-invoice')
    var goods =document.getElementById('menu-goods')
    var todo =document.getElementById('menu-todo')
    var calendar =document.getElementById('menu-calendar')
    var leaveDay =document.getElementById('menu-leaveday')
    var photo =document.getElementById('menu-photo')

    if (location.pathname.split('/')[1] == 'project') {
        project.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'purchase') {
        purchase.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'invoice') {
        invoice.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'goods') {
        goods.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'todo') {
        todo.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'calendar') {
        calendar.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'leaveDay' || location.pathname.split('/')[1] == 'leaveDayBreak' || location.pathname.split('/')[1] == 'leaveDayApply') {
        leaveDay.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'businessCar') {
        // temp[7].style.color = '#fff'
    } else if (location.pathname.split('/')[1] == 'p-index' || location.pathname.split('/')[1] == 'p') {
        photo.style.backgroundColor = '#f7675a'
    }

});
