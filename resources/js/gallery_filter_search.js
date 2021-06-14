$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json',
        }
    });

    if($('#tableGallery').length) {
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

            $(document).on('click', '.delete-action-gallery', function() {
                const galleryId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteGallery(galleryId);
                        Swal.fire(
                            'Deleted!',
                            'Profession has been deleted.',
                            'success'
                        )
                    }
                })

            });
        });
    }

    let xhr = null;
    function fetch_data(page) {
        xhr = $.ajax({
            data: {
                search: $("#gallerySearch").val(),
                filter: $("#filterGallery").val(),
                perPage: $("#page").val(),
                page: page,
            },
            url: "/admin/galleries",
            method: "GET",
            dataType: "json",
            beforeSend: function() {
                NProgress.start();
                if(xhr != null) {
                    xhr.abort();
                }
            },
            success: function (response) {
                $('#weatherGallery').html("Temperature in " + response['weather'].name + ": " + "<span class='text-danger'>" + String((response['weather'].main.temp)).slice(0, -3) + "</span>" + "&#8451;");
                buildTable(response)
                buildPagination(response)
                NProgress.done();
            }
        });
    }

    function deleteGallery(gallery) {
        $.ajax({
            url: `/admin/galleries/${gallery}`,
            method: 'DELETE',
            dataType: 'json',
            beforeSend: function (){NProgress.start()},
            success: function () {
                fetch_data();
                NProgress.done();
            }
        });
    }

    function buildTable(response) {
        if((response['gallery'].data).length === 0) {
            $('#gallery_block').hide();
            $('#noGallery').html("No gallery found");
        }
        else {
            $('#gallery_block').show();
            $('#noGallery').empty();
            $('#galleryBody').empty();
            $.each(response["gallery"].data, function (key, value) {
                $('#galleryBody').append(
                    `<tr class="${value.id}"><td> ${value.id} </td>
                    <td> ${value.title} </td>
                    <td> ${(value.created_at).replace("T", " ").substring(0, 19)} </td>
                    <td> ${(value.updated_at).replace("T", " ").substring(0, 19)} </td>
                    <td>
                        <button class='btn btn-danger p-1 delete-action-gallery' data-id='${value.id}'>
                            <i class='far fa-trash-alt text-white'></i>
                        </button>
                    </td></tr>`
                );
            });
        }
    }

    function buildPagination(response) {

        if(response["gallery"].total <= 3 || (response["gallery"].data).length === 0) {
            $('#empty').addClass('d-none');
        }
        else {
            $('#empty').removeClass('d-none');
        }

        $('#nextPage').attr('href', response["gallery"].next_page_url);
        $('#previousPage').attr('href', response["gallery"].prev_page_url);

        let pageSize = response["gallery"].last_page;
        let currentPage = response["gallery"].current_page;
        if (currentPage === 1) {
            $('#previousPage').replaceWith(function(){
                return $("<span id='previousPage' class='p-1 mr-2 bg-dark text-white rounded'/>").append($(this).contents());
            });
        }
        else {
            $('#previousPage').replaceWith(function(){
                return $("<a href=" +response["gallery"].prev_page_url + " id='previousPage' class='text-decoration-none p-1 mr-2 bg-dark text-white rounded'/>").append($(this).contents());
            });
        }
        if (currentPage === pageSize) {
            $('#nextPage').replaceWith(function(){
                return $("<span id='nextPage' class='p-1 ml-2 bg-dark text-white rounded'/>").append($(this).contents());
            });
        }
        else {
            $('#nextPage').replaceWith(function(){
                return $("<a href=" +response["gallery"].next_page_url + " id='nextPage' class='text-decoration-none p-1 ml-2 bg-dark text-white rounded'/>").append($(this).contents());
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
