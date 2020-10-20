$(document).ready(function () {

    var temp = document.getElementsByClassName('menu-a')
    if (location.pathname.split('/')[1] == 'project') {
        temp[0].style.color = '#fff'

    } else if (location.pathname.split('/')[1] == 'invoice') {
        temp[1].style.color = '#fff'
        temp[2].style.color = '#fff'
    } else if (location.pathname.split('/')[1] == 'purchase') {
        temp[1].style.color = '#fff'
        temp[3].style.color = '#fff'
    } else if (location.pathname.split('/')[1] == 'todo') {
        temp[4].style.color = '#fff'
    }
     else if (location.pathname.split('/')[1] == 'calendar') {
        temp[5].style.color = '#fff'
    } else if (location.pathname.split('/')[1] == 'leaveDay'||location.pathname.split('/')[1] == 'leaveDayBreak'||location.pathname.split('/')[1] == 'leaveDayApply') {
        temp[6].style.color = '#fff'
    } else if (location.pathname.split('/')[1] == 'businessCar') {
        temp[7].style.color = '#fff'
    } else if (location.pathname.split('/')[1] == 'p-index'||location.pathname.split('/')[1] == 'p') {
        temp[8].style.color = '#fff'
    }
});
