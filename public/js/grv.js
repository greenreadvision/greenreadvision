$(window).load(function () {
    $('.menu').css("left", "0");
});
$(document).ready(function () {
    var project =document.getElementById('menu-project')

    //款項相關
    var menu_money_manager =document.getElementById('menu-money-manager')
    var purchase =document.getElementById('menu-purchase')
    var invoice =document.getElementById('menu-invoice')
    var service =document.getElementById('menu-service')

    //貨物相關
    var good = document.getElementById('menu-goods')
    var reserve = document.getElementById('menu-reserve')

    
    var estimate = document.getElementById('menu-Estimate')
    var businessTrip = document.getElementById('menu-BusinessTrip')
    
    
    var seal = document.getElementById('menu-seal')
    var projectSOP = document.getElementById('menu-projectSOP')
    var calendar =document.getElementById('menu-calendar')
    var leaveDay =document.getElementById('menu-leaveday')
    
    var photo =document.getElementById('menu-photo')

    if (location.pathname.split('/')[1] == 'project') {
        project.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'purchase') {
        purchase.style.backgroundColor = '#f7675a'
        menu_money_manager.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'invoice') {
        invoice.style.backgroundColor = '#f7675a'
        menu_money_manager.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'service') {
        service.style.backgroundColor = '#f7675a'
        menu_money_manager.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'businessTrip') {
        businessTrip.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'goods') {
        good.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'estimate') {
        estimate.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'seal') {
        seal.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'projectSOP') {
        projectSOP.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'calendar') {
        calendar.style.backgroundColor = '#f7675a'
    } else if (location.pathname.split('/')[1] == 'reserve') {
        reserve.style.backgroundColor = '#f7675a'  
    } else if (location.pathname.split('/')[1] == 'leaveDay' || location.pathname.split('/')[1] == 'leaveDayBreak' || location.pathname.split('/')[1] == 'leaveDayApply') {
        leaveDay.style.backgroundColor = '#f7675a'
    }

});

let arrow = document.querySelectorAll(".arrow");
for(var i = 0 ; i<arrow.length;i++){
    console.log(arrow[i].classList)
    arrow[i].addEventListener("click",function(){
        arrow[i].classList.toggle('icon-link')
    });
}

