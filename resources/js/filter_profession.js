$(function () {
    $('#filterMultiSelect').multipleSelect();
    $("#filterMultiSelect" ).change(function() {
        let selected = $('#filterMultiSelect').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/professionFilter',
            data: {
                profession: selected
            },
            dataType: 'json',
            success: function(response) {
                $("#professionBody").empty();
                $.each(response["message"], function(key, value) {
                    let result =
                        "<tr><td>" + value.id + "</td>" +
                        "<td>" + value.name + "</td>" +
                        "<td>" + (value.created_at) + "</td>" +
                        "<td>" + (value.updated_at) + "</td>" +
                        "<td>" +
                            "<form method='post' action='/admin/professions/delete/" + value.id + "'>" +
                                "<input type='hidden' name='_token' value='QWm0w0fYGver7UEtYNMRxCoEYe4bI5SasMxjTLuZ'>" +
                                "<input type='hidden' name='_method' value='DELETE'>" +
                                "<button type='submit' class='btn btn-white p-1'>" +
                                "<i class='far fa-trash-alt text-white'></i>" +
                                "</button>" +
                            "</form>" +
                        "</td>";
                    $('#professionBody').append(result);
                });
            }
        });
    });
});
