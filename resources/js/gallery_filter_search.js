$(function() {
    fetch_data();
    $("#professionSearch").keyup(function () {
        fetch_data();
    });
    $("#filterProfession").change(function () {
        fetch_data();
    });
    $("#paginate").change(function () {
        fetch_data();
    });

    function fetch_data(page,id) {
        $.ajax({
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                search: $("#professionSearch").val(),
                filter: $("#filterProfession").val(),
                perPage: $("#paginate").val(),
                page:page,
                deleteId:id,

            },
            url: id ? "/admin/galleries/destroy" : "/admin/galleries",
            method: "GET",
            dataType: "json",
            success: function (response) {
                buildTable(response)
                buildPagination(response)
            }
        });
    }

    function buildTable(response) {
        if ((response.data).length === 0) {
            $("#tableProf").empty();
            $('#noProfession').html("No professions found");
        } else {
            $('#professionBody').empty();
            $.each(response.data, function (key, value) {
                $('#professionBody').append(
                    `<tr class="${value.id}"><td> ${value.id} </td>
                    <td> ${value.title} </td>
                    <td> ${(value.created_at).replace("T", " ").substring(0, 19)} </td>
                    <td> ${(value.updated_at).replace("T", " ").substring(0, 19)} </td>
                    <td>
                        <button class='btn btn-white p-1' data-id=${value.id} id="${value.id}">
                            <i class='far fa-trash-alt text-white'></i>
                        </button>
                    </td></tr>`
                );
                $(`#${value.id}`).on('click', function () {
                    $(`.${value.id}`).remove();
                    fetch_data(1, value.id);
                });
            });
        }
    }

    function buildPagination(response) {
            if(response.total <= 3 || (response.data).length === 0) {
                $('#pageNone').addClass('d-none');
            }
            else {
                $('#pageNone').removeClass('d-none');
            }
            $('#next').attr('href', response.next_page_url);
            $('#previous').attr('href', response.prev_page_url);
            let pageSize = response.last_page;
            let currentPage = response.current_page;
            if (currentPage === 1) {
                $('#previous').replaceWith(function(){
                    return $("<span id='previous' class='p-1 mr-2 bg-dark text-white rounded'/>").append($(this).contents());
                });
            }
            else {
                $('#previous').replaceWith(function(){
                    return $("<a href=" +response.prev_page_url + " id='previous' class='text-decoration-none p-1 mr-2 bg-dark text-white rounded'/>").append($(this).contents());
                });
            }
            if (currentPage === pageSize) {
                $('#next').replaceWith(function(){
                    return $("<span id='next' class='p-1 ml-2 bg-dark text-white rounded'/>").append($(this).contents());
                });
            }
            else {
                $('#next').replaceWith(function(){
                    return $("<a href=" +response.next_page_url + " id='next' class='text-decoration-none p-1 ml-2 bg-dark text-white rounded'/>").append($(this).contents());
                });
            }
            $('#next').click(function(e){
                e.preventDefault();
                let page = $('#next').attr('href').split('page=')[1];
                // if ((currentPage * pageSize) <= totalResults) currentPage++;
                fetch_data(page);
            });
            $('#previous').click(function(e){
                e.preventDefault()
                let page = $('#previous').attr('href').split('page=')[1];
                // if (currentPage > 1) currentPage--;
                fetch_data(page);
            });
        }
});
