$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json',
        }
    });

    $(document).ready(function() {
        fetch_data();

        $('#search').keyup(function () {
            fetch_data();
        });

        $("#filter").change(function () {
            fetch_data();
        });

        $("#paginate").change(function () {
            fetch_data();
        });

        $(document).on('click', '.delete-action', function() {
            const userId = $(this).data('id');
            deleteUser(userId);
        });
    });

    let ajax = null;
    function fetch_data(page, id) {
        ajax = $.ajax({
            data: {
                search: $("#search").val(),
                filter: $("#filter").val(),
                perPage: $("#paginate").val(),
                page: page,
                deleteId: id
            },
            url: '/admin/users',
            method: "GET",
            dataType: "json",
            beforeSend: function(){
                if(ajax != null){
                    ajax.abort();
                }
            },
            success: function (response) {
                buildTable(response)
                buildPagination(response)
            }
        });
    }

    function deleteUser(userId) {
        $.ajax({
            url: `/admin/users/${userId}`,
            method: 'DELETE',
            dataType: 'json',
            success: function (response) {
                fetch_data();
            }
        });
    }

    function buildTable(response) {
        $('#rowSearch').empty();
        $.each(response.data, function (key, value) {
            $('#rowSearch').append(
                `<tr class="text-center">
                        <th> ${value.id} </th>
                        <th> ${value.name} </th>
                        <th> ${(value.email)}</th>
                        <th> ${(value.detail ? value.detail.phone : '-')} </th>
                        <th class="text-center"> ${(value.detail ? value.detail.address : '-')} </th>
                        <th> ${(value.detail ? value.detail.city : '-')} </th>
                        <th> ${(value.detail ? value.detail.country : '-')} </th>
                        <th>
                            <button class='btn btn-danger p-1 delete-action' data-id='${value.id}'>
                                <i class='far fa-trash-alt text-white'></i>
                            </button>
                        </th>
                    </tr>`
            );
        })
    }

    function buildPagination(response) {
        let pageSize = response.last_page;
        let currentPage = response.current_page;
        let totalPages = response.total;

        $('.next').attr('href', response.next_page_url);
        $('.previous').attr('href', response.prev_page_url);
        if (currentPage === pageSize) {
            $('.next').replaceWith(function () {
                return $("<span class='next'></span>").append($(this).contents());
            });
        } else {
            $('.next').replaceWith(function () {
                return $("<a href=" + response.next_page_url + " class='next btn btn-dark '></a>").append($(this).contents());
            });
        }
        if (currentPage === 1) {
            $('.previous').replaceWith(function () {
                return $("<span class='previous btn btn-dark'></span>").append($(this).contents());
            });
        } else {
            $('.previous').replaceWith(function () {
                return $("<a href=" + response.prev_page_url + " class='previous btn btn-dark'></a>").append($(this).contents());
            });
        }
        if (totalPages <= 3 || response.data.length == 0) {
            $('#pagination').addClass('d-none');
        } else {
            $('#pagination').removeClass('d-none');
        }
        $('.next').click(function (event) {
            event.preventDefault();
            let page = $('.next').attr('href').split('page=')[1];
            fetch_data(page);
        });

        $('.previous').click(function (event) {
            event.preventDefault()
            let page = $('.previous').attr('href').split('page=')[1];
            fetch_data(page);
        });
    }
})
