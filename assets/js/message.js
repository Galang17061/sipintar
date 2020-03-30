var message = {
 success: function (elm, message) {
  var html = '<div class="alert alert-success">';
  html += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
  html += '<h4>Success</h4>';
  html += message;
  html += '</div>';

  $(elm).html(html);
 },
 
 error: function (elm, message) {
  var html = '<div class="alert alert-error">';
  html += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
  html += '<h4>Error</h4>';
  html += message;
  html += '</div>';

  $(elm).html(html);
 },
 
 showDialog: function(content){
  bootbox.dialog({
   message: content
  });
 },

 showMaterialDialog: function(title, message){
  $('.modal').find('#title_modal').text(title);
  $('.modal').find('.message_modal').html(message);
//  console.log($('.modal'));
  $('.modal').modal();
 },
 
 closeDialog: function(){
  $('.bootbox-close-button').click();
 },
 
 //untuk menampilkan tooltip
 show_tooltip: function (elm) {
  $(elm).tooltip({placement: 'bottom'});
 },
 
 showCustomTooltip: function(elm, position = 'bottom'){
  $(elm).tooltip({placement: position});
 },
 
 loadingProses: function(message){
  var loader = '<div class="loader loader-default is-active" data-text="'+message+'"></div>';
  $('.loader').html(loader);
 },
 
 closeLoading: function(){
  $('div.loader').removeClass('is-active');
 }
};