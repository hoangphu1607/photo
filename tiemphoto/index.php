<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"  href="lib/css/bootstrap.min.css">
    <link rel="stylesheet"  href="css/style.css?v=<?php echo time(); ?>">
    <script src="lib/jquery/jquery.min.js"></script>

    <script src="lib/js/bootstrap.min.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <script src="lib/js/bootstrap.bundle.js"></script>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    label{
        margin: 0;
        font-weight: 500;
    }
    .form-control{
        margin: 0;
    }
</style>
<?php
    include 'getData.php';
    $data_sys = getAllData_System();
    
    // print_r(getAllData_System());
?>
<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-label">Tính tiền photo</div>            
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                            <label for=""></label>
                                <a href="#" class="btn btn-light form-control btn-refesh" id="refesh-data">
                                    <img class="img-refesh " src="img/refesh.svg" alt="">
                                </a>
                            </div>
                            <div class="col-md-2">
                                <label for="">Số tờ</label>
                                <input type="text" class="form-control ingput-tinhtien" placeholder="Số tờ" id="soTo">
                            </div>
                            <div class="col-md-2">
                                <label for="">Đơn giá</label>
                                <input type="text" class="form-control ingput-tinhtien" placeholder="Đơn giá" id="donGia" value="<?php echo $data_sys['DonGia']; ?>">
                            </div>
                            <div class="col-md-2">
                                <label for="">Số bản</label>
                                <input type="number" class="form-control ingput-tinhtien" placeholder="Số bản" id="soBan" value="1">
                            </div>
                            <div class="col-md-3">
                                <label for="">Thành tiền</label>
                                <input type="text" class="form-control ingput-tinhtien" placeholder="Thành tiền" id="thanhTien" readonly>
                            </div>
                            <div class="col-md-2">
                            <label for=""></label>
                                <a href="#" class="btn btn-primary btn-tinhtien" id="tinhTien">Tính tiền</a>
                            </div>
                            
                        </div>                       
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-label">Tính tiền in</div>            
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                            <label for=""></label>
                                <a href="#" class="btn btn-light form-control btn-refesh" id="refesh-data-slide">
                                    <img class="img-refesh " src="img/refesh.svg" alt="">
                                </a>
                            </div>
                            <div class="col-md-2">
                            <label for="">Số trang</label>
                                <input type="text" class="form-control ingput-tinhtien" placeholder="Số trang" id="soTrangPhoto">
                            </div>
                            <div class="col-md-2">
                            <label for="">Đơn giá</label>
                                <input type="text" class="form-control ingput-tinhtien" placeholder="Đơn giá" id="donGiaPhoto" value="<?php echo $data_sys['DonGia']; ?>">
                            </div>
                            <div class="col-md-2">
                                <label for="">Số bản</label>
                                <input type="number" class="form-control ingput-tinhtien" placeholder="Số bản" id="soBanPhoto" value="1">
                            </div>
                            <div class="col-md-3">
                            <label for="">Thành tiền</label>
                                <input type="text" class="form-control ingput-tinhtien" placeholder="Thành tiền" id="thanhTienPhoto" readonly>
                            </div>
                            <div class="col-md-2">
                            <label for=""></label>
                                <a href="#" class="btn btn-primary btn-tinhtien" id="tinhTienPhoto">Tính tiền</a>
                            </div>                            
                        </div>                       
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="photo2Mat" checked>
                                    <label class="form-check-label" for="photo2Mat">2 mặt</label>
                                </div>    
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="photoBia">
                                    <label class="form-check-label" for="photoBia">Có bìa</label>
                                </div>   
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="photoBiaKieng">
                                    <label class="form-check-label" for="photoBiaKieng">Có bìa kiếng</label>
                                </div>                             
                            </div>    
                            <div class="col-md-4">                   
                                <div class="form-group form-check">
                                    <input type="radio" class="form-check-input" id="photoBinhThuong" name="photoSlide" checked>
                                    <label class="form-check-label" for="photoBinhThuong">Photo bình thường</label>
                                </div>             
                                <div class="form-group form-check">
                                    <input type="radio" class="form-check-input" id="photo2Slide" name="photoSlide">
                                    <label class="form-check-label" for="photo2Slide">Photo 2 Slide</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="radio" class="form-check-input" id="photo4Slide" name="photoSlide">
                                    <label class="form-check-label" for="photo4Slide" >Photo 4 Slide</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="radio" class="form-check-input" id="photo6Slide" name="photoSlide">
                                    <label class="form-check-label" for="photo6Slide">Photo 6 Slide</label>
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>    
</body>
<script src="script/tinhtienphoto.js?v=<?php echo time(); ?>"></script>
</html>