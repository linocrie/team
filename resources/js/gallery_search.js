function myFunction(){

}





$(document).ready(function () {
    let xhr = null;
    $("#search").keyup(function () {
        let search = $(`#search`).val();
        if (search.length > 0) {
            xhr = $.ajax
            ({
                url: `/admin/galleries/search?search=` + search,
                dataType: "json",
                beforeSend: function () {
                    if (xhr != null) {
                        xhr.abort();
                    }
                },
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
                    })
                }
            })
        }
    });

});
