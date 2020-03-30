var pelajaran_data = {
 module: function () {
  return 'pelajaran';
 },

 simpan: function () {
  if (validation.run()) {
   pelajaran_data.exec_save();
  }
 },

 get_post_data: function () {
  var data = {
   'id': $('#id').val(),
   'mata_pelajaran': $('#mata_pelajaran').val()
  };

  return data;
 },

 exec_save: function () {
  var data = pelajaran_data.get_post_data();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   contentType: false,
   processData: false,
   async: false,
   url: url.base_url(pelajaran_data.module()) + 'save',
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

    pelajaran_data.resetformInput();
   }
  });
 },

 resetformInput: function () {
  $('#mata_pelajaran').val('');
 },

 search: function (elm, e) {
  if (e.keyCode == 13 && $(elm).val() !='') {
   message.showDialog('Proses Mendapatkan Data..');
   var keyword = $(elm).val();
   $.ajax({
    type: 'POST',
    data: {keyword: keyword},
    dataType: 'html',
    async: false,
    url: pelajaran_data.module() + '/search',
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
  html += '<button class="btn btn-primary" onclick="pelajaran_data.exec_remove(' + id + ')">Ya</button> &nbsp;';
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
   url: url.base_url(pelajaran_data.module()) + 'remove' + '/' + id,
   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data ' + id + ' Berhasil Dihapus');
     setTimeout(pelajaran_data.reloadPage(), 1000);
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