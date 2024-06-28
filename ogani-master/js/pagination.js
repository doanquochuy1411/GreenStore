$(document).ready(function(){
    // Số mục trên mỗi trang
    var itemsPerPage = 8;

    // Ẩn tất cả các mục, ngoại trừ các mục trang đầu tiên
    $('#items > div').slice(itemsPerPage).hide();

    // Tính toán số trang
    var totalPages = Math.ceil($('#items > div').length / itemsPerPage);

    // Tạo các liên kết phân trang
    for (var i = 1; i <= totalPages; i++) {
        $('#pagination').append('<a class="page-link" data-page="' + i + '">' + i + '</a>');
        if (i + 1 > totalPages){
            $('#pagination').append('<a class="page-link" data-page="' + i + '"><i class="fa fa-long-arrow-right"></a>');
        }
    }
    // <a href="#"><i class="fa fa-long-arrow-right"></i></a>


    // Khi người dùng chọn một trang
    $('#pagination').on('click', '.page-link', function(){
        var currentPage = $(this).data('page');
        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage;

        // Ẩn tất cả các mục
        $('#items > div').hide();

        // Hiển thị các mục cho trang được chọn
        $('#items > div').slice(startIndex, endIndex).show();

        // Đánh dấu trang được chọn
        $(this).addClass('active').siblings().removeClass('active');
    });
});