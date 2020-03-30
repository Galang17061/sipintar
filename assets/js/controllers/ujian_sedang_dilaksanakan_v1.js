var ujian_sedang_dilaksanakan_data = {
 module: function () {
  return 'ujian_sedang_dilaksanakan';
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
    url: ujian_sedang_dilaksanakan_data.module() + '/search',
    success: function (resp) {
     $('.data_siswa').html(resp);
     helper.freezeHeaderTable();
//     message.closeDialog();
    }
   });
  }
 },

 reloadPage: function () {
  window.location.reload();
 }
};

$(function () {
});