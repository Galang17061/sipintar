var daftar_ujian_data = {
 module: function () {
  return 'daftar_ujian';
 },

 simpan: function () {
  if (validation.run()) {
   daftar_ujian_data.exec_save();
  }
 },

 get_post_data: function () {
  var data = {
   'id': $('#id').val(),
   'nama': $('#nama').val(),
   'nip': $('#nip').val(),
   'password': $('#password').val(),
   'mata_pelajaran': $('#mata_pelajaran').val()
  };

  return data;
 },

 exec_save: function () {
  var data = daftar_ujian_data.get_post_data();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   contentType: false,
   processData: false,
   async: false,
   url: url.base_url(daftar_ujian_data.module()) + 'save',
   error: function () {
    message.error('.message', 'Jaringan Error');
   },

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

    daftar_ujian_data.resetformInput();
   }
  });
 },

 resetformInput: function () {
  $('#mata_pelajaran').val('');
  $('#nama').val('');
  $('#nip').val('');
  $('#password').val('');
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
    url: daftar_ujian_data.module() + '/search',
    success: function (resp) {
     $('.data_siswa').html(resp);
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
  html += '<button class="btn btn-primary" onclick="daftar_ujian_data.exec_remove(' + id + ')">Ya</button> &nbsp;';
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
   url: url.base_url(daftar_ujian_data.module()) + 'remove' + '/' + id,
   error: function () {
    message.error('.message', 'Data Memiliki Relasi Pada Data Lain');
    message.closeDialog();
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data ' + id + ' Berhasil Dihapus');
     setTimeout(daftar_ujian_data.reloadPage(), 1000);
    } else {
     message.error('.message', 'Data ' + id + ' Gagal Dihapus');
    }

    message.closeDialog();
   }
  });
 }
};

$(function () {

});