<div class="tab-content">
            <div id="tao-hoa-don" class="container tab-pane active"><br>
                <div class="row timKiem-them">
                    <div class="timKiem input-group mb-3 col-md-6">
                        <form action="#" method="get" class="" style="display: flex;">
                            <input type="text" class="form-control form-timkiem" placeholder="Tìm kiếm...">
                            <button class="btn btn-success btnTim" type="submit" name="btnSearch">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>

                    <div class="timKiem col-md-6">
                        <h2>DANH SÁCH ĐƠN HÀNG</h2>
                    </div>
                    <div class="timKiem DonHang col-md-2" ><a href="TaoDonHangNVBH.php">
                        <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#myModalNV" >
                            Tạo đơn hàng
                        </button></a>
                    </div>
                </div>
                
               


                <main>
                    <div class="row">
                        
                        <div class="col-12">
                            <section>
                                <!-- Bảng để hiển thị thông tin -->
                                <table class="main-table">
                                    <thead>
                                        <tr>
                                            <th>Mã hóa đơn</th>
                                           
                                            <th>Tổng tiền</th>
                                            <th>Ngày lập</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            include_once("vHoaDon_NVBH.php");
                                            $vHoaDon = new VHoaDon();
                                            $vHoaDon->viewAllHoaDon();
                                        
                                            ?>
                                        
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </main>    
                     
            </div>
        </div>