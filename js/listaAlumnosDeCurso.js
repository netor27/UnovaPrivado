$(function(){
    $(".cuadro").hover(
        function () {
            $(this).children(".cuadroFooter").addClass("bottomFooterHover");
        }, 
        function () {
            $(this).children(".cuadroFooter").removeClass("bottomFooterHover");
                
        });
});