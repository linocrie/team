$(function() {
    let xhr = null;
    $("#professionSearch").keyup(function() {
        let search = $("#professionSearch").val();
        xhr = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/professionSearch',
            data: {
                txt: search
            },
            dataType: 'json',
            beforeSend: function() {
                if(xhr != null) {
                    xhr.abort();
                }
            },
            success: function(response) {
                $("#professionBody").empty();
                if(!response.success) {
                    $("#tableProf").hide();
                    $('#noProfession').html(response.message);
                }
                else {
                    $("#noProfession").empty();
                    $("#tableProf").show();
                    $.each(response["message"], function(key, value) {
                        let result =
                        "<tr><td>" + value.id + "</td>" +
                        "<td>" + value.name + "</td>" +
                        "<td>" + (value.created_at).substring(0, 19) + "</td>" +
                        "<td>" + (value.updated_at).substring(0, 19) + "</td>" +
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
            }
        });
    });
});