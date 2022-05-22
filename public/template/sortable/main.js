$( init );

function init() {
  $( ".droppable-area1, .droppable-area2" ).sortable({
        items: "li",
        listType: 'ul',
        cursor: 'move',
        connectWith: ".connected-sortable",
        stack: '.connected-sortable ul',
        update: function (event, ui) {
            var attr_id = ui.item.attr('data-id');
            if(ui.item.parent( ".isOnIndex" ).attr('data-type') == 'isNotOnIndex'){
                var order = $(this).sortable('toArray');
                var positions = order.join(';');
                addCategorieOnIndex(attr_id, positions);
            }else if(ui.item.parent( ".isNotOnIndex" ).attr('data-type') == 'isNotOnIndex'){
                removeCategorieFromIndexAction(attr_id);
            }
        }
    }).disableSelection();
}