$('#datatable tbody').on('click', 'tr td input[type=checkbox]', function () {
    $(this).prop('checked', !$(this).prop('checked'));
});

$('#datatable tbody').on('click', 'tr', function () {
    $(this).toggleClass('selected');
    c = $(this).children('td:first').children('input[type=checkbox]');
    if (!c.is(':disabled')) {
        c.prop('checked', !c.prop('checked'));
    }
});

$('#datatable2 tbody').on('click', 'tr td input[type=checkbox]', function () {
    $(this).prop('checked', !$(this).prop('checked'));
});

$('#datatable2 tbody').on('click', 'tr', function () {
    $(this).toggleClass('selected');
    c = $(this).children('td:first').children('input[type=checkbox]');
    if (!c.is(':disabled')) {
        c.prop('checked', !c.prop('checked'));
    }
});
