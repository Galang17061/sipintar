var daftar_ujian_ready_data = {
 module: function () {
  return 'daftar_ujian_ready';
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
    url: daftar_ujian_ready_data.module() + '/search',
    success: function (resp) {
     $('.data_siswa').html(resp);
//     helper.freezeHeaderTable();
//     message.closeDialog();
    }
   });
  }
 },

 checkTokenUjian: function (elm) {
  var token_input = $('#token').val();
  if (token_input == '') {
   message.error('.message', 'Token Harus Diisi');
   return;
  }
  var ujian = $(elm).attr('ujian');
  var token = $(elm).attr('token');
  $.ajax({
   type: 'POST',
   data: {
    token_input: token_input
   },
   dataType: 'json',
   async: false,
   url: url.base_url(daftar_ujian_ready_data.module()) + 'checkTokenUjian' + '/' + ujian + '/' + token,
   error: function () {
    message.error('.message', 'Jaringan Error');
   },

   success: function (resp) {
    if (resp.is_valid) {
     window.location = url.base_url('task_soal') + 'kerjakanUjian' + '/' + ujian;
    } else {
     message.error('.message', 'Token tidak valid');
    }
   }
  });
 },

 showinsertTokenUjian: function (ujian, token) {
  var html = "<div>";
  html += '<div class="message"></div>';
  html += '<div class="row">';
  html += "<div class='col-md-12'><input type='text' id='token' value='' placeholder= 'Masukkan Token Ujian Ini' class='form-control'/><br></div>";  
  html += "</div>";
  html += '<div class="row">';
  html += "<div class='col-md-12 text-right'><button token='" + token + "' ujian='" + ujian + "' class='btn btn-primary' onclick='daftar_ujian_ready_data.checkTokenUjian(this)'>Proses</button></div>";
  html += "</div>";
  html += "</div>";
  message.showDialog(html);
 },

 kerjakanUjian: function (siswa_has_ujian, ujian, token) {
  daftar_ujian_ready_data.showinsertTokenUjian(ujian, token);
//  window.location = url.base_url('task_soal') + 'kerjakanUjian' + '/' + ujian;
 }
};

$(function () {

});