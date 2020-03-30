var get_file = []; //for insert file
var get_data = []; //for insert data
var file_data_exist = '';
var upload_data = {
 get_data_file: function(){
  
 },
 
 getFile: function (elm, e) {
  var file = $(elm).get(0).files[0] ? $(elm).get(0).files[0] : '';

  if(file){
   var file_name = file.name;
   var file_type = file.type;
   var file_size = file.size;
   var sha1 = upload_data.getSha1File(file, file_name);
  }
  return file;
 },
 
 getSha1File: function (obj_file, filename) {
  var formData = new FormData();
  formData.append('file', obj_file);

  $.ajax({
   type: 'POST',
   data: formData,
   async: false,
   processData: false,
   contentType: false,
   dataType: 'html',
   url: url.base_url('upload') + 'getFileSha1',
   success: function (data) {
    filename = data;
   }
  });
  return filename;
 },
 
 validationSize: function(elm, size){
  var file = $(elm).get(0).files[0];
  var file_name = file.name;
  var file_type = file.type;
  var file_size = file.size;
  
  var setNameFiletoTextInput = $(elm).closest('.input-field').find('.file-path').val(file_name).css({
   'font-size':'12px'
  });
  if(file_size > size){
   message.error('.message', 'File Terlalu Besar');
   $(elm).closest('.input-field').find('.file-path').val('');
  }
 },
 
 upload: function () {
  var formData = new FormData();
  formData.append('file', JSON.stringify(get_file));

  for (var i = 0; i < get_data.length; i++) {
   formData.append('files' + i, get_data[i]);
  }
  $.ajax({
   type: 'POST',
   data: formData,
   async: false,
   processData: false,
   contentType: false,
   dataType: 'html',
   url: 'upload/upload_data',
   success: function (data) {
    console.log(data);
   }
  });
 },
}