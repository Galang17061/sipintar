var membuat_soal_data = {
 module: function () {
  return 'membuat_soal';
 },

 simpan: function () {
  if (validation.run()) {
   membuat_soal_data.exec_save();
  }
 },

 simpanSoal: function (elm, e) {
  e.preventDefault();
//  if (validation.run()) {
  tinymce.triggerSave();
  membuat_soal_data.exec_simpanSoal();
//  }
 },

 simpanSoalListening: function () {
  if (validation.run()) {
   membuat_soal_data.exec_simpanSoalListening();
  }
 },

 get_jawaban_soal: function () {
  var jawaban = [];
  var tr = $('table#tb_jawaban').find('tbody').find('tr');
  $.each(tr, function () {
   jawaban.push({
    'jawaban': $(this).find('textarea').val(),
    'jawaban_id': $(this).find('textarea').attr('jawaban_id'),
    'benar': $(this).find('#rd_benar').is(':checked') ? 1 : 0,
    'poin': $(this).find('#poin').val() == '' ? 0 : $(this).find('#poin').val(),
    'deleted': $(this).hasClass('deleted') ? 1 : 0
   });
  });

  return jawaban;
 },

 getDataFileName: function () {
  var data = [];
//  var fileUpload = $('.fileUpload');
  var fileUpload = $('.file_uploaded');
  $.each(fileUpload, function () {
   var file = $(this).val();
   data.push({
    'fileName': file
   });
  });

  return data;
 },

 get_post_data_soal: function () {
  var data = {
   'id': $('#id_soal').val(),
   'kategori_soal': $('#kategori_soal').val(),
   'soal': $('#soal').val(),
   'jawaban': membuat_soal_data.get_jawaban_soal(),
  };

  return data;
 },

 getAttachmentFile: function () {
  var data = [];
//  var fileUpload = $('.fileUpload');
  var fileUpload = $('.file_uploaded');
  $.each(fileUpload, function () {
   var file = $(this).prop('files')[0];
   data.push(file);
  });

  return data;
 },

 exec_simpanSoal: function () {
  var data = membuat_soal_data.get_post_data_soal();
//  console.log($('#jawaban_a').val());
//  console.log($('#jawaban_b').val());
//  console.log(data);
//  return;
//  var fileData = membuat_soal_data.getAttachmentFile();

  var formData = new FormData();
  formData.append('data', JSON.stringify(data));
//
//  for (var i = 0; i < fileData.length; i++) {
//   formData.append('file' + i, fileData[i]);
//  }
//
//  formData.append('soalFile', $('#soalFile').prop('files')[0]);
  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   processData: false,
   contentType: false,
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'simpanSoal',
   error: function () {
    message.error('.message', 'Data Gagal Disimpan');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data Berhasil Disimpan');
     membuat_soal_data.resetformInput();
     var reload = function () {
      window.location.reload();
     };
     setTimeout(reload(), 1000);
     console.log(resp);
    } else {
     message.error('.message', 'Data Gagal Disimpan');
    }

    membuat_soal_data.resetformInput();
   }
  });
 },

 exec_simpanSoalListening: function () {
  var data = membuat_soal_data.get_post_data_soal();
  var fileData = membuat_soal_data.getAttachmentFile();

  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  for (var i = 0; i < fileData.length; i++) {
   formData.append('file' + i, fileData[i]);
  }

  formData.append('soalFile', $('#soalFile').prop('files')[0]);
  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   processData: false,
   contentType: false,
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'simpanSoalListening',
   error: function () {
    message.error('.message', 'Data Gagal Disimpan');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data Berhasil Disimpan');
     membuat_soal_data.resetformInput();
     var reload = function () {
      window.location.reload();
     };
     setTimeout(reload(), 1000);
    } else {
     message.error('.message', 'Data Gagal Disimpan');
    }

    membuat_soal_data.resetformInput();
   }
  });
 },

 addKategoriSoal: function (e) {
  e.preventDefault();
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'addKategoriSoal',
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 editKategoriSoal: function (e, kategori) {
  e.preventDefault();
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'editKategoriSoal' + '/' + kategori,
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 makeSoal: function (e) {
  e.preventDefault();
  var ujian = $('.tr_choose').find('#id').text();
  if (ujian == '') {
   message.error('.message', 'Anda Harus Memilih Soal Terlebih Dahulu');
  } else {
   window.location = url.base_url(membuat_soal_data.module()) + 'makeSoal' + '/' + ujian;
  }

 },

 make: function (e) {
  e.preventDefault();
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'listUjianView',
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 chooseUjian: function (elm, ujian) {
  if ($(elm).hasClass('tr_choose')) {
   $(elm).removeClass('tr_choose');
   $(elm).find('td').css({
    'background': '#f9f9f9',
    'color': '#333'
   });
  } else {
   $(elm).addClass('tr_choose');
   $(elm).find('td').css({
    'background': '#08c',
    'color': '#fff'
   });
  }
 },

 get_post_data_kategori: function () {
  var data = {
   'id': $('#id_kategori').val(),
   'mata_pelajaran': $('#mata_pelajaran').val(),
   'kategori': $('#kategori').val(),
   'poin_by': $('#poin_by').val()
  };
  return data;
 },

 simpanKategori: function () {
  if ($('#kategori').val() != '') {
   var data = membuat_soal_data.get_post_data_kategori();
   var formData = new FormData();
   formData.append('data', JSON.stringify(data));

   $.ajax({
    type: 'POST',
    data: formData,
    dataType: 'json',
    processData: false,
    contentType: false,
    async: false,
    url: url.base_url(membuat_soal_data.module()) + 'simpanKategori',
    success: function (resp) {
     if (resp.is_valid) {
      if ($('#id').val() != '') {
       message.success('.message', 'Data Berhasil Diperbaharui');
      } else {
       message.success('.message', 'Data Berhasil Disimpan');
      }
      membuat_soal_data.resetformInput();
      var reload = function () {
       window.location.reload();
      };
      setTimeout(reload(), 1000);
     } else {
      if ($('#id').val() != '') {
       message.error('.message', 'Data Gagal Diperbaharui');
      } else {
       message.error('.message', 'Data Gagal Disimpan');
      }
     }
    }
   });
  } else {
   $('#kategori').after('<p style="color:red" class="data-error">* ' + $('#kategori').attr('error') + ' Harus Diisi</p>');
  }
 },

 get_post_data: function () {
  var data = {
   'id': $('#id').val(),
   'membuat_soal': $('#membuat_soal').val()
  };

  return data;
 },

 exec_save: function () {
  var data = membuat_soal_data.get_post_data();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   contentType: false,
   processData: false,
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'save',
   success: function (resp) {
    if (resp.is_valid) {
     if ($('#id').val() != '') {
      message.success('.message', 'Data Berhasil Diperbaharui');
     } else {
      message.success('.message', 'Data Berhasil Disimpan');
     }
    } else {
     if ($('#id').val() != '') {
      message.error('.message', 'Data Gagal Diperbaharui');
     } else {
      message.error('.message', 'Data Gagal Disimpan');
     }
    }

    membuat_soal_data.resetformInput();
   }
  });
 },

 resetformInput: function () {
  $.each($('.required'), function () {
   $(this).val('');
  });

  $.each($('.fileUpload'), function () {
   $(this).val('');
  });

  $('#soalFile').val('');
 },

 setLimitSoal: function (kategori) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'setLimitSoal' + '/' + kategori,
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 aturLimitSoal: function () {
//  console.log('atur');
//  return;
  $.ajax({
   type: 'POST',
   data: {
    kategori_soal: $('#kategori_id').val(),
    ujian: $('#ujian_id').val(),
    limit_soal_keluar: $('#limit_soal_keluar').val()
   },
   dataType: 'json',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'aturLimitSoal',
   error: function () {
    message.error('.message', 'Data Gagal Disimpan');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data Berhasil Disimpan');
     var reload = function () {
      window.location.reload();
     };
     setTimeout(reload(), 1000);
    } else {
     message.error('.message', resp.message);
    }
   }
  });
 },

 search: function (elm, e) {
  if (e.keyCode == 13) {
   message.showDialog('Proses Mendapatkan Data..');
   var keyword = $(elm).val();
   $.ajax({
    type: 'POST',
    data: {keyword: keyword},
    dataType: 'html',
    async: false,
    url: membuat_soal_data.module() + '/search',
    success: function (resp) {
     $('.data').html(resp);
     helper.freezeHeaderTable();
     message.closeDialog();
    }
   });
  }
 },

 remove: function (id) {
  var html = '<div>';
  html += '<p>Apakah anda yakin akan menghapus data ini ? </p>';
  html += '<div class="text-right">';
  html += '<button class="btn btn-primary" onclick="membuat_soal_data.exec_remove(' + id + ')">Ya</button> &nbsp;';
  html += '<button class="btn" onclick="message.closeDialog()">Tidak</button> &nbsp;';
  html += '</div>';
  html += '</div>';

  message.showDialog(html);
 },

 removeSoal: function (id) {
  var html = '<div>';
  html += '<p>Apakah anda yakin akan menghapus data ini ? </p>';
  html += '<div class="text-right">';
  html += '<button class="btn btn-primary" onclick="membuat_soal_data.exec_removeSoal(' + id + ')">Ya</button> &nbsp;';
  html += '<button class="btn" onclick="message.closeDialog()">Tidak</button> &nbsp;';
  html += '</div>';
  html += '</div>';

  message.showDialog(html);
 },

 removeKategori: function (id) {
  var html = '<div>';
  html += '<p>Apakah anda yakin akan menghapus data ini ? </p>';
  html += '<div class="text-right">';
  html += '<button class="btn btn-primary" onclick="membuat_soal_data.exec_removeKategori(' + id + ')">Ya</button> &nbsp;';
  html += '<button class="btn" onclick="message.closeDialog()">Tidak</button> &nbsp;';
  html += '</div>';
  html += '</div>';

  message.showDialog(html);
 },

 reloadPage: function () {
  window.location.reload();
 },

 exec_remove: function (id) {
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'remove' + '/' + id,
   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data ' + id + ' Berhasil Dihapus');
     setTimeout(membuat_soal_data.reloadPage(), 1000);
    } else {
     message.error('.message', 'Data ' + id + ' Gagal Dihapus');
    }

    message.closeDialog();
   }
  });
 },

 exec_removeKategori: function (id) {
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'removeKategori' + '/' + id,
   error: function () {
    message.error('.message_kategori', 'Data ' + id + ' Masih Ada Hubungan dengan Data Soal');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message_kategori', 'Data ' + id + ' Berhasil Dihapus');
     setTimeout(membuat_soal_data.reloadPage(), 1000);
    } else {
     message.error('.message_kategori', 'Data ' + id + ' Gagal Dihapus');
    }

    message.closeDialog();
   }
  });
 },

 exec_removeSoal: function (id) {
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'removeSoal' + '/' + id,
   error: function () {
    message.error('.message', 'Data ' + id + ' Masih Ada Hubungan dengan Data Soal');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Data ' + id + ' Berhasil Dihapus');
     setTimeout(membuat_soal_data.reloadPage(), 1000);
    } else {
     message.error('.message', 'Data ' + id + ' Gagal Dihapus');
    }

    message.closeDialog();
   }
  });
 },

 setFormUpload: function () {
//  $(".fileUpload").uniform();
//  $(".soalUpload").uniform();
 },

 submitSoal: function (ujian) {
  message.showDialog('Proses Submit Soal...');
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + 'submitSoal' + '/' + ujian,
   error: function () {
    message.error('.message', 'Proses Submit Soal Gagal');
    message.closeDialog();
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Proses Submit Soal Berhasil');
     var reload = function () {
      window.location.reload();
     };
     setTimeout(reload(), 1000);
    } else {
     message.error('.message', 'Proses Submit Soal Gagal');
    }
    message.closeDialog();
   }
  });
 },

 setTinyMCE: function () {
  tinymce.init({
   paste_data_images: true,
   selector: 'textarea',
   menubar: 'insert',
   theme: 'modern',
   plugins: 'table charmap tiny_mce_wiris image',
   file_picker_types: 'image',
   image_title: true,
   automatic_uploads: true,
   file_picker_callback: function (cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.onchange = function () {
     var file = this.files[0];
//     $(this).attr('ondrag', 'membuatl_soal_data.dragImage()');

     var reader = new FileReader();
     reader.onload = function () {
      var id = 'blobid' + (new Date()).getTime();
      var blobCache = tinymce.activeEditor.editorUpload.blobCache;
      var base64 = reader.result.split(',')[1];
      var blobInfo = blobCache.create(id, file, base64);
      blobCache.add(blobInfo);

      // call the callback and populate the Title field with the file name
      cb(blobInfo.blobUri(), {title: file.name});
     };
     reader.readAsDataURL(file);
    };

    input.click();
   },
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry tiny_mce_wiris_CAS",
  });
 },

 getData: function (elm, e) {
  e.preventDefault();
  tinymce.triggerSave();
  console.log($('#soal').val());
 },

 drageImage: function () {
//  $('img').draggable();
  $('#coba').draggable({
   drag: function (event, ui) {
    console.log('asdasdasd');
//    var left = parseFloat(ui.position.left).toFixed(2) / 10;
//    var top = parseFloat(ui.position.top).toFixed(2) / 10;
//    var height = parseFloat($(ui.helper).height()).toFixed(2) / 10;
//    var width = parseFloat($(ui.helper).width()).toFixed(2) / 10;
//
//    kavling.set_detail_ukuran_kavling(left, top, width, height);
   }
  });
 },

 nilaiBobot: function (elm, e) {
  e.preventDefault();
  var id = $(elm).attr('data_id');

  $.ajax({
   type: 'POST',
   data: {
    kategori_id: id
   },
   dataType: 'html',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + "nilaiBobot",
   error: function () {
    toastr.error("Gagal");
    message.closeLoading();
   },

   beforeSend: function () {

   },

   success: function (resp) {
    bootbox.dialog({
     message: resp
    });
   }
  });
 },

 simpanBobot: function (elm) {
  var id = $('input#kategori_id').val();
  var bobot_id = $('input#bobot_id').val();
  var nilai_benar = $('input#nilai_benar').val();
  var nilai_salah = $('input#nilai_salah').val();
  var nilai_kosong = $('input#nilai_kosong').val();

//  console.log("benar",nilai_benar);
//  
//  return;
  $.ajax({
   type: 'POST',
   data: {
    kategori_id: id,
    bobot_id: bobot_id,
    'nilai_kosong': nilai_kosong,
    nilai_salah: nilai_salah,
    nilai_benar: nilai_benar
   },
   dataType: 'json',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + "simpanBobot",
   error: function () {
    toastr.error("Gagal");
   },

   beforeSend: function () {

   },

   success: function (resp) {
    message.closeDialog();
    if (resp.is_valid) {
     toastr.success('Berhasil Disimpan');
    } else {
     toastr.error('Gagal Disimpan');
    }
   }
  });
 },

 addItemJawaban: function (elm) {
  var tr_index = $(elm).closest('tbody').find('tr:last');

  $.ajax({
   type: 'POST',
   data: {
    index: tr_index.index()
   },
   dataType: 'html',
   async: false,
   url: url.base_url(membuat_soal_data.module()) + "addItemJawaban",
   error: function () {
    toastr.error("Gagal");
   },

   beforeSend: function () {

   },

   success: function (resp) {
    var new_tr = tr_index.clone();
    new_tr.html(resp);
    tr_index.after(new_tr);
   }
  });
 },

 deleteItemJawaban: function (elm) {
  var data_id = $(elm).attr('data_id');

  if (data_id != '') {
   $(elm).closest('tr').addClass('hide');
   $(elm).closest('tr').addClass('deleted');
  } else {
   $(elm).closest('tr').remove();
  }
 }
};

$(function () {
 membuat_soal_data.setFormUpload();
 membuat_soal_data.setTinyMCE();
// helper.setMaterialImageDialog();
// membuat_soal_data.drageImage();
});