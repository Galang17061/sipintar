var ujian_siap_dilaksanakan_data = {
 module: function () {
  return 'ujian_siap_dilaksanakan';
 },

 resetformInput: function () {
  $('#ujian_siap_dilaksanakan').val('');
 },

 search: function (elm, e) {
  if (e.keyCode == 13) {   
   var keyword = $(elm).val();
   $.ajax({
    type: 'POST',
    data: {keyword: keyword},
    dataType: 'html',
    async: false,
    url: ujian_siap_dilaksanakan_data.module() + '/search',
    beforeSend: function(){
//     message.showDialog('Proses Mendapatkan Data..');
    },
    error:function(){
//     message.closeDialog();
    },
    success: function (resp) {
//     message.closeDialog();
     $('.data_ujian').html(resp);
     helper.freezeHeaderTable();     
    }
   });
  }
 },

 reloadPage: function () {
  window.location.reload();
 },

 chooseSiswa: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(ujian_siap_dilaksanakan_data.module()) + 'chooseSiswa' + '/' + ujian,
   success: function (resp) {
    bootbox.dialog({
     message: resp,
     size: 'large'
    });
   }
  });
 },

 checkAllSiswa: function (elm) {
  var checked = $(elm).is(':checked');
  var all_siswa_check = $('.checkbox');
  $.each(all_siswa_check, function () {
   $(this).prop('checked', checked);
  });
 },

 checkedSiswa: function () {
  var total_checked = $('.checkbox').length;
  var counter = 0;
  $.each($('.checkbox'), function () {
   if ($(this).is(':checked')) {
    counter += 1;
   }
  });

  if (total_checked == counter) {
   $('#pilih_siswa_all').prop('checked', true);
  } else {
   $('#pilih_siswa_all').prop('checked', false);
  }
 },

 filterSiswaByJurusan: function (elm) {
  var jurusan_id = $(elm).val() == '' ? '0' : $(elm).val();
//  message.showDialog('Proses Mendapatkan Data...');
  $('.data_siswa').html('Proses Mendapatkan Data...');
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   error: function () {
    message.error('.message', 'Terjadi Error di Server');
   },

   url: url.base_url(ujian_siap_dilaksanakan_data.module()) + 'filterSiswaByJurusan' + '/' + jurusan_id,
   success: function (resp) {
    $('.data_siswa').html(resp);
//    helper.freezeHeaderTable();
   }
  });
 },

 startUjian: function (elm) {
  var peserta_ujian = parseInt($(elm).closest('tr').find('#peserta_ujian').text());
  var limit_waktu_ujian = $.trim($(elm).closest('tr').find('#limit_waktu_ujian').text());
  var kode_ujian = $(elm).closest('tr').find('#kode_ujian').text();
  var ujian_id = $(elm).attr('ujian-id');

  if (peserta_ujian <= 0) {
   message.error('.message', 'Belum Ada Peserta Ujian pada Kode Ujian : ' + kode_ujian);
  }

  if (limit_waktu_ujian == '0') {
   message.error('.message', 'Limit Waktu Ujian belum diatur pada Kode Ujian : ' + kode_ujian);
  }

  if (peserta_ujian > 0 && limit_waktu_ujian != '0') {
   ujian_siap_dilaksanakan_data.execStartUjian(ujian_id);
  }
 },

 execStartUjian: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(ujian_siap_dilaksanakan_data.module()) + 'execStartUjian' + '/' + ujian,
   error: function () {
    message.error('.message', 'Jaringan Error');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Submit Ujian Sukses');
     var reload = function () {
      window.location.reload();
     };

     setTimeout(reload(), 1000);
    } else {
     message.error('.message', resp.message);
    }
   }
  });
 },

 aturWaktuUjian: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(ujian_siap_dilaksanakan_data.module()) + 'aturWaktuUjian' + '/' + ujian,
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 execAturWatuUjian: function () {
  if (validation.run()) {
   var ujian = $('#ujian').val();
   var time_limit = $('#list_waktu').val();
   $.ajax({
    type: 'POST',
    data: {
     ujian: ujian,
     time_limit: time_limit
    },
    dataType: 'json',
    async: false,
    url: url.base_url(ujian_siap_dilaksanakan_data.module()) + 'execAturWatuUjian',
    error: function () {
     message.error('.message', 'Waktu Ujian Gagal DiAtur');
    },

    success: function (resp) {
     if (resp.is_valid) {
      message.success('.message', 'Waktu Ujian Berhasil DiAtur');
      var reload = function () {
       window.location.reload();
      };

      setTimeout(reload(), 1000);
     } else {
      message.error('.message', 'Waktu Ujian Gagal DiAtur');
     }
    }
   });
  }
 },

 setForm: function () {
  $('.uniform_on').uniform();
 },

 execChooseSiswa: function () {
  var checked_siswa = $('.checkbox');
  var total_checked = $('.checkbox').length;
  var counter_not_checked = 0;
  $.each(checked_siswa, function () {
   var checked = $(this).is(':checked');
   if (checked) {

   } else {
    counter_not_checked += 1;
   }
  });

  if (counter_not_checked != total_checked) {
   //true
   ujian_siap_dilaksanakan_data.execSimpanSiswaHasUjian();
  } else {
   message.error('.message', 'Belum Ada Siswa yang Terpilih');
  }
 },

 get_data_siswa: function () {
  var data = [];
  $.each($('.checkbox'), function () {
   var siswa = $(this).closest('tr').find('#id').text();
   var checked = $(this).is(':checked');
   if (checked) {
    data.push({
     'id': siswa
    });
   }
  });

  return data;
 },

 get_post_data_siswa: function () {
  var data = {
   'ujian': $('#ujian').val(),
   'siswa': ujian_siap_dilaksanakan_data.get_data_siswa()
  };
  return data;
 },

 execSimpanSiswaHasUjian: function () {
  var data = ujian_siap_dilaksanakan_data.get_post_data_siswa();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   contentType: false,
   processData: false,
   async: false,
   url: url.base_url(ujian_siap_dilaksanakan_data.module()) + 'execSimpanSiswaHasUjian',
   error: function () {
    message.error('.message', 'Jaringan Error');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Siswa Berhasil Didaftarkan Ujian');
     var reload = function () {
      window.location.reload();
     };

     setTimeout(reload(), 1000);
    } else {
     message.error('.message', 'Siswa Gagal Didaftarkan Ujian');
    }
   }
  });
 },

 tentukanSoalKeluar: function (ujian) {
  window.location = url.base_url(ujian_siap_dilaksanakan_data.module()) + 'tentukanSoalKeluar' + '/' + ujian;
 },

 tentukanSoalKeluarView: function (elm, kategori_soal, ujian) {
  var soal_keluar = $(elm).closest('tr').find('#soal_keluar').text();
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(ujian_siap_dilaksanakan_data.module()) + 'tentukanSoalKeluarView' + '/' + kategori_soal + '/' + ujian + '/' + soal_keluar,
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 tentukanNilaiKelulusan: function (id) {
  var html = "<div class='row'>";
  html += "<div class='col-md-12'>";
  html += "<div class='message'></div><br/>";
  html += "<h4>Nilai Kelulusan Ujian</h4>";
  html += "<input type='number' class='form-control text-right' value='0' id='nilai_lulus'/><br/>";
  html += "<div class='text-right'>";
  html += "<button class='btn btn-success' data_id='" + id + "' onclick='ujian_siap_dilaksanakan_data.simpanNilaiLulus(this)'>PROSES</button>";
  html += "</div>";
  html += "</div>";
  html += "</div>";

  bootbox.dialog({
   message: html
  });
 },

 simpanNilaiLulus: function (elm) {
  var ujian = $(elm).attr('data_id');
  $.ajax({
   type: 'POST',
   dataType: 'json',
   data: {
    ujian: ujian,
    nilai: $('#nilai_lulus').val() == '' ? 0 : $('#nilai_lulus').val()
   },
   async: false,
   url: url.base_url(ujian_siap_dilaksanakan_data.module()) + 'simpanNilaiLulus',
   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Nilai Sukses Disimpan');
     var reload = function () {
      window.location.reload();
     };

     setTimeout(reload(), 1000);
    } else {
     message.error('.message', 'Nilai Gagal Disimpan');
    }
   }
  });
 }
};

$(function () {
//  ujian_siap_dilaksanakan_data.setForm();
});