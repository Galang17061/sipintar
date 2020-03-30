var bank_soal_listening_data = {
 module: function () {
  return 'bank_soal_listening';
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
    url: bank_soal_listening_data.module() + '/search',
    success: function (resp) {
     $('.data').html(resp);
     helper.freezeHeaderTable();
     message.closeDialog();
    }
   });
  }
 },

 edit: function (soal_id) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(bank_soal_listening_data.module()) + 'edit' + '/' + soal_id,
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 editSoal: function () {
  if (validation.run()) {
   bank_soal_listening_data.exec_editSoal();
  }
 },

 exec_editSoal: function () {
  var soal = $('#id_soal').val();
  var data = membuat_soal_data.get_post_data_soal();
  var fileData = membuat_soal_data.getAttachmentFile();

  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  for (var i = 0; i < fileData.length; i++) {
   formData.append('file' + i, fileData[i]);
  }

  formData.append('soalFile', $('#soalFile').prop('files')[0]);
  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   processData: false,
   contentType: false,
   async: false,
   url: url.base_url(bank_soal_listening_data.module()) + 'exec_editSoal',
   error: function () {
    message.error('.message', 'Data Gagal Disimpan');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data Berhasil Disimpan');
     membuat_soal_data.resetformInput();
     var reload = function () {
      window.location.reload();
     };
     setTimeout(reload(), 1000);
    } else {
     message.error('.message', 'Data Gagal Disimpan');
    }

    membuat_soal_data.resetformInput();
   }
  });
 },

 showFileAnswerBefore: function (nama_file, jawaban_id) {
  $.ajax({
   type: 'POST',
   data: {
    nama_file: nama_file,
    jawaban_id: jawaban_id
   },
   dataType: 'html',
   async: false,
   url: url.base_url(bank_soal_listening_data.module()) + 'showFileAnswerBefore',
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 showFileSoalBefore: function (nama_file) {

 },

 importSoal: function () {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(bank_soal_listening_data.module()) + 'importSoal',
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 execUploadFileSoal: function (csv_data) {
  var data = csv_data;
  var formData = new FormData();
  formData.append('data', JSON.stringify(csv_data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   processData: false,
   contentType: false,
   async: false,
   url: url.base_url(bank_soal_listening_data.module()) + 'execUploadFileSoal',
   beforeSend: function () {
    $('.loading_data').html('<i class="mdi mdi-autorenew mdi-18px">Proses Uploaded.....</i>');
   },

   error: function () {
    message.error('.message', 'Jaringan Bermasalah');
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
    $('.loading_data').html('');
   }
  });
 },

 getUploadedData: function (elm) {
  if (window.FileReader) {
   var file_csv = $(elm).get(0).files[0];
   var data_from_file = file_csv.name.split('.');
   var type_file = $.trim(data_from_file[data_from_file.length - 1]);

   if (type_file == 'csv') {
    if (file_csv.size <= 512000) {
     var reader = new FileReader();
     reader.readAsText(file_csv);

     reader.onload = function (event) {
      var data_csv;
      var csv = event.target.result;
      data_csv = helper.processExtractCsv(csv);
      var csv_data = [];
      for (var i = 0; i < data_csv.length; i++) {
       csv_data.push(data_csv[i]);
      }

      bank_soal_listening_data.execUploadFileSoal(csv_data);
     };
    } else {
     message.error('.message', 'Gagal Upload, Ukuran File Maximal 512 KB');
    }
   } else {
    message.error('.message', 'File Harus Berformat csv');
    $(elm).val('');
   }
  } else {
   message.error('.message', 'FileReader is Not Supported');
  }
 },
 
 ambilSimbol: function(){
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(bank_soal_listening_data.module()) + 'ambilSimbol',
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 }
};

$(function () {

});