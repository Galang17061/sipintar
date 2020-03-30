var pengaturan_nilai_data = {
 module: function () {
  return 'pengaturan_nilai';
 },
 
 tampilkan: function(elm, id){
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(pengaturan_nilai_data.module()) + 'tampilkan' + '/' + id,
   error:function(){
    message.error('.message', 'Jaringan Error');
   },
   
   success: function (resp) {
    if(resp.is_valid){
     message.success('.message', 'Nilai Berhasil Ditampilkan');
     $(elm).closest('tr').find('#nilai_status').text('Nilai Ditampilkan');
    }else{
     message.error('.message', 'Nilai Gagal Ditampilkan');
    }
   }
  });
 },
 
 tidakTampilkan: function(elm, id){
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(pengaturan_nilai_data.module()) + 'tidakTampilkan' + '/' + id,
   error:function(){
    message.error('.message', 'Jaringan Error');
   },
   
   success: function (resp) {
    if(resp.is_valid){
     message.success('.message', 'Nilai Berhasil Tidak Ditampilkan');
     $(elm).closest('tr').find('#nilai_status').text('Nilai Tidak Ditampilkan');
    }else{
     message.error('.message', 'Nilai Gagal Ditampilkan');
    }
   }
  });
 }
};

$(function () {

});