// Tinh tien photo
$('#tinhTien').on('click', function(){
    var soLuong = $('#soTo').val();
    var donGia = $('#donGia').val();
    var soBan = $('#soBan').val();
    var thanhTien = soLuong * donGia * soBan;
    $('#thanhTien').val(Number(thanhTien).toLocaleString("vi-VN"));
});

//Lam moi du lieu
$('#refesh-data').on('click', function(){
    $('#soTo').val(0);        
    $('#thanhTien').val(0);
    $('#soBan').val(1);
});

$('#tinhTienPhoto').on('click', function(){
    //Nếu chọn photo 2 mặt thì đặt biến photo2Mat = 2, ngược lại photo2Mat = 1
    var inputPhoto2Mat = $("#photo2Mat").prop("checked");
    var photo2Mat = 1;
    if(inputPhoto2Mat){
        photo2Mat = 2;
    }      
    var slide = 1;
    if($("#photoBinhThuong").prop("checked")){
        slide = 1;
    }else if($("#photo2Slide").prop("checked")){
        slide = 2;
    }else if($("#photo4Slide").prop("checked")){
        slide = 4;
    }else if($("#photo6Slide").prop("checked")){
        slide = 6;
    }
    var soLuong = 0;   

    soLuong = Math.ceil($('#soTrangPhoto').val()/(photo2Mat*slide));  

    var donGia = $('#donGiaPhoto').val();
    var soBan = $('#soBanPhoto').val();
    var giaThem = 0;

    if($('#photoBia').prop("checked")){
        giaThem += 3000;
    }
    if($('#photoBiaKieng').prop("checked")){
        giaThem += 3000;
    }

    var thanhTien = (soLuong * donGia * soBan) + giaThem;
    $('#thanhTienPhoto').val(Number(thanhTien).toLocaleString("vi-VN"));
});

//Lam moi du lieu
$('#refesh-data-slide').on('click', function(){
    $('#soTrangPhoto').val(0);        
    $('#thanhTienPhoto').val(0);
    
    $('#soBanPhoto').val(1);
    $("#photo2Mat").prop("checked",true);    
    $('#photoBia').prop("checked",false);
    $('#photoBiaKieng').prop("checked",false);
    $("#photoBinhThuong").prop("checked",true); 
    $("#photo2Slide").prop("checked",false); 
    $("#photo4Slide").prop("checked",false);
    $("#photo6Slide").prop("checked",false);
});