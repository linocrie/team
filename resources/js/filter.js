$('#multiSelect').on('change', function () {
    $('#filterForm').submit();
});


$('#filterForm').on('submit', function (e) {
    e.preventDefault();
    $('#table').html('');
    let value = $(this).val();
    let data = $(this).serialize();//havaqum a formi amboxjakan datan
    let action = $(this).attr('action');

    $.getJSON(action, data, response => {
        console.log(response);
        $('.row_filter').html('');

        for (let i = 0; i < response.length; i++) {
            setFilteredUsers(response[i]);
        }
        $('.pagination').addClass('d-none');
    })
})

function setFilteredUsers(data) {
        const tpl = $('#filter_table').find('tr').clone(true);
        $(tpl).find('.filter_id').text(data.id);
        $(tpl).find('.filter_name').text(data.name);
        $(tpl).find('.filter_email').text(data.email);
        $(tpl).find('.filter_phone').text(data.detail ? data.detail.phone : '-');
        $(tpl).find('.filter_address').text(data.detail ? data.detail.address : '-');
        $(tpl).find('.filter_city').text(data.detail ? data.detail.city : '-');
        $(tpl).find('.filter_country').text(data.detail ? data.detail.country : '-');
        let action = $(tpl).find('.filter_delete').attr('action').split('/');
        action.pop();
        let new_action = action.join('/') + '/' + data.id;
        $(tpl).find('.filter_delete').attr('action', new_action);

        $('.row_filter').append(tpl);
}
