$(document).ready(function(){
    $('.tab-mot-pagination').append('<div id="nav-mot"></div>');
    //$('.tab-mot').after('<div id="nav-mot"></div>');
    var rowsShown = 7;
    var rowsTotal = $('.tab-mot tbody tr').length;
    var numPages = rowsTotal/rowsShown;
    if(rowsTotal > 8){
        for(i = 0;i < numPages;i++) {
            var pageNum = i + 1;
            $('#nav-mot').append('<a rel="'+i+'">'+pageNum+'</a> ');
        }
        $('.tab-mot tbody tr').hide();
        $('.tab-mot tbody tr').slice(0, rowsShown).show();
        $('#nav-mot a:first').addClass('active');
        $('#nav-mot a').bind('click', function(){

            $('#nav-mot a').removeClass('active');
            $(this).addClass('active');
            var currPage = $(this).attr('rel');
            var startItem = currPage * rowsShown;
            var endItem = startItem + rowsShown;
            $('.tab-mot tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
            css('display','table-row').animate({opacity:1}, 300);
        });
    }
});