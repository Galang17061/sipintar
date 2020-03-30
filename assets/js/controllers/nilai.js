var nilai_data = {
 module: function () {
  return 'nilai';
 },

 simpan: function () {
  if (validation.run()) {
   nilai_data.exec_save();
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
  var data = nilai_data.get_post_data();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   contentType: false,
   processData: false,
   async: false,
   url: url.base_url(nilai_data.module()) + 'save',
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

    nilai_data.resetformInput();
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
  if (e.keyCode == 13 && $(elm).val() != '') {
   message.showDialog('Proses Mendapatkan Data..');
   var keyword = $(elm).val();
   $.ajax({
    type: 'POST',
    data: {keyword: keyword},
    dataType: 'html',
    async: false,
    url: nilai_data.module() + '/search',
    success: function (resp) {
     $('.data_siswa').html(resp);
     helper.freezeHeaderTable();
     message.closeDialog();
    }
   });
  }
 },

 reloadPage: function () {
  window.location.reload();
 },

 detailAllNilai: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(nilai_data.module()) + 'detailAllNilai' + '/' + ujian,
   success: function (resp) {
    message.showDialog(resp);
    helper.freezeHeaderTable();
   }
  });
 },

 detailJawaban: function (ujian, siswa) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   contentType: false,
   processData: false,
   url: url.base_url(nilai_data.module()) + 'detailJawaban' + '/' + ujian+'/'+siswa,
   success: function (resp) {    
    message.showDialog(resp);
    helper.freezeHeaderTable();
   }
  });
 },
 
 downloadPDFNilai: function(){
  var ujian = $('#ujian').val();
//  $.ajax({
//   type: 'POST',
//   data: {},
//   dataType: 'html',
//   processData: false,
//   contentType: false,
//   async: false,
//   url: url.base_url(nilai_data.module()) + 'downloadPDFNilai' + '/' + ujian,
//   success: function (resp) {
//    
//   }
//  });
  window.open(url.base_url(nilai_data.module())+ 'downloadPDFNilai' + '/' + ujian);
 }
};

$(function () {

});