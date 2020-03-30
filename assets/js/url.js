var url = {
 base_url: function (module) {
  var url_host = window.location.host;
  var url_protocol = window.location.protocol;
  return url_protocol + '//' + url_host + '/' + 'sipintar' + '/' + module + '/';
 }
};