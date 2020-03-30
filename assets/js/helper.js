//var csv_data = [];
var helper = {
 freezeHeaderTable: function () {
  $(document).trigger('stickyTable');
 },

 checkAllRadio: function (elm) {
  var checked = $(elm).is(':checked');
  var all_check = $('.checkbox');
  $.each(all_check, function () {
   $(this).prop('checked', checked);
  });
 },

 checkedData: function (elm) {
  var total_checked = $('.checkbox').length;
  var counter = 0;
  $.each($('.checkbox'), function () {
   if ($(this).is(':checked')) {
    counter += 1;
   }
  });

  if (total_checked == counter) {
   $(elm).prop('checked', true);
  } else {
   $(elm).prop('checked', false);
  }
 },

 readCSV: function (elm) {
  if (window.FileReader) {
   var file_csv = $(elm).get(0).files[0];
   var data_from_file = file_csv.name.split('.');
   var type_file = $.trim(data_from_file[data_from_file.length - 1]);

   if (type_file == 'csv') {
    var reader = new FileReader();
    reader.readAsText(file_csv);
    
    reader.onload = function (event) {
     var data_csv;
     var csv = event.target.result;
     data_csv = helper.processExtractCsv(csv);
     var csv_data = [];
     for (var i = 0; i < data_csv.length; i++) {      
      csv_data.push(data_csv[i]);
//      console.log(data_csv[i]);
//      csv_data.push(data_csv[i]);
     }
     
//     return csv_data;
    };
   } else {
    message.error('.message', 'File Harus Berformat csv');
    $(elm).val('');
   }
  } else {
   message.error('.message', 'FileReader is Not Supported');
  }
 },

 processExtractCsv: function (fileCSV) {
  var alltextLine = fileCSV.split(/\r\n|\n/);
  var lines = [];
  for (var i = 0; i < alltextLine.length; i++) {
//   var data = alltextLine[i].split(',');
   var data = alltextLine[i].split(';');
   var tarr = [];
   for (var j = 0; j < data.length; j++) {
    tarr.push(data[j]);
   }
   lines.push(tarr);
  }
  return lines;
 },
 
 setMaterialImageDialog: function(){
  $('.materialboxed').materialbox();
 },
 
 setToolTip: function(){
  console.log($('.tooltipped'));
  $('.tooltipped').tooltip();
 },
 
 getSideNavigation: function(){
  $('.sidenav').sidenav();
 },
 
 setCollapse: function(){
  $('.collapsible').collapsible();
 }
};