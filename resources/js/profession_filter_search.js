$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json',
        }
    });

    $(document).ready(function() {
        fetch_data();
        $('#professionSearch').keyup(function () {
            fetch_data();
        });
        $("#filterProfession").change(function () {
            fetch_data();
        });
        $("#perPage").change(function () {
            fetch_data();
        });

        $(document).on('click', '.delete-action', function() {
            const professionId = $(this).data('id');
            deleteProfession(professionId);
        });
    });

    let xhr = null;
    function fetch_data(page, id) {
        xhr = $.ajax({
            data: {
                search: $("#professionSearch").val(),
                filter: $("#filterProfession").val(),
                perPage: $("#perPage").val(),
                page: page,
                deleteId: id
            },
            url: "/admin/professions",
            method: "GET",
            dataType: "json",
            beforeSend: function() {
                if(xhr != null) {
                    xhr.abort();
                }
            },
            success: function (response) {
                buildTable(response)
                buildPagination(response)
            }
        });
    }

    function deleteProfession(professionId) {
        $.ajax({
            url: `/admin/professions/${professionId}`,
            method: 'DELETE',
            dataType: 'json',
            success: function () {
                fetch_data();
            }
        });
    }

    function buildTable(response) {
        if((response.data).length === 0) {
            $('#tableProf').hide();
            $('#noProfession').html("No professions found");
        }
        else {
            $('#tableProf').show();
            $('#noProfession').empty();
            $('#professionBody').empty();
            $.each(response.data, function (key, value) {
                $('#professionBody').append(
                    `<tr class="${value.id}"><td> ${value.id} </td>
                    <td> ${value.name} </td>
                    <td> ${(value.created_at).replace("T", " ").substring(0, 19)} </td>
                    <td> ${(value.updated_at).replace("T", " ").substring(0, 19)} </td>
                    <td>
                        <button class='btn btn-danger p-1 delete-action' data-id='${value.id}'>
                            <i class='far fa-trash-alt text-white'></i>
                        </button>
                    </td></tr>`
                );
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
            fetch_data(page);
        });

        $('#previous').click(function(e){
            e.preventDefault()
            let page = $('#previous').attr('href').split('page=')[1];
            fetch_data(page);
        });
    }
});
