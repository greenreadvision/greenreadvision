$(window).load(function () {
    $('.menu').css("left", "0");
});
$(document).ready(function () {
    //專案相關
    var menu_project_manager =document.getElementById('menu-project-manager')
    var project =document.getElementById('menu-project')
    var seal = document.getElementById('menu-seal')
    var projectSOP = document.getElementById('menu-projectSOP')

    //款項相關
    var menu_money_manager =document.getElementById('menu-money-manager')
    var purchase =document.getElementById('menu-purchase')
    var invoice =document.getElementById('menu-invoice')
    var service =document.getElementById('menu-service')

    //貨物相關
    var menu_hardward_manager =document.getElementById('menu-hardward-manager')
    var good = document.getElementById('menu-goods')
    var reserve = document.getElementById('menu-reserve')

    //人事相關
    var menu_people_manager =document.getElementById('menu-people-manager')
    var leaveDay =document.getElementById('menu-leaveday')
    var businessTrip = document.getElementById('menu-BusinessTrip')


    var estimate = document.getElementById('menu-Estimate')
    var calendar =document.getElementById('menu-calendar')
    
    
    var photo =document.getElementById('menu-photo')
    if (location.pathname.split('/')[1] == 'project') {
        project.style.backgroundColor = '#666B8D'
        menu_project_manager.style.backgroundColor = '#666B8D'
        menu_project_manager.parentElement.classList.add('showMenu')
    } 
    else if (location.pathname.split('/')[1] == 'seal') {
        seal.style.backgroundColor = '#666B8D'
        menu_project_manager.style.backgroundColor = '#666B8D'
        menu_project_manager.parentElement.classList.add('showMenu')
    } 
    else if (location.pathname.split('/')[1] == 'projectSOP') {
        projectSOP.style.backgroundColor = '#666B8D'
        menu_project_manager.style.backgroundColor = '#666B8D'
        menu_project_manager.parentElement.classList.add('showMenu')
    }

    else if (location.pathname.split('/')[1] == 'purchase') {
        purchase.style.backgroundColor = '#666B8D'
        menu_money_manager.style.backgroundColor = '#666B8D'
        menu_money_manager.parentElement.classList.add('showMenu')
    } 
    else if (location.pathname.split('/')[1] == 'invoice') {
        invoice.style.backgroundColor = '#666B8D'
        menu_money_manager.style.backgroundColor = '#666B8D'
        menu_money_manager.parentElement.classList.add('showMenu')
    } 
    else if (location.pathname.split('/')[1] == 'service') {
        service.style.backgroundColor = '#666B8D'
        menu_money_manager.style.backgroundColor = '#666B8D'
        menu_money_manager.parentElement.classList.add('showMenu')
    } 
    else if (location.pathname.split('/')[1] == 'businessTrip') {
        businessTrip.style.backgroundColor = '#666B8D'
        menu_money_manager.style.backgroundColor = '#666B8D'
        menu_money_manager.parentElement.classList.add('showMenu')
    } 

    else if (location.pathname.split('/')[1] == 'goods') {
        good.style.backgroundColor = '#666B8D'
        menu_hardward_manager.style.backgroundColor = '#666B8D'
        menu_hardward_manager.parentElement.classList.add('showMenu')
    } 
    else if (location.pathname.split('/')[1] == 'reserve') {
        reserve.style.backgroundColor = '#666B8D'  
        menu_hardward_manager.style.backgroundColor = '#666B8D'
        menu_hardward_manager.parentElement.classList.add('showMenu')
    } 

    else if (location.pathname.split('/')[1] == 'leaveDay' || location.pathname.split('/')[1] == 'leaveDayBreak' || location.pathname.split('/')[1] == 'leaveDayApply') {
        leaveDay.style.backgroundColor = '#666B8D'
        menu_people_manager.style.backgroundColor = '#666B8D'
        menu_people_manager.parentElement.classList.add('showMenu')
    }
    
    
    else if (location.pathname.split('/')[1] == 'estimate') {
        estimate.style.backgroundColor = '#666B8D'
    } 
    else if (location.pathname.split('/')[1] == 'calendar') {
        calendar.style.backgroundColor = '#666B8D'
    } 
    
    

});

function dropMenu(el){
    var icon_link_Parent = el.parentElement.parentElement
    icon_link_Parent.classList.toggle('showMenu');
    console.log(icon_link_Parent.classList)

}