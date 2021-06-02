
$(document).ready(function(){
    $("#multiSelect").change(function(){
        let selectedValue = $(this).children("option:selected").val();
        xhr = $.ajax
        ({
            url: `/admin/galleries/filter?filter=` + selectedValue,
            dataType: "json",
            success: function (response) {
                console.log(response)
                $('#table').empty();
                $('#paginate').empty();
                response.forEach((result) => {
                    let row = '<tr>' +
                        '<td>' + result.id + '</td>' +
                        '<td>' + result.user.name + '</td>' +
                        '<td>' + result.title + '</td>' +
                        '<td>' + result.created_at.replace('T',' ').substring(0,19) + '</td>' +
                        '<td>' + result.updated_at.replace('T',' ').substring(0,19) + '</td>' +
                        '</tr>'
                    $('#table').append(row);
                });
            }
        });
    });
});
