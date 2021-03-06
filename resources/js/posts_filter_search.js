$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json',
        }
    });

    if($('#tablePost').length) {
        $(document).ready(function () {
            fetch_data();
            $('#searchPosts').keyup(function () {
                fetch_data();
            });
            $("#filterPosts").change(function () {
                fetch_data();
            });
            $("#paginatePosts").change(function () {
                fetch_data();
            });
            $(document).on('click', '.delete-action-post', function () {
                const postId = $(this).data('id');
                deletePost(postId);
            });
        })
    }
    let ajax = null;
    function fetch_data(page) {
        ajax = $.ajax({
            data: {
                search: $("#searchPosts").val(),
                filter: $("#filterPosts").val(),
                perPage: $("#paginatePosts").val(),
                page: page
            },
            url: '/admin/posts',
            method: "GET",
            dataType: "json",
            beforeSend: function() {
                NProgress.start();
                if(ajax != null){
                    ajax.abort();
                }
            },
            success: function (response) {
                $('#weather').html("Temperature in " + response['weather'].name + ": " + "<span class='text-danger'>" + String((response['weather'].main.temp)).slice(0, -3) + "</span>" + "&#8451;");
                buildTable(response)
                buildPagination(response)
            },
            complete: function () {
                NProgress.done();
            }
        });
    }

    function deletePost(postId) {
        $.ajax({
            url: `/admin/posts/${postId}`,
            method: 'DELETE',
            dataType: 'json',
            beforeSend: function () {
                NProgress.start()
            },
            success: function (response) {
                fetch_data();
                NProgress.done();
            }
        });
    }
    function buildTable(response) {
        if((response['posts'].data).length === 0) {
            $("#postsBody").empty();
        }
        else {
            $('#postsBody').empty();

            $.each(response['posts'].data, function (key, value) {

                let arr = [];
                $.each(value.professions, function (key, profession) {
                    arr.push(profession.name);
                })
                $('#postsBody').append(
                    `<tr class="${value.id}"><td> ${value.id} </td>
                    <th scope="row"> ${value.title} </th>
                    <th scope="row"> ${(value.description)} </th>
                    <th scope="row">`
                    + arr.toString() +
                    `</th>
                    <th>
                        <button class='btn btn-danger p-1 delete-action-post' data-id='${value.id}'>
                                <i class='far fa-trash-alt text-white'></i>
                        </button>
                    </th></tr>`
                );
                $(`#${value.id}`).on('click', function() {
                    $(`.${value.id}`).remove();
                    fetch_data(1, value.id);
                });
            });
        }
    }
    function buildPagination(response) {
        let pageSize = response['posts'].last_page;
        let currentPage = response['posts'].current_page;
        let totalPages = response['posts'].total;

        $('.next').attr('href', response['posts'].next_page_url);
        $('.previous').attr('href', response['posts'].prev_page_url);
        if (currentPage === pageSize) {
            $('.next').replaceWith(function () {
                return $("<span class='next'></span>").append($(this).contents());
            });
        } else {
            $('.next').replaceWith(function () {
                return $("<a href=" + response['posts'].next_page_url + " class='next btn btn-dark '></a>").append($(this).contents());
            });
        }
        if (currentPage === 1) {
            $('.previous').replaceWith(function () {
                return $("<span class='previous btn btn-dark'></span>").append($(this).contents());
            });
        } else {
            $('.previous').replaceWith(function () {
                return $("<a href=" + response['posts'].prev_page_url + " class='previous btn btn-dark'></a>").append($(this).contents());
            });
        }
        if (totalPages <= 3 || response['posts'].data.length == 0) {
            $('#paginatePosts').addClass('d-none');
        } else {
            $('#paginatePosts').removeClass('d-none');
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
