$(function(){
    var scrolled = false;


setInterval(function updateScroll(){
    if(!scrolled){
        var element = document.getElementById("conversation");
        element.scrollTop = element.scrollHeight;
    }
},1000);
$("#conversation").on('scroll', function(){
    scrolled=true;
});

});