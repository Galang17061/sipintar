var TesRead = {
 read: function (elm, e) {
//  console.log($(elm).get(0).files[0]);
//  return;
//  var zip = new JSZip(elm);
//  console.log(zip);
  var file_word = $(elm).get(0).files[0];
//  var data_from_file = file_word.name.split('.');
//  var type_file = $.trim(data_from_file[data_from_file.length - 1]);
  var reader = new FileReader();
  reader.readAsDataURL(file_word);

  reader.onload = function (event) {
   var data_word;
   var word = event.target.result;
   console.log(word);
//   data_csv = helper.processExtractCsv(csv);
//   var csv_data = [];
//   for (var i = 0; i < data_csv.length; i++) {
//    csv_data.push(data_csv[i]);
//   }

//   bank_soal_data.execUploadFileSoal(csv_data);
  };

 }
};