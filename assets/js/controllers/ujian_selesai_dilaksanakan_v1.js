var ujian_selesai_dilaksanakan_data = {
 module: function () {
  return 'ujian_selesai_dilaksanakan';
 },

 search: function (elm, e) {
  if (e.keyCode == 13) {
//   message.showDialog('Proses Mendapatkan Data..');
   var keyword = $(elm).val();
   $.ajax({
    type: 'POST',
    data: {keyword: keyword},
    dataType: 'html',
    async: false,
    url: ujian_selesai_dilaksanakan_data.module() + '/search',
    success: function (resp) {
     $('.data_siswa').html(resp);
//     helper.freezeHeaderTable();
//     message.closeDialog();
    }
   });
  }
 },

 reloadPage: function () {
  window.location.reload();
 },

 remove: function (id) {
  var html = '<div>';
  html += '<p>Apakah anda yakin akan menghapus data ini ? </p>';
  html += '<div class="text-right">';
  html += '<button class="btn btn-primary" onclick="ujian_selesai_dilaksanakan_data.exec_remove(' + id + ')">Ya</button> &nbsp;';
  html += '<button class="btn" onclick="message.closeDialog()">Tidak</button> &nbsp;';
  html += '</div>';
  html += '</div>';

  message.showDialog(html);
 },

 exec_remove: function (id) {
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(ujian_selesai_dilaksanakan_data.module()) + 'remove' + '/' + id,
   error: function () {
    message.error('.message', 'Data Memiliki Relasi Pada Data Lain');
    message.closeDialog();
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data ' + id + ' Berhasil Dihapus');
     setTimeout(ujian_selesai_dilaksanakan_data.reloadPage(), 1000);
    } else {
     message.error('.message', 'Data ' + id + ' Gagal Dihapus');
    }

    message.closeDialog();
   }
  });
 },
 
 downloadPDF: function(){
  var ujian = $('#ujian').val();
  window.open(url.base_url(ujian_selesai_dilaksanakan_data.module()) + 'downloadPDF' + '/' + ujian);
 }
};

$(function () {
});