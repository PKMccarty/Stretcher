$(document).ready(function() {
    for (var i = 0; i < 200; i++) {
        $('.display'+i).DataTable({
            order: [[2,'ASC']],lengthMenu: [5, 10]
         });
    }
    for (var i = 0; i < 3; i++) {
        $('#showdisplay'+i).DataTable({
            order: [[4,'ASC']],lengthMenu: [5, 10]
         });
    }
});