

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

    function fetch_data(id) {
        $.ajax({
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                search: $("#professionSearch").val(),
                filter: $("#filterProfession").val(),
                perPage: $("#paginate").val(),
                deleteId: id
            },
            url: "/admin/professions",
            method: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response);
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
        }
    }

    function buildPagination(response) {
        // selecting required element
        const element = document.querySelector(".pagination ul");
        let totalPages = 20;
        let page = 10;

//calling function with passing parameters and adding inside element which is ul tag
        element.innerHTML = createPagination(totalPages, page);
        function createPagination(totalPages, page) {
            let liTag = '';
            let active;
            let beforePage = page - 1;
            let afterPage = page + 1;
            if(page > 1){ //show the next button if the page value is greater than 1
                liTag += `<li class="btn prev" onclick="createPagination(totalPages, ${page - 1})"><span><i class="fas fa-angle-left"></i> Prev</span></li>`;
            }

            if(page > 2){ //if page value is less than 2 then add 1 after the previous button
                liTag += `<li class="first numb" onclick="createPagination(totalPages, 1)"><span>1</span></li>`;
                if(page > 3){ //if page value is greater than 3 then add this (...) after the first li or page
                    liTag += `<li class="dots"><span>...</span></li>`;
                }
            }

            // how many pages or li show before the current li
            if (page == totalPages) {
                beforePage = beforePage - 2;
            } else if (page == totalPages - 1) {
                beforePage = beforePage - 1;
            }
            // how many pages or li show after the current li
            if (page == 1) {
                afterPage = afterPage + 2;
            } else if (page == 2) {
                afterPage  = afterPage + 1;
            }

            for (var plength = beforePage; plength <= afterPage; plength++) {
                if (plength > totalPages) { //if plength is greater than totalPage length then continue
                    continue;
                }
                if (plength == 0) { //if plength is 0 than add +1 in plength value
                    plength = plength + 1;
                }
                if(page == plength){ //if page is equal to plength than assign active string in the active variable
                    active = "active";
                }else{ //else leave empty to the active variable
                    active = "";
                }
                liTag += `<li class="numb ${active}" onclick="createPagination(totalPages, ${plength})"><span>${plength}</span></li>`;
            }

            if(page < totalPages - 1){ //if page value is less than totalPage value by -1 then show the last li or page
                if(page < totalPages - 2){ //if page value is less than totalPage value by -2 then add this (...) before the last li or page
                    liTag += `<li class="dots"><span>...</span></li>`;
                }
                liTag += `<li class="last numb" onclick="createPagination(totalPages, ${totalPages})"><span>${totalPages}</span></li>`;
            }

            if (page < totalPages) { //show the next button if the page value is less than totalPage(20)
                liTag += `<li class="btn next" onclick="createPagination(totalPages, ${page + 1})"><span>Next <i class="fas fa-angle-right"></i></span></li>`;
            }
            element.innerHTML = liTag; //add li tag inside ul tag
            return liTag; //reurn the li tag
        }
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

