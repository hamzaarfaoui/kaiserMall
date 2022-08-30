// jQuery Plugin: http://flaviusmatis.github.io/simplePagination.js/

function pagination() {
    var items = $(".product-single");
    var numItems = items.length;
    var perPage = 20;

    items.slice(perPage).hide();
    if(numItems > 20){
    $('.pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });
    }
}