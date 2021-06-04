$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json',
        }
    });

    $(document).ready(function() {
        fetch_data();
        $('#gallerySearch').keyup(function () {
            fetch_data();
        });
        $("#filterGallery").change(function () {
            fetch_data();
        });
        $("#page").change(function () {
            fetch_data();
        });

        $(document).on('click', '.delete-action-galley', function() {
            const galleryId = $(this).data('id');
            deleteGallery(galleryId);
        });
    });

    let xhr = null;
    function fetch_data(page, id) {
        xhr = $.ajax({
            data: {
                search: $("#gallerySearch").val(),
                filter: $("#filterGallery").val(),
                perPage: $("#page").val(),
                page: page,
                deleteId: id
            },
            url: "/admin/galleries",
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

    function deleteGallery(gallery) {
        $.ajax({
            url: `/admin/galleries/${gallery}`,
            method: 'DELETE',
            dataType: 'json',
            success: function () {
                fetch_data();
            }
        });
    }

    function buildTable(response) {
        if((response.data).length === 0) {
            $('#tableGallery').hide();
            $('#noGallery').html("No gallery found");
        }
        else {
            $('#tableGallery').show();
            $('#noGallery').empty();
            $('#galleryBody').empty();
            $.each(response.data, function (key, value) {
                $('#galleryBody').append(
                    `<tr class="${value.id}"><td> ${value.id} </td>
                    <td> ${value.title} </td>
                    <td> ${(value.created_at).replace("T", " ").substring(0, 19)} </td>
                    <td> ${(value.updated_at).replace("T", " ").substring(0, 19)} </td>
                    <td>
                        <button class='btn btn-danger p-1 delete-action-galley' data-id='${value.id}'>
                            <i class='far fa-trash-alt text-white'></i>
                        </button>
                    </td></tr>`
                );
            });
        }
    }

    function buildPagination(response) {

        if(response.total <= 3 || (response.data).length === 0) {
            $('#empty').addClass('d-none');
        }
        else {
            $('#empty').removeClass('d-none');
        }

        $('#nextPage').attr('href', response.next_page_url);
        $('#previousPage').attr('href', response.prev_page_url);

        let pageSize = response.last_page;
        let currentPage = response.current_page;
        if (currentPage === 1) {
            $('#previousPage').replaceWith(function(){
                return $("<span id='previousPage' class='p-1 mr-2 bg-dark text-white rounded'/>").append($(this).contents());
            });
        }
        else {
            $('#previousPage').replaceWith(function(){
                return $("<a href=" +response.prev_page_url + " id='previousPage' class='text-decoration-none p-1 mr-2 bg-dark text-white rounded'/>").append($(this).contents());
            });
        }
        if (currentPage === pageSize) {
            $('#nextPage').replaceWith(function(){
                return $("<span id='nextPage' class='p-1 ml-2 bg-dark text-white rounded'/>").append($(this).contents());
            });
        }
        else {
            $('#nextPage').replaceWith(function(){
                return $("<a href=" +response.next_page_url + " id='nextPage' class='text-decoration-none p-1 ml-2 bg-dark text-white rounded'/>").append($(this).contents());
            });
        }

        $('#nextPage').click(function(e){
            e.preventDefault();
            let page = $('#nextPage').attr('href').split('page=')[1];
            fetch_data(page);
        });

        $('#previousPage').click(function(e){
            e.preventDefault()
            let page = $('#previousPage').attr('href').split('page=')[1];
            fetch_data(page);
        });
    }
});
