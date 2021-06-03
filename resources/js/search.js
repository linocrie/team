let ajax = null;
$(document).on('input', "#search", function () {
    $('#searchForm').submit();
})
$('#searchForm').on('submit', function (e) {
    e.preventDefault();
    $('#table').html('');
    if (!$('#search').val().length) return "No results";

    let data = $(this).serialize();//havaqum a formi amboxjakan datan
    let action = $(this).attr('action');

    $.getJSON(action, data, response => {
        console.log(response)
        $('#rowSearch').html('');
        for (let i = 0; i < response.length; i++) {
            setUsers(response[i]);
        }
        $('.pagination').addClass('d-none');
    });
})

function setUsers(data) {
    console.log(132);
    console.log(data);
    const tpl = $('#tableTpl').find('tr').clone(true);
    $(tpl).find('.id').text(data.id);
    $(tpl).find('.name').text(data.name);
    $(tpl).find('.email').text(data.email);
    $(tpl).find('.phone').text(data.phone);
    $(tpl).find('.address').text(data.address);
    $(tpl).find('.city').text(data.city);
    $(tpl).find('.country').text(data.country);
    let action = $(tpl).find('.delete').attr('action').split('/');
    action.pop();
    let new_action = action.join('/') + '/' + data.id;
    $(tpl).find('.delete').attr('action', new_action);
    $('#rowSearch').append(tpl);
}
