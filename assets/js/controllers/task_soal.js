var task_soal_data = {
 module: function () {
  return 'task_soal';
 },

 resetformInput: function () {
  $('#ujian_siap_dilaksanakan').val('');
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
    url: task_soal_data.module() + '/search',
    success: function (resp) {
     $('.data').html(resp);
     helper.freezeHeaderTable();
     message.closeDialog();
    }
   });
  }
 },

 reloadPage: function () {
  window.location.reload();
 },

 chooseSiswa: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(task_soal_data.module()) + 'chooseSiswa' + '/' + ujian,
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 checkAllSiswa: function (elm) {
  var checked = $(elm).is(':checked');
  var all_siswa_check = $('.checkbox');
  $.each(all_siswa_check, function () {
   $(this).prop('checked', checked);
  });
 },

 checkedSiswa: function () {
  var total_checked = $('.checkbox').length;
  var counter = 0;
  $.each($('.checkbox'), function () {
   if ($(this).is(':checked')) {
    counter += 1;
   }
  });

  if (total_checked == counter) {
   $('#pilih_siswa_all').prop('checked', true);
  } else {
   $('#pilih_siswa_all').prop('checked', false);
  }
 },

 filterSiswaByJurusan: function (elm) {
  var jurusan_id = $(elm).val();
  message.showDialog('Proses Mendapatkan Data...');
  $.ajax({
   type: 'POST',
   data: {data: ''},
   dataType: 'html',
   contentType: false,
   processData: false,
   url: url.base_url(task_soal_data.module()) + 'filterSiswaByJurusan' + '/' + jurusan_id,
   success: function (resp) {
    $('.data_siswa').html(resp);
    helper.freezeHeaderTable();
   }
  });
 },

 startUjian: function (elm) {
  var peserta_ujian = parseInt($(elm).closest('tr').find('#peserta_ujian').text());
  var limit_waktu_ujian = $.trim($(elm).closest('tr').find('#limit_waktu_ujian').text());
  var kode_ujian = $(elm).closest('tr').find('#kode_ujian').text();

  if (peserta_ujian <= 0) {
   message.error('.message', 'Belum Ada Peserta Ujian pada Kode Ujian : ' + kode_ujian);
  }

  if (limit_waktu_ujian == '0') {
   message.error('.message', 'Limit Waktu Ujian belum diatur pada Kode Ujian : ' + kode_ujian);
  }
 },

 aturWaktuUjian: function (ujian) {
  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(task_soal_data.module()) + 'aturWaktuUjian' + '/' + ujian,
   success: function (resp) {
    message.showDialog(resp);
   }
  });
 },

 execAturWatuUjian: function () {
  if (validation.run()) {
   var ujian = $('#ujian').val();
   var time_limit = $('#list_waktu').val();
   $.ajax({
    type: 'POST',
    data: {
     ujian: ujian,
     time_limit: time_limit
    },
    dataType: 'json',
    async: false,
    url: url.base_url(task_soal_data.module()) + 'execAturWatuUjian',
    error: function () {
     message.error('.message', 'Waktu Ujian Gagal DiAtur');
    },

    success: function (resp) {
     if (resp.is_valid) {
      message.success('.message', 'Waktu Ujian Berhasil DiAtur');
      var reload = function () {
       window.location.reload();
      };

      setTimeout(reload(), 1000);
     } else {
      message.error('.message', 'Waktu Ujian Gagal DiAtur');
     }
    }
   });
  }
 },

 setForm: function () {
  $('.uniform_on').uniform();
 },

 execChooseSiswa: function () {
  var checked_siswa = $('.checkbox');
  var total_checked = $('.checkbox').length;
  var counter_not_checked = 0;
  $.each(checked_siswa, function () {
   var checked = $(this).is(':checked');
   if (checked) {

   } else {
    counter_not_checked += 1;
   }
  });

  if (counter_not_checked != total_checked) {
   //true
   task_soal_data.execSimpanSiswaHasUjian();
  } else {
   message.error('.message', 'Belum Ada Siswa yang Terpilih');
  }
 },

 get_data_siswa: function () {
  var data = [];
  $.each($('.checkbox'), function () {
   var siswa = $(this).closest('tr').find('#id').text();
   var checked = $(this).is(':checked');
   if (checked) {
    data.push({
     'id': siswa
    });
   }
  });

  return data;
 },

 get_post_data_siswa: function () {
  var data = {
   'ujian': $('#ujian').val(),
   'siswa': task_soal_data.get_data_siswa()
  };
  return data;
 },

 execSimpanSiswaHasUjian: function () {
  var data = task_soal_data.get_post_data_siswa();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   contentType: false,
   processData: false,
   async: false,
   url: url.base_url(task_soal_data.module()) + 'execSimpanSiswaHasUjian',
   error: function () {
    message.error('.message', 'Jaringan Error');
   },

   success: function (resp) {
    if (resp.is_valid) {
     message.success('.message', 'Siswa Berhasil Didaftarkan Ujian');
     var reload = function () {
      window.location.reload();
     };

     setTimeout(reload(), 1000);
    } else {
     message.error('.message', 'Siswa Gagal Didaftarkan Ujian');
    }
   }
  });
 },

 setFormSoal: function () {
  $('#rootwizard').bootstrapWizard({onTabShow: function (tab, navigation, index) {
    var $total = navigation.find('li').length;
    var $current = index + 1;
//    var $percent = ($current / $total) * 100;
//    $('#rootwizard').find('.bar').css({width: $percent + '%'});
    // If it's the last tab then hide the last button and show the finish instead
    if ($current >= $total) {
     $('#rootwizard').find('.pager .next').hide();
     $('#rootwizard').find('.pager .finish').show();
     $('#rootwizard').find('.pager .finish').removeClass('disabled');
    } else {
     $('#rootwizard').find('.pager .next').show();
     $('#rootwizard').find('.pager .finish').hide();
    }
   }});
//  $('#rootwizard .finish').click(function () {
//   message.success('.message', 'Soal Selesai Dikerjakan');
//   $('#rootwizard').find("a[href*='tab1']").trigger('click');
//  });
 },

 submitSoal: function (elm, e) {
  e.preventDefault();
  var soal = $('.soal');
  var belum_terjawab = 0;
  $.each(soal, function () {
   var not_answer = 0;
   var jawaban = $(this).find('.radio');
   $.each(jawaban, function () {
    var checked = $(this).is(':checked');
    if (!checked) {
     not_answer += 1;
    }
   });

   if (not_answer == 5) {
    belum_terjawab += 1;
   }
  });

  console.log(belum_terjawab);
  if (belum_terjawab > 0) {
   message.error('.message', 'Ada Soal yang Belum Terjawab');
  } else {
   //submit
   task_soal_data.execSubmitJawaban();
  }
 },

 get_data_jawaban: function () {
  var data = [];
  var jawaban = $('.radio');
  $.each(jawaban, function () {
   var checked = $(this).is(':checked');
   if (checked) {
    data.push({
     'soal': $(this).attr('soal'),
     'jawaban_id': $(this).attr('jawaban'),
     'is_true': $(this).attr('is_true')
    });
   }
  });

  return data;
 },

 get_post_data_submit: function () {
  var data = {
   'ujian': $('#ujian').val(),
   'jawaban': task_soal_data.get_data_jawaban()
  };
  return data;
 },

 execSubmitJawaban: function () {
//  message.showDialog('Proses Submitting Jawaban');
  var ujian = $('#ujian').val();
  var data = task_soal_data.get_post_data_submit();
  var formData = new FormData();
  formData.append('data', JSON.stringify(data));

  $.ajax({
   type: 'POST',
   data: formData,
   dataType: 'json',
   async: false,
   processData: false,
   contentType: false,
   url: url.base_url(task_soal_data.module()) + 'execSubmitJawaban' + '/' + ujian,
   error: function () {
    message.closeLoading();
    message.error('.message', 'Jaringan Bermasalah');
   },

   beforeSend: function () {
    message.loadingProses("Proses Submitting Jawaban");
   },

   success: function (resp) {
    message.closeLoading();
    if (resp.is_valid) {
     message.success('.message', 'Jawaban Berhasil Disubmit Seluruhnya');
     var reload = function () {
//      window.location.reload();
      window.location.href = url.base_url("daftar_ujian_ready") + 'index';
     };
     setTimeout(reload(), 1000);
    } else {
     message.error('.message', 'Jawaban Gagal Disubmit Seluruhnya');
    }
    message.closeDialog();
    task_soal_data.resetJawaban();
   }
  });
 },

 answeredSoal: function (elm, status_jawaban) {
  var data_jawaban = $(elm).closest('.tab-pane').find('div.jawaban').find('.radio');
  var jawaban = '';
  var soal = '';
  var counter_belum_jawab = 0;
  $.each(data_jawaban, function () {
   if ($(this).is(':checked')) {
    jawaban = $(this).attr('jawaban');
    soal = $(this).attr('soal');
   } else {
    counter_belum_jawab += 1;
   }
  });
//  console.log(soal);
//   return;

  if (counter_belum_jawab == 5) {
   message.error('.message', 'Anda Belum Menjawab');
  } else {
   $('.message').html('');
   task_soal_data.execAnsweredSoal(elm, soal, jawaban, status_jawaban);
  }
 },

 execAnsweredSoal: function (elm, soal, jawaban, status_jawaban) {
  var ujian = $('#ujian').val();
  $.ajax({
   type: 'POST',
   dataType: 'json',
   data: {
    soal: soal,
    jawaban: jawaban,
    status_jawaban: status_jawaban
   },
   async: false,
   url: url.base_url(task_soal_data.module()) + 'execAnsweredSoal' + '/' + ujian,
   error: function () {
    message.error('.message', 'Jaringan Error');
   },

   success: function (resp) {
//    var btn = $(elm).closest('div.row-fluid').find('button');
    if (resp.is_valid) {
//     $.each(btn, function () {
//      $(this).remove();
//     });
     message.success('.message', 'Berhasil Menjawab Soal');
    } else {
     message.error('.message', 'Gagal Menjawab Soal');
    }
   }
  });
 },

 execAnsweredSoalonChecked: function (elm) {
  var ujian = $('#ujian').val();
  $.ajax({
   type: 'POST',
   dataType: 'json',
   data: {
    soal: $(elm).attr('soal'),
    jawaban: $(elm).attr('jawaban'),
    status_jawaban: 1
   },
   async: false,
   url: url.base_url(task_soal_data.module()) + 'execAnsweredSoal' + '/' + ujian,
   error: function () {
    message.error('.message', 'Jaringan Error');
   },

   success: function (resp) {
    var btn = $(elm).closest('div.row-fluid').find('button');
    if (resp.is_valid) {
     message.success('.message', 'Berhasil Menjawab Soal');
    } else {
     message.error('.message', 'Gagal Menjawab Soal');
    }
   }
  });
 },

 resetJawaban: function () {
  var jawaban = $('.radio');
  $.each(jawaban, function () {
   $(this).prop('checked', false);
  });
 },

 answer: function (elm) {
  var no_soal = $.trim($(elm).closest('.tab-pane').find('.soal').find('h5').text().toString().replace('Soal No. ', ''));
  var answered = $('.total_soal_content').find('#' + no_soal);
  answered.addClass('answered');
  task_soal_data.execAnsweredSoalonChecked(elm);
 },

 getJawabanAnswered: function () {
  var jawaban = $('.radio');
//  console.log('jawaban', jawaban);
  $.each(jawaban, function () {
   var checked = $(this).is(':checked');
   if (checked) {
    var no_soal = $.trim($(this).closest('.tab-pane').find('.soal').find('h5').text().toString().replace('Soal No. ', ''));
//    console.log('soal no', no_soal);
    var answered = $('.total_soal_content').find('#' + no_soal);
    answered.addClass('answered');
   }
  });
 },

 updateSisaWaktu: function () {
  var ujian = $('#ujian').val();
  console.log(ujian);
  var front_minute = $('.flip-clock-wrapper').find('.flip:eq(0)').find('.flip-clock-active').find('.down').find('.inn').text();
  var back_minute = $('.flip-clock-wrapper').find('.flip:eq(1)').find('.flip-clock-active').find('.down').find('.inn').text();
  var minute = front_minute + '' + back_minute;

  $.ajax({
   type: 'POST',
   dataType: 'html',
   async: false,
   url: url.base_url(task_soal_data.module()) + 'updateSisaWaktu' + '/' + ujian + '/' + minute,
   error: function () {
    clearInterval(task_soal_data.updateTimer());
   },

   success: function (resp) {
    console.log(resp);

   }
  });
 },

 startUjian: function () {
  var ujian = $('#ujian').val();
//  console.log('ujian', ujian);
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(task_soal_data.module()) + 'getTimerUjian' + '/' + ujian,
   success: function (resp) {
    if (resp.is_valid) {
     var time_second = parseInt(resp.total_all);
     clock = $('.clock').FlipClock(time_second, {
      clockFace: 'MinuteCounter',
      countdown: true,
      autoStart: true,
      callbacks: {
       start: function () {
        message.success('.message', 'Ujian Telah Dimulai');
       },
       stop: function () {
        task_soal_data.execSubmitJawaban();
//         clearInterval();
       }
      }
     });
//     setInterval(task_soal_data.updateSisaWaktu(), 1000);     
     $('.flip-clock-label').remove();
     clock.start();
    } else {
     console.log('Belum Ada Ujian');
    }
   }
  });
 },

 playAudioListening: function (elm, ujian, soal_id) {
  var audio = $(elm).closest('div').find('audio');
  $.ajax({
   type: 'POST',
   dataType: 'json',
   async: false,
   url: url.base_url(task_soal_data.module()) + 'playAudioListening' + '/' + ujian + '/' + soal_id,
   success: function (resp) {
    if (!resp.is_valid) {
     message.error('.message', resp.message);
//     audio[0].pause();
    } else {
     audio[0].play();
     console.log(resp.message);
    }
   }
  });
 },

 updateTimer: function () {
  setInterval(function () {
//  console.log('ok');
   task_soal_data.updateSisaWaktu();
  }, 5000);
 }
};

$(function () {
// console.log('jawaban');
// task_soal_data.setForm();
//task_soal_data.updateSisaWaktu();

// task_soal_data.setFormSoal();
 task_soal_data.getJawabanAnswered();
 task_soal_data.startUjian();

// var oke = function(){
//  console.log('ok');
//};
 if ($('#ujian')) {
  task_soal_data.updateTimer();
 }
});
