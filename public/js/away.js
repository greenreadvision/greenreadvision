
$(function(){
	
	var gNum=0;//組數的初始值
	var dX=0;//水平座標位置
	var WW=$(".slider").width();//外層寬度
	//以下變數為總組數
	
	var AA=Math.floor($(".slider ul").width()/WW);
	
	$(".status li").eq(gNum).addClass("now");
	
	$(".next").click(function(){
		if(gNum<AA){
			gNum++;
			dX = gNum*-175;
		}else{
			gNum=0;
			dX = 0;
		}
		SS();
	});
	
	$(".prev").click(function(){
		if(gNum>0){
			gNum--;
			dX = gNum*-175;
		}
		SS();
	});
	
	function SS(){
		$(".slider ul").stop().animate({left:dX}, 700);
		$(".status li").removeClass().eq(gNum).addClass("now");
	}
	
	$(".status li").click(function(){
		gNum=$(this).index();
		dX = gNum*WW*-175;
		SS();
	});
	

});




