<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .btnThongKe {
            border-radius: 3px;
            background-color: #198754;
            color: #fff;
            border: none;
            padding: 7px;
            margin: 5px;
            width: 100px
        }
    </style>
</head>

<body>

    <div class="container" style="margin:20px auto" border="1">
        <form action="#" method="post">
            <div class="row">
                <div class="col-md-6" style="text-align: center; margin: 10px auto">
                    <h4>Chọn khoảng thời gian</h4>
                    Từ: &nbsp;<input type="date" name="start_date" id="start_date" value="<?php if (isset($_REQUEST["start_date"])) echo $_REQUEST["start_date"] ?>"> &nbsp;&nbsp;&nbsp;&nbsp;
                    Đến: &nbsp;<input type="date" name="end_date" id="end_date" value="<?php if (isset($_REQUEST["end_date"])) echo $_REQUEST["end_date"] ?>">
                </div>
                <div class="col-md-6" style="text-align: center; margin: 10px auto">
                    <h4>Chọn loại thống kê</h4>
                    <input type="radio" name="thongKe" id="ngay" value="ngay" <?php echo (isset($_REQUEST['thongKe']) && $_REQUEST['thongKe'] == 'ngay') ? 'checked' : ''; ?>> Ngày &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="thongKe" id="thang" value="thang" <?php echo (isset($_REQUEST['thongKe']) && $_REQUEST['thongKe'] == 'thang') ? 'checked' : ''; ?>> Tháng &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="thongKe" id="nam" value="nam" <?php echo (isset($_REQUEST['thongKe']) && $_REQUEST['thongKe'] == 'nam') ? 'checked' : ''; ?>> Năm
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12" style="text-align: center; margin: 20px auto">
                    <button type="reset" class="btnThongKe">Đặt lại</button>
                    <button type="submit" name="btnThongKe" class="btnThongKe">Xác nhận</button>
                </div>
            </div>

        </form>
        <div class="row">
            <div class="col-12 col-md-12 thongKe" style="width: 800px; height: 400px; margin: 0px auto">
                <?php
                include_once 'view/vChartDoanhThu.php';

                    if (isset($_REQUEST["btnThongKe"])) {
                        $t = new ViewChart();

                        $start_date = $_REQUEST["start_date"];
                        $end_date = $_REQUEST["end_date"];


                        // Tạo đối tượng DateTime từ chuỗi ngày
                        $start_date_obj = new DateTime($start_date);
                        $end_date_obj = new DateTime($end_date);

                        if ($end_date_obj < $start_date_obj) {
                            echo "<h4 style='text-align: center; color: #e70f47'>Ngày kết thúc không thể trước ngày bắt đầu.</h4>";
                            // echo "<meta http-equiv='refresh' content='3;url='./indexAdmin?thong-ke''>";
                            exit();
                        }


                        if (isset($_REQUEST["thongKe"])) {
                            $selected = $_REQUEST["thongKe"];

                            switch ($selected) {
                                case "ngay":
                                    if (empty($start_date) || empty($end_date)) {
                                        echo "<h4 style='text-align: center; color: #e70f47'>Vui lòng nhập đầy đủ ngày bắt đầu và ngày kết thúc.</h4>";
                                        // echo "<meta http-equiv='refresh' content='3;url='./indexAdmin?thong-ke''>";
                                        exit();
                                    }
                                    $resTK = $t->showRevenueChartNgay($start_date, $end_date);
                                    echo $resTK;
                                    break;
                                case "thang":
                                    // Lấy giá trị tháng từ đối tượng DateTime
                                    $start_month = $start_date_obj->format('m');
                                    $end_month = $end_date_obj->format('m');

                                    $resTK = $t->showRevenueChartThang($start_month, $end_month);
                                    echo $resTK;
                                    break;
                                case "nam":
                                    // Lấy giá trị năm từ đối tượng DateTime
                                    $start_year = $start_date_obj->format('Y');
                                    $end_year = $end_date_obj->format('Y');

                                    $resTK = $t->showRevenueChartNam($start_year, $end_year);
                                    echo $resTK;
                                    break;
                                default:
                                    echo "<h4 style='text-align: center; color: #e70f47'>Không có lựa chọn nào được chọn.</h4>";
                            }
                        } else {
                            echo "<h4 style='text-align: center; color: #e70f47'>Vui lòng chọn đầy đủ thông tin.</h4>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>

</body>

</html>