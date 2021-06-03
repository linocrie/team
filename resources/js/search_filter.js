$(function () {
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

    function fetch_data(page, id) {
        $.ajax({
            headers: {
                'Content-Type': 'application/json',
            },
            data: {
                search: $("#search").val(),
                filter: $("#filter").val(),
                perPage: $("#paginate").val(),
                page: page,
                deleteId: id
            },
            url: !id ? '/admin/users' : '/admin/users/delete',
            method: "GET",
            dataType: "json",
            success: function (response) {
                buildTable(response)
                buildPagination(response)
            }
        });
    }

    function buildTable(response) {
        $('#rowSearch').empty();
        $.each(response.data, function (key, value) {
            $('#rowSearch').append(
                `<tr class="${value.id} text-center">
                        <th> ${value.id} </th>
                        <th> ${value.name} </th>
                        <th> ${(value.email)}</th>
                        <th> ${(value.detail ? value.detail.phone : '-')} </th>
                        <th class="text-center"> ${(value.detail ? value.detail.address : '-')} </th>
                        <th> ${(value.detail ? value.detail.city : '-')} </th>
                        <th> ${(value.detail ? value.detail.country : '-')} </th>
                        <th>
                            <button class='btn btn-danger p-1' data-id=${value.id} id="${value.id}">
                                <i class='far fa-trash-alt text-white'></i>
                            </button>
                        </th>
                    </tr>`
            );
            $(`#${value.id}`).on('click', function () {
                $(`.${value.id}`).remove();
                let page = 1;
                fetch_data(page, value.id);
            });
        })
    }

    function buildPagination(response) {
        console.log(response);
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
            console.log(123);
            $('.previous').replaceWith(function () {
                return $("<span class='previous'></span>").append($(this).contents());
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
