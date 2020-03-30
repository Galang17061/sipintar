var dashboard = {
 module: function () {
  return 'dashboard';
 },

 onCloseWindow: function () {
  alert('asdadasd');
 },

 hover: function (elm) {
  $(elm).addClass('tr_hover');
 },

 mouseOut: function (elm) {
  $(elm).removeClass('tr_hover');
 },

 getDataPesertaUjian: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(dashboard.module()) + 'getDataPeserta' + '/' + ujian,
   beforeSend: function(){
    var html = '<tr><td colspan="5">Proses Mendapatkan Data...</td></tr>';
    $('.peserta_ujian').find('tbody').html(html);
    $('.peserta_submit').find('tbody').html(html);
   },
   
   error: function(){
    message.showDialog('Jaringan Error');
   },
   
   success: function (resp) {
    $('.data_peserta_ujian').html(resp.view_peserta_ujian);
    $('.data_peserta_submit').html(resp.view_peserta_submit);
    $('.data_peserta_ujian').closest('.col-md-6').find('.badge-info').text(resp.jumlah_peserta_ujian);
    $('.data_peserta_submit').closest('.col-md-6').find('.badge-info').text(resp.jumlah_peserta_submit);
   }
  });
 }
};

$(function () { 
// window.addEventListener("beforeunload", function (event) {
//  event.preventDefault();
// });
});