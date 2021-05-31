// $(function() {
//     let xhr = null;
//     $("#professionSearch").keyup(function(e) {
//         e.preventDefault();
//         let search = $("#professionSearch").val();
//         xhr = $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             // type: 'POST',
//             url: '/admin/profession/search?search='+search,
//             // data: {
//             //     txt: search
//             // },
//             // dataType: 'json',
//             beforeSend: function() {
//                 if(xhr != null) {
//                     xhr.abort();
//                 }
//             },
//             success: function(response) {
//                 // console.log(response)
//                 // $("#professionBody").empty();
//                 // if (!response.success) {
//                 //     console.log("hello");
//                 //     // $("#tableProf").hide();
//                 //     $("#pagination").empty();
//                 //     $('#noProfession').html(response.message);
//                 // } else {
//                 // $("body").empty();
//                     $('body').html(response);
//                 $('#pagination a').click(function(e) {
//                     console.log('page')
//                     e.preventDefault();
//                     let url = $(this).attr('href');
//                     $.ajax({
//                         url: url+'&search='+search,
//                         success: function(response) {
//                             // $("body").empty();
//                             $('body').html(response);
//                             $('#pagination a').click(function(e) {
//                                 console.log('page')
//                                 e.preventDefault();
//                                 let url = $(this).attr('href');
//                                 $.ajax({
//                                     url: url+'&search='+search,
//                                     success: function(response) {
//                                         // $("body").empty();
//                                         $('body').html(response);
//                                     }
//                                 });
//                             });
//                         }
//                     });
//                 });
//                     // $("#pagination").empty();
//                     // $("#noProfession").empty();
//                     // $("#tableProf").show();
//                     // $.each(response["message"].data, function (key, value) {
//                     //     console.log(response["message"].next_page_url);
//                     //     let result =
//                     //         "<tr><td>" + value.id + "</td>" +
//                     //         "<td>" + value.name + "</td>" +
//                     //         "<td>" + (value.created_at).replace("T", " ").substring(0, 19) + "</td>" +
//                     //         "<td>" + (value.updated_at).replace("T", " ").substring(0, 19) + "</td>" +
//                     //         "<td>" +
//                     //         "<form method='post' action='/admin/professions/delete/" + value.id + "'>" +
//                     //         "<input type='hidden' name='_token' value='" + $('meta[name="csrf-token"]').attr('content') + "'>" +
//                     //         "<input type='hidden' name='_method' value='DELETE'>" +
//                     //         "<button type='submit' class='btn btn-white p-1'>" +
//                     //         "<i class='far fa-trash-alt text-white'></i>" +
//                     //         "</button>" +
//                     //         "</form>" +
//                     //         "</td>";
//                     //     $('#professionBody').append(result);
//                     //
//                     //     if (response["message"].next_page_url != null) {
//                     //         $("#pagination").html("<nav role=\"navigation\" aria-label=\"Pagination Navigation\" class=\"flex justify-between\">" +
//                     //             "<span class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md\">&laquo; Previous</span>" +
//                     //             "<a href=\"http://127.0.0.1:8000/admin/professions/search?page=" + i + "\" rel=\"next\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
//                     //             "Next &raquo;></a>" +
//                     //             "</nav>");
//                     //
//                     //         $('#pagination a').on('click', function (e) {
//                     //             e.preventDefault();
//                     //             let page = $(this).attr('href').split('page=')[1];
//                     //             i++;
//                     //             fetch_data(page);
//                     //         });
//                     //
//                     //         function fetch_data(page) {
//                     //             $.ajax({
//                     //                 url: '/admin/professions/search?page=' + page + '&search=' + search,
//                     //                 dataType: 'json',
//                     //                 success: function (response) {
//                     //                     $("#professionBody").empty();
//                     //                     $("#pagination").empty();
//                     //                     $("#noProfession").empty();
//                     //                     $.each(response["message"].data, function (key, value) {
//                     //                         let result =
//                     //                             "<tr><td>" + value.id + "</td>" +
//                     //                             "<td>" + value.name + "</td>" +
//                     //                             "<td>" + (value.created_at).replace("T", " ").substring(0, 19) + "</td>" +
//                     //                             "<td>" + (value.updated_at).replace("T", " ").substring(0, 19) + "</td>" +
//                     //                             "<td>" +
//                     //                                 $("#deleteForm").clone() +
//                     //                             "</td>";
//                     //                         $('#professionBody').append(result);
//                     //                         if (response["message"].next_page_url != null) {
//                     //                             if(response["message"].current_page === 1) {
//                     //                                 $("#pagination").html("<nav role=\"navigation\" aria-label=\"Pagination Navigation\" class=\"flex justify-between\">" +
//                     //                                     "<span class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md\">&laquo; Previous</span>" +
//                     //                                     "<a href=\"http://127.0.0.1:8000/admin/professions/search?page=" + i + "\" rel=\"next\" id=\"next\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
//                     //                                     "Next &raquo;></a>" +
//                     //                                     "</nav>");
//                     //                             }
//                     //                             else {
//                     //                                 $("#pagination").html("<nav role=\"navigation\" aria-label=\"Pagination Navigation\" class=\"flex justify-between\">" +
//                     //                                     "<a href=\"http://127.0.0.1:8000/admin/professions/search?page=" + (i - 2) + "\" rel=\"next\" id=\"prev\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
//                     //                                     "&laquo; Previous></a>" +
//                     //                                     "<a href=\"http://127.0.0.1:8000/admin/professions/search?page=" + i + "\" rel=\"next\" id=\"next\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
//                     //                                     "Next &raquo;></a>" +
//                     //                                     "</nav>");
//                     //                             }
//                     //
//                     //                             $('#next').on('click', function (e) {
//                     //                                 e.preventDefault();
//                     //                                 let page = $(this).attr('href').split('page=')[1];
//                     //                                 i++;
//                     //                                 fetch_data(page);
//                     //                             });
//                     //
//                     //                             $('#prev').on('click', function (e) {
//                     //                                 e.preventDefault();
//                     //                                 let page = $(this).attr('href').split('page=')[1];
//                     //                                 i--;
//                     //                                 fetch_data(page);
//                     //                             });
//                     //                         }
//                     //                         else {
//                     //                             $("#pagination").html("<nav role=\"navigation\" aria-label=\"Pagination Navigation\" class=\"flex justify-between\">" +
//                     //                                 "<a href=\"http://127.0.0.1:8000/admin/professions/search?page=" + (i-2) + "\" rel=\"next\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150\">\n" +
//                     //                                 "&laquo; Previous></a>" +
//                     //                                 "<span class=\"relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md\">Next &raquo;</span>" +
//                     //                                 "</nav>");
//                     //
//                     //                             $('#pagination a').on('click', function (e) {
//                     //                                 e.preventDefault();
//                     //                                 let page = $(this).attr('href').split('page=')[1];
//                     //                                 i--;
//                     //                                 fetch_data(page);
//                     //                             });
//                     //                         }
//                     //                     });
//                     //                 }
//                     //             });
//                     //         }
//                     //     }
//                     // });
//                 // }
//             }
//         });
//     });
// });
$(document).ready(function() {
    let xhr = null;
    function fetch_data(page, search) {
        xhr = $.ajax({
            url: "/admin/profession/search?page=" + page + "&search=" + search,
            beforeSend: function() {
                if(xhr != null) {
                    xhr.abort();
                }
            },
            success: function (response) {
                $('body').empty();
                $('body').append(response);
                $('#professionSearch').val(search);
            }
        })
    }

    $('#professionSearch').keyup(function(){
        let search = $('#professionSearch').val();
        let page = $("#pagination a").attr('href').split('page=')[1]-1;
        fetch_data(page, search);
    });

    $("#pagination a").click(function(e){
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        let search = $('#professionSearch').val();
        fetch_data(page, search);
    });
});
