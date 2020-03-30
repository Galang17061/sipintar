var membuat_ujian_data = {
 module: function () {
  return 'membuat_ujian';
 },

 simpan: function () {
  if (validation.run()) {
   membuat_ujian_data.exec_save();
  }
 },

 get_pengawas_ujian: function () {
  var data = [];
  $.each($('.pengawas_ujian'), function () {
   data.push({
    'pengawas_ujian': $(this).val()
   });
  });

  return data;
 },

 get_post_data: function () {
  var data = {
   'id': $('#id').val(),
   'nama_ujian': $('#nama_ujian').val(),
   'pengawas_ujian': membuat_ujian_data.get_pengawas_ujian(),
   'tanggal_ujian': $('#tanggal_ujian').val(),
   'kategori_ujian': $('#kategori_ujian').val(),
   'jam_ujian': $('#jam_ujian').val(),
   'menit_ujian': $('#menit_ujian').val()
  };

  return data;
 },

 exec_save: function () {
  var data = membuat_ujian_data.get_post_data();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   contentType: false,
   processData: false,
   async: false,
   url: url.base_url(membuat_ujian_data.module()) + 'save',
   success: function (resp) {
    if (resp.is_valid) {
     if ($('#id').val() != '') {
      message.success('.message', 'Data Berhasil Diperbaharui');
     } else {
      message.success('.message', 'Data Berhasil Disimpan');
     }
    } else {
     if ($('#id').val() != '') {
      message.error('.message', 'Data Gagal Diperbaharui');
     } else {
      message.error('.message', 'Data Gagal Disimpan');
     }
    }

    membuat_ujian_data.resetformInput();
   }
  });
 },

 resetformInput: function () {
  $('#nama_ujian').val('');
  $('#tanggal_ujian').val('');
  $('#kategori_ujian').val('');
  $('#jam_ujian').val('');
  $('#menit_ujian').val('');
  $.each($('.pengawas_ujian'), function () {
   $(this).val('');
  });
 },

 search: function (elm, e) {
  if (e.keyCode == 13) {
   message.showDialog('Proses Mendapatkan Data..');
   var keyword = $(elm).val();
   $.ajax({
    type: 'POST',
    data: {keyword: keyword},
    dataType: 'html',
    async: false,
    url: membuat_ujian_data.module() + '/search',
    success: function (resp) {
     $('.data').html(resp);
     helper.freezeHeaderTable();
     message.closeDialog();
    }
   });
  }
 },

 remove: function (id) {
  var html = '<div>';
  html += '<p>Apakah anda yakin akan menghapus data ini ? </p>';
  html += '<div class="text-right">';
  html += '<button class="btn btn-primary" onclick="membuat_ujian_data.exec_remove(' + id + ')">Ya</button> &nbsp;';
  html += '<button class="btn" onclick="message.closeDialog()">Tidak</button> &nbsp;';
  html += '</div>';
  html += '</div>';

  message.showDialog(html);
 },

 reloadPage: function () {
  window.location.reload();
 },

 exec_remove: function (id) {
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(membuat_ujian_data.module()) + 'remove' + '/' + id,
   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data ' + id + ' Berhasil Dihapus');
     setTimeout(membuat_ujian_data.reloadPage(), 1000);
    } else {
     message.error('.message', 'Data ' + id + ' Gagal Dihapus');
    }

    message.closeDialog();
   }
  });
 },

 setDateTimePicker: function () {
  $('#tanggal_ujian').datepicker({
   minDate: new Date(),
   format: 'yyyy-mm-dd',
   autoclose: true,
   todayHighlight: true,
   orientation: 'bottom left',
  });
//  $('#tanggal_ujian').datepicker();
 },

 addPengawas: function (elm) {
  var pengawas = $(elm).closest('.controls');
  var new_pengawas = pengawas.clone();
  pengawas.after(new_pengawas);
 },

 removePengawas: function (elm) {
  var pengawas = $(elm).closest('.control-group').find('.controls');
  console.log(pengawas);
  if (pengawas.length > 1) {
   $(elm).closest('.controls').remove();
  } else {
   message.error('.message', 'Untuk Menghapus Pengawas Harus Lebih Dari satu');
  }
 },

 masukkanSoal: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(membuat_ujian_data.module()) + 'masukkanSoal' + '/' + ujian,
   success: function (resp) {
    bootbox.dialog({
     message:resp,
     size:'large'
    });
   }
  });
 },
 
 masukkanSoalListening: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(membuat_ujian_data.module()) + 'masukkanSoalListening' + '/' + ujian,
   success: function (resp) {
    bootbox.dialog({
     message:resp,
     size:'large'
    });
   }
  });
 },

 filterSiswaByKategoriSoal: function (elm) {
  var kategori_id = $(elm).val() == '' ? '0' : $(elm).val();
  $('.data_soal').html('Proses Mendapatkan Data...');
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   error: function () {
    message.error('.message', 'Terjadi Error di Server');
   },
   url: url.base_url(membuat_ujian_data.module()) + 'filterSiswaByKategoriSoal' + '/' + kategori_id,
   success: function (resp) {
    $('.data_soal').html(resp);
    helper.freezeHeaderTable();
   }
  });
 },
 
 filterSiswaByKategoriSoalListening: function (elm) {
  var kategori_id = $(elm).val() == '' ? '0' : $(elm).val();
  $('.data_soal').html('Proses Mendapatkan Data...');
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   error: function () {
    message.error('.message', 'Terjadi Error di Server');
   },
   url: url.base_url(membuat_ujian_data.module()) + 'filterSiswaByKategoriSoalListening' + '/' + kategori_id,
   success: function (resp) {
    $('.data_soal').html(resp);
    helper.freezeHeaderTable();
   }
  });
 },

 execChooseSoal: function () {
  var checked_soal = $('.checkbox');
  var total_checked = $('.checkbox').length;
  var counter_not_checked = 0;
  $.each(checked_soal, function () {
   var checked = $(this).is(':checked');
   if (checked) {

   } else {
    counter_not_checked += 1;
   }
  });

  if (counter_not_checked != total_checked) {
   //true
   membuat_ujian_data.execSimpanSoalHasUjian();
  } else {
   message.error('.message', 'Belum Ada Soal yang Terpilih');
  }
 },

 get_data_soal: function () {
  var data = [];
  $.each($('.checkbox'), function () {
   var soal = $(this).closest('tr').find('#id').text();
   var checked = $(this).is(':checked');
   if (checked) {
    data.push({
     'id': soal
    });
   }
  });

  return data;
 },

 get_post_data_soal: function () {
  var data = {
   'ujian': $('#ujian').val(),
   'soal': membuat_ujian_data.get_data_soal()
  };
  return data;
 },

 execSimpanSoalHasUjian: function () {
  var data = membuat_ujian_data.get_post_data_soal();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   contentType: false,
   processData: false,
   async: false,
   url: url.base_url(membuat_ujian_data.module()) + 'execSimpanSoalHasUjian',
   error: function () {
    message.error('.message', 'Terjadi Error di Server');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Soal Berhasil Dimasukkan');
     var reload = function () {
      window.location.reload();
     };

     setTimeout(reload(), 1000);
    } else {
     message.error('.message', 'Soal Gagal Dimasukkan');
    }
   }
  });
 },

 submitDataUjian: function (ujian, has_soal) {
  if (has_soal) {
   message.showDialog('Proses Submit Ujian...');
   $.ajax({
    type: 'POST',
    dataType: 'json',
    async: false,
    url: url.base_url(membuat_ujian_data.module()) + 'submitDataUjian' + '/' + ujian,
    error: function () {
     message.error('.message', 'Proses Submit Ujian Gagal');
     message.closeDialog();
    },

    success: function (resp) {
     if (resp.is_valid) {
      message.success('.message', 'Proses Submit Ujian Berhasil');
      var reload = function () {
       window.location.reload();
      };
      setTimeout(reload(), 1000);
     } else {
      message.error('.message', 'Proses Submit Ujian Gagal');
     }
     message.closeDialog();
    }
   });
  } else {
   message.error('.message', 'Belum Ada Soal yang Masuk');
  }
 }
};

$(function () {
 membuat_ujian_data.setDateTimePicker();
});