function validateFormNV() {
    var hoTen = document.getElementById('hoTen').value;
    var matkhau = document.getElementById('matkhau').value;
    var Email = document.getElementById('Email').value;
    var SDT = document.getElementById('SDT').value;
    var DiaChi = document.getElementById('DiaChi').value;

    // Khởi tạo đối tượng chứa thông báo lỗi
    var errorMessages = {
        hoTen: '',
        matkhau: '',
        Email: '',
        SDT: '',
        DiaChi: ''
    };

    // Kiểm tra điều kiện và lưu thông báo lỗi
    //^[a-zA-Z\s]
    if (hoTen.trim() === '' || !/^[\p{L}\s]+$/gu.test(hoTen)) {
        errorMessages.hoTen = 'Họ và tên không được để trống và phải là chữ.';
    }

    if (matkhau.trim() === '' || !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(matkhau)) {
        errorMessages.matkhau = 'Mật khẩu không được để trống và ít nhất 8 ký tự trong đó ít nhất một ký tự đặc biệt như @$!%*?&, ký tự chữ thường, hoa từ "a" đến "z" và số từ 0 – 9.';
    }

    if (Email.trim() === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(Email)) {
        errorMessages.Email = 'Email không hợp lệ.';
    }

    if (SDT.trim() === '' || !/^[0]\d{9}$/.test(SDT)) {
        errorMessages.SDT = 'Số điện thoại không hợp lệ.';
    }

    ///^[a-zA-Z\d][a-zA-Z\d\s]*[a-zA-Z]$/
    //!/^[a-zA-Z0-9,/-][a-z0-9,/-\s]*(?:[ 0-9][a-zA-Z0-9,/-][a-z0-9,/-\s]*)*$/gm.test(DiaChi) || !/^\d$/.test(DiaChi)
    ///^\d*\s*[\p{L}0-9,/-]+\s[\p{L}0-9,/-]+,\s*[\p{L}0-9,/-]+\s[\p{L}0-9,/-]+$
    if (DiaChi.trim() === '' || !/^\d*\s*[\p{L}0-9\s\-,./]+$/gu.test(DiaChi)) {
        errorMessages.DiaChi = 'Địa chỉ không hợp lệ.';
    }

    // Hiển thị thông báo lỗi trong thẻ <small>
    document.getElementById('hoTen-mess').innerHTML = errorMessages.hoTen;
    document.getElementById('matkhau-mess').innerHTML = errorMessages.matkhau;
    document.getElementById('Email-mess').innerHTML = errorMessages.Email;
    document.getElementById('SDT-mess').innerHTML = errorMessages.SDT;
    document.getElementById('DiaChi-mess').innerHTML = errorMessages.DiaChi;

    // Kiểm tra xem có thông báo lỗi nào không
    for (var field in errorMessages) {
        if (errorMessages[field] !== '') {
            return false; // Có ít nhất một lỗi, không submit form
        }
    }

    return true; // Không có lỗi, có thể submit form
}




function validateFormSP() {
    var tenSP = document.getElementById('tenSP').value;
    var thuongHieu = document.getElementById('thuongHieu').value;
    var SLT = document.getElementById('SLT').value;
    var giaNhap = parseInt(document.getElementById('giaNhap').value)
    var giaNhapValue = document.getElementById('giaNhap').value
    var giaBanValue = document.getElementById('giaBan').value
    var giaBan = parseInt(document.getElementById('giaBan').value)
    var HSD = document.getElementById('HSD').value;

    // Khởi tạo đối tượng chứa thông báo lỗi
    var errorMessages = {
        tenSP: '',
        thuongHieu: '',
        SLT: '',
        giaNhap: '',
        giaBan: '',
        HSD: ''
    };

    // Kiểm tra điều kiện và lưu thông báo lỗi
    if (tenSP.trim() === '') {
        errorMessages.tenSP = 'Tên sản phẩm không được để trống.';
    }

    if (thuongHieu.trim() === '') {
        errorMessages.thuongHieu = 'Thương hiệu không được để trống.';
    }

    if (SLT <= 0 || SLT ==='') {
        errorMessages.SLT = 'Số lượng tồn phải lớn hơn 0 và không được để trống.';
    }

    if (giaNhap <= 0 || giaNhapValue ==='') {
        errorMessages.giaNhap = 'Giá nhập phải lớn hơn 0 và không được để trống.';
    }

    if (giaBan <= giaNhap || giaBanValue === '') {
        errorMessages.giaBan = 'Giá bán phải lớn hơn giá nhập và không được để trống.';
    }

    var currentDate = new Date().toISOString().split('T')[0];
    if (HSD <= currentDate) {
        errorMessages.HSD = 'Hạn sử dụng phải lớn hơn ngày hiện tại.';
    }

    // Hiển thị thông báo lỗi trong thẻ <small>
    document.getElementById('tenSP-mess').innerHTML = errorMessages.tenSP;
    document.getElementById('thuongHieu-mess').innerHTML = errorMessages.thuongHieu;
    document.getElementById('SLT-mess').innerHTML = errorMessages.SLT;
    document.getElementById('giaNhap-mess').innerHTML = errorMessages.giaNhap;
    document.getElementById('giaBan-mess').innerHTML = errorMessages.giaBan;
    document.getElementById('HSD-mess').innerHTML = errorMessages.HSD;

    // Kiểm tra xem có thông báo lỗi nào không
    for (var field in errorMessages) {
        if (errorMessages[field] !== '') {
            return false; // Có ít nhất một lỗi, không submit form
        }
    }

    return true; // Không có lỗi, có thể submit form
}

