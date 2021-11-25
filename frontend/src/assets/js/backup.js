!function($){"use strict";$.fn.meanmenu=function(e){var n={meanMenuTarget:jQuery(this),meanMenuContainer:".small_nav",meanMenuClose:"X",meanMenuCloseSize:"18px",meanMenuOpen:"<span></span><span></span><span></span>",meanRevealPosition:"right",meanRevealPositionDistance:"0",meanRevealColour:"",meanScreenWidth:"992",meanNavPush:"",meanShowChildren:!0,meanExpandableChildren:!0,meanExpand:"+",meanContract:"-",meanRemoveAttrs:!1,onePage:!1,meanDisplay:"block",removeElements:""};e=$.extend(n,e);var a=window.innerWidth||document.documentElement.clientWidth;return this.each(function(){var n=e.meanMenuTarget,t=e.meanMenuContainer,r=e.meanMenuClose,i=e.meanMenuCloseSize,s=e.meanMenuOpen,u=e.meanRevealPosition,m=e.meanRevealPositionDistance,l=e.meanRevealColour,o=e.meanScreenWidth,c=e.meanNavPush,v=".meanmenu-reveal",h=e.meanShowChildren,d=e.meanExpandableChildren,y=e.meanExpand,j=e.meanContract,Q=e.meanRemoveAttrs,f=e.onePage,g=e.meanDisplay,p=e.removeElements,C=!1;(navigator.userAgent.match(/iPhone/i)||navigator.userAgent.match(/iPod/i)||navigator.userAgent.match(/iPad/i)||navigator.userAgent.match(/Android/i)||navigator.userAgent.match(/Blackberry/i)||navigator.userAgent.match(/Windows Phone/i))&&(C=!0),(navigator.userAgent.match(/MSIE 8/i)||navigator.userAgent.match(/MSIE 7/i))&&jQuery("html").css("overflow-y","scroll");var w="",x=function(){if("center"===u){var e=window.innerWidth||document.documentElement.clientWidth,n=e/2-22+"px";w="left:"+n+";right:auto;",C?jQuery(".meanmenu-reveal").animate({left:n}):jQuery(".meanmenu-reveal").css("left",n)}},A=!1,E=!1;"right"===u&&(w="right:"+m+";left:auto;"),"left"===u&&(w="left:"+m+";right:auto;"),x();var M="",P=function(){M.html(jQuery(M).is(".meanmenu-reveal.meanclose")?r:s)},W=function(){jQuery(".mean-bar,.mean-push").remove(),jQuery(t).removeClass("mean-container"),jQuery(n).css("display",g),A=!1,E=!1,jQuery(p).removeClass("mean-remove")},b=function(){var e="background:"+l+";color:"+l+";"+w;if(o>=a){jQuery(p).addClass("mean-remove"),E=!0,jQuery(t).addClass("mean-container"),jQuery(".mean-container").prepend('<div class="mean-bar"><a href="#nav" class="meanmenu-reveal" style="'+e+'">Show Navigation</a><nav class="mean-nav"></nav></div>');var r=jQuery(n).html();jQuery(".mean-nav").html(r),Q&&jQuery("nav.mean-nav ul, nav.mean-nav ul *").each(function(){jQuery(this).is(".mean-remove")?jQuery(this).attr("class","mean-remove"):jQuery(this).removeAttr("class"),jQuery(this).removeAttr("id")}),jQuery(n).before('<div class="mean-push" />'),jQuery(".mean-push").css("margin-top",c),jQuery(n).hide(),jQuery(".meanmenu-reveal").show(),jQuery(v).html(s),M=jQuery(v),jQuery(".mean-nav ul").hide(),h?d?(jQuery(".mean-nav ul ul").each(function(){jQuery(this).children().length&&jQuery(this,"li:first").parent().append('<a class="mean-expand" href="#" style="font-size: '+i+'">'+y+"</a>")}),jQuery(".mean-expand").on("click",function(e){e.preventDefault(),jQuery(this).hasClass("mean-clicked")?(jQuery(this).text(y),jQuery(this).prev("ul").slideUp(300,function(){})):(jQuery(this).text(j),jQuery(this).prev("ul").slideDown(300,function(){})),jQuery(this).toggleClass("mean-clicked")})):jQuery(".mean-nav ul ul").show():jQuery(".mean-nav ul ul").hide(),jQuery(".mean-nav ul li").last().addClass("mean-last"),M.removeClass("meanclose"),jQuery(M).click(function(e){e.preventDefault(),A===!1?(M.css("text-align","center"),M.css("text-indent","0"),M.css("font-size",i),jQuery(".mean-nav ul:first").slideDown(),A=!0):(jQuery(".mean-nav ul:first").slideUp(),A=!1),M.toggleClass("meanclose"),P(),jQuery(p).addClass("mean-remove")}),f&&jQuery(".mean-nav ul > li > a:first-child").on("click",function(){jQuery(".mean-nav ul:first").slideUp(),A=!1,jQuery(M).toggleClass("meanclose").html(s)})}else W()};C||jQuery(window).resize(function(){a=window.innerWidth||document.documentElement.clientWidth,a>o,W(),o>=a?(b(),x()):W()}),jQuery(window).resize(function(){a=window.innerWidth||document.documentElement.clientWidth,C?(x(),o>=a?E===!1&&b():W()):(W(),o>=a&&(b(),x()))}),b()})}}(jQuery);


function responsiveMenu() {
$(document).ready(function () {
	$('.navigation nav').meanmenu();
});
}



function circularCarousel() {


 let i=1;

$(document).ready(function () {

   var radius = 300;
    var fields = $('.itemDot');
    var container = $('.dotCircle');
    var width = container.width();
 radius = width/2.5;
 
     var height = container.height();
    var angle = 0, step = (2*Math.PI) / fields.length;
    fields.each(function() {
      var x = Math.round(width/2 + radius * Math.cos(angle) - $(this).width()/2);
      var y = Math.round(height/2 + radius * Math.sin(angle) - $(this).height()/2);
      if(window.console) {
        // console.log($(this).text(), x, y);
      }
      
      $(this).css({
        left: x + 'px',
        top: y + 'px'
      });
      angle += step;
    });
    
    
    $('.itemDot').click(function(){
      
      // var dataTab= $(this).data("tab");
      // $('.itemDot').removeClass('active');
      // $(this).addClass('active');
      // $('.CirItem').removeClass('active');
      // $( '.CirItem'+ dataTab).addClass('active');
      // i=dataTab;
      
      // $('.dotCircle').css({
      //   "transform":"rotate("+(360-(i-1)*90)+"deg)",
      //   "transition":"2s"
      // });
      // $('.itemDot').css({
      //   "transform":"rotate("+((i-1)*90)+"deg)",
      //   "transition":"1s"
      // });
      
      
    });
    
    setInterval(function(){
      var dataTab= $('.itemDot.active').data("tab");
      if(dataTab>4||i>4){
      dataTab=1;
      i=1;
      }
      $('.itemDot').removeClass('active');
      $('[data-tab="'+i+'"]').addClass('active');
      $('.CirItem').removeClass('active');
      $( '.CirItem'+i).addClass('active');
      i++;
      
      
      $('.dotCircle').css({
        "transform":"rotate("+(360-(i-1)*90)+"deg)",
        "transition":"2s"
      });
      $('.itemDot').css({
        "transform":"rotate("+((i-1)*90)+"deg)",
        "transition":"1s"
      });
      
      }, 8000);

 });

}


function circularCarousel2() {


 let i=1;

$(document).ready(function () {

   var radius = 390;
    var fields = $('.itemDot');
    var container = $('.dotCircle');
    var width = container.width();
 radius = width/2.5;
 
     var height = container.height();
    var angle = 0, step = (2*Math.PI) / fields.length;
    fields.each(function() {
      var x = Math.round(width/2 + radius * Math.cos(angle) - $(this).width()/2);
      var y = Math.round(height/2 + radius * Math.sin(angle) - $(this).height()/2);
      if(window.console) {
        // console.log($(this).text(), x, y);
      }
      
      $(this).css({
        left: x + 'px',
        top: y + 'px'
      });
      angle += step;
    });
    
    
    $('.itemDot').click(function(){
      
      // var dataTab= $(this).data("tab");
      // $('.itemDot').removeClass('active');
      // $(this).addClass('active');
      // $('.CirItem').removeClass('active');
      // $( '.CirItem'+ dataTab).addClass('active');
      // i=dataTab;
      
      // $('.dotCircle').css({
      //   "transform":"rotate("+(360-(i-1)*90)+"deg)",
      //   "transition":"2s"
      // });
      // $('.itemDot').css({
      //   "transform":"rotate("+((i-1)*90)+"deg)",
      //   "transition":"1s"
      // });
      
      
    });
    
    setInterval(function(){
      var dataTab= $('.itemDot.active').data("tab");
      if(dataTab>4||i>4){
      dataTab=1;
      i=1;
      }
      $('.itemDot').removeClass('active');
      $('[data-tab="'+i+'"]').addClass('active');
      $('.CirItem').removeClass('active');
      $( '.CirItem'+i).addClass('active');
      i++;
      
      
      $('.dotCircle').css({
        "transform":"rotate("+(360-(i-1)*90)+"deg)",
        "transition":"2s"
      });
      $('.itemDot').css({
        "transform":"rotate("+((i-1)*90)+"deg)",
        "transition":"1s"
      });
      
      }, 8000);

 });

}






function equelHeight() {
  equalheight = function(container){
 var currentTallest = 0,
      currentRowStart = 0,
      rowDivs = new Array(),
      $el,
      topPosition = 0;
  $(container).each(function() {
    $el = $(this);
    $($el).height('auto')
    topPostion = $el.position().top;
    if (currentRowStart != topPostion) {
      for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
        rowDivs[currentDiv].height(currentTallest);
      }
     rowDivs.length = 0; // empty the array
      currentRowStart = topPostion;
      currentTallest = $el.height();
      rowDivs.push($el);
    } else {
      rowDivs.push($el);
      currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
   }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
      rowDivs[currentDiv].height(currentTallest);
    }
  });
 }




  $(window).on('load', function(){ 
 
  equalheight('.inner_mid_carosel .slide');
  equalheight('.news_box');
  equalheight('.form_box');
  equalheight('.blog_box');
  equalheight('.p-top-smae');});

  
$(window).resize(function(){
  equalheight('.inner_mid_carosel .slide');
  equalheight('.news_box');
  equalheight('.form_box');
  equalheight('.blog_box');
  equalheight('.p-top-smae'); 
  
});
}