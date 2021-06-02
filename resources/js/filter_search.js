

$(function() {
    fetch_data();

    $("#professionSearch").keyup(function(){
        fetch_data();
    });

    $("#filterProfession" ).change(function(){
        fetch_data();
    });

    $("#paginate" ).change(function(){
        fetch_data();
    });

    function fetch_data(page, id) {
        $.ajax({
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                search: $("#professionSearch").val(),
                filter: $("#filterProfession").val(),
                perPage: $("#paginate").val(),
                page: page,
                deleteId: id
            },
            url: "/admin/professions",
            method: "GET",
            dataType: "json",
            success: function (response) {
                // console.log(response);
                buildTable(response)
                buildPagination(response)
            }
        });
    }

    function buildTable(response) {
        if((response.data).length === 0) {
            $("#tableProf").empty();
            $('#noProfession').html("No professions found");
        }
        else {
            $('#professionBody').empty();
            $.each(response.data, function (key, value) {
                $('#professionBody').append(

                    `<tr class="${value.id}"><td> ${value.id} </td>
                    <td> ${value.name} </td>
                    <td> ${(value.created_at).replace("T", " ").substring(0, 19)} </td>
                    <td> ${(value.updated_at).replace("T", " ").substring(0, 19)} </td>
                    <td>
                        <button class='btn btn-white p-1' data-id=${value.id} id="${value.id}">
                            <i class='far fa-trash-alt text-white'></i>
                        </button>
                    </td></tr>`
                );

                $(`#${value.id}`).on('click', function() {
                    $(`.${value.id}`).remove();
                    fetch_data(value.id);
                });
            });

            $('.next').attr('href', response.next_page_url);
            $('.previous').attr('href', response.prev_page_url);

            let pageSize = response.last_page;
            let currentPage = response.current_page;
            let pagedResults = [];
            let totalResults = (response.data).length;

                var end = (currentPage * pageSize);
                var start = (end - pageSize);
                pagedResults = response
                console.log(pagedResults);
                console.log(response.length);
                if (currentPage === 1) {
                    $('.previous').remove();
                }
                if ((currentPage * pageSize) >= totalResults) {
                    $('.next').prop("disabled", true); }
                else { $('.next').prop("disabled", false); }

            $('.next').click(function(e){
                console.log("next")
                e.preventDefault();
                let page = $('.next').attr('href').split('page=')[1];
                // if ((currentPage * pageSize) <= totalResults) currentPage++;
                fetch_data(page);
            });
            $('.previous').click(function(e){
                e.preventDefault()
                let page = $('.previous').attr('href').split('page=')[1];
                // if (currentPage > 1) currentPage--;
                fetch_data(page);
            });
        }
    };

    function buildPagination(response) {

    }
});

    // function fetch_data(page, filter) {
    //     $.ajax({
    //         url: "/admin/professions/filter?page=" + page + "&filter=" + filter,
    //         dataType: "json",
    //         success: function (response) {
    //             $('#filterProfession').val(filter);
    //             $("#pagination").empty();
    //             $("#professionBody").empty();
    //
    //             if ((response["message"].data).length === 0) {
    //                 $("#tableProf").empty();
    //                 $('#noProfession').html("No professions found");
    //             } else {
    //                 $.each(response["message"].data, function (key, value) {


                    //     let result =
                    //         "<tr><td>" + value.id + "</td>" +
                    //         "<td>" + value.name + "</td>" +
                    //         "<td>" + (value.created_at).replace("T", " ").substring(0, 19) + "</td>" +
                    //         "<td>" + (value.updated_at).replace("T", " ").substring(0, 19) + "</td>" +
                    //         "<td>" +
                    //         "<form method='post' action='/admin/professions/delete/" + value.id + "'>" +
                    //             "<input type='hidden' name='_token' value='" + $('meta[name="csrf-token"]').attr('content') + "'>" +
                    //             "<input type='hidden' name='_method' value='DELETE'>" +
                    //             "<button type='submit' class='btn btn-white p-1' data-id="value.id">" +
                    //                 "<i class='far fa-trash-alt text-white'></i>" +
                    //             "</button>" +
                    //         "</form>" +
                    //         "</td>";
                    //     if(response["message"].next_page_url == null && response["message"].prev_page_url == null) {
                    //         $("#pagination").empty();
                    //     }
                    //     else if (response["message"].next_page_url != null && response["message"].prev_page_url == null) {
                    //         $("#pagination").html("<nav role=\"navigation\" aria-label=\"Pagination Navigation\" class=\"flex justify-between\">" +
                    //             "<span class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md\">&laquo; Previous</span>" +
                    //             "<a href=" + response["message"].next_page_url + "&search=" + search + "\" rel=\"next\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
                    //             "Next &raquo;></a>" +
                    //             "</nav>");
                    //     }
                    //     else if(response["message"].next_page_url != null && response["message"].prev_page_url != null) {
                    //         $("#pagination").html("<nav role=\"navigation\" aria-label=\"Pagination Navigation\" class=\"flex justify-between\">" +
                    //             "<a href=" + response["message"].prev_page_url + "&search=" + search + "\" rel=\"next\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
                    //             "&laquo; Previous></a>" +
                    //             "<a href=" + response["message"].next_page_url + "&search=" + search + "\" rel=\"next\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
                    //             "Next &raquo;></a>" +
                    //             "</nav>");
                    //     }
                    //     else {
                    //         $("#pagination").html("<nav role=\"navigation\" aria-label=\"Pagination Navigation\" class=\"flex justify-between\">" +
                    //             "<a href=" + response["message"].prev_page_url + "&search=" + search + "\" rel=\"next\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
                    //             "&laquo; Previous></a>" +
                    //             "<span class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md\">Next &raquo;</span>" +
                    //             "</nav>");
                    //     }
                    //     $('#professionBody').append(result);
                    // });
                    // $("#pagination a").click(function(e){
                    //     e.preventDefault();
                    //     let page = $(this).attr('href').split('page=')[1];
                    //     let search = $('#professionSearch').val();
                    //     fetch_data(page, search);
    //                 });
    //             }
    //         }
    //     })
    // }

    // $("#filterProfession" ).change(function(){
    //     let filter = $('#filterProfession').val();
    //     let page = $("#hidden_page").val();
    //     fetch_data(page, filter);
    // });

