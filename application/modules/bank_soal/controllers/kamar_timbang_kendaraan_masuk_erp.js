$(function(){

	initialButton();
	searchData();

	//$('#inputFilterDate').attr('disabled', true);
	//kontrolTimbangKeluar();
	//kontrolJenisTransaksi();
	//addNoPolisiBruto();


	$('#inputBeratTimbangGross, #inputBeratTimbangTara').numeric({
		allowPlus           : false, 
		allowMinus          : false,  
		allowThouSep        : false,  
		allowDecSep         : true
	});

	$('.nav-tabs a').click(function (e) {
	    e.preventDefault();
	    var tabIndex = $($(this).attr('href')).index();
		switch(tabIndex){
			case 1 :
				$('#inputBeratTimbangGross').attr('readonly', true);
				$('#inputBeratTimbangTara').attr('readonly', true);
				if(!$('#inputBeratTimbangGross').val()){
					$('#inputBeratTimbangGross').val('0');
					console.log("memasukan nilai tara = 0");
				}
				if(!$('#inputBeratTimbangTara').val()){
					$('#inputBeratTimbangTara').val('0');
					console.log("memasukan nilai gross = 0");
				}
			break;
		}
	});
  
  	$("body").on("contextmenu", "table#timbangTable tbody tr td", function(e) {
  		var tr = $(e.target).parent();
  		var noMasuk = tr.find('td.col-no-masuk').attr('data-id');
  		var noPolisi = tr.find('td.col-no-polisi').text();
  		var noStrukTimbang = tr.find('td.col-no-struk-timbang').text();
  		var sampel = tr.attr('data-sampel');
  		var noOrder = tr.attr('data-nomerorder');
  		$('#menuSampel2').attr('data-value', noMasuk);
  		$('#menuSampel2').attr('data-sampel2', sampel);
  		$('#menuNomerOrder').attr('data-value', noMasuk);
  		$('#menuNomerOrder').attr('data-no-pol', noPolisi);
  		$('#menuNomerOrder').attr('data-nostruktimbang', noStrukTimbang);
  		$('#menuNomerOrder').attr('data-nomerorder', noOrder);
  		var td = $(e.target);
	    $("#contextMenu").css({
	      display: "block",
	      position: "absolute",
	      left: td.position().left + td.height(),
	      top: td.position().top + td.height()
	    });
	    $("#contextMenu").removeClass('hide');
	    (noMasuk.substr(0, 2) == 'KM') ? $('#menuSampel2').removeClass('hide') : $('#menuSampel2').addClass('hide');
	    ($('#inputKM').val()) ? $('#menuSampel2').removeClass('hide') : $('#menuSampel2').addClass('hide');
	    //(!noOrder) ? $('#menuNomerOrder').removeClass('hide') : $('#menuNomerOrder').addClass('hide');
	    return false;
  	});

});

var mode;
var statusTimbang = 1;

function initialButton(){
	$('#inputNoSPB').next().attr('disabled', true);
	$('#btnTimbang').show();
	$('#btnTimbang').removeAttr('disabled');
	$('#btnSimpan').hide();
	$('#btnUbah').show();
	$('#btnUbah').attr('disabled', true);
	$('#btnHapus').show();
	$('#btnHapus').attr('disabled', true);
	$('#btnBatal').hide();
	$('#btnInputManual').attr('disabled', true);
	$('div.radio input[type="radio"]').attr('disabled', true);
	$('#inputBeratTimbangGross').attr('readonly', true);
	$('#inputBeratTimbangTara').attr('readonly', true);
	$('div#spb input[type="text"]').val('');
	$('div#timbang input[type="text"]').val('');


	$('#print label.value').text('N/A');
	
	$('#nilaiTimbang').text('0');


	$('#btnHapus').hide();
}

function searchData(){
	console.log("masuk sercch");
	$("#contextMenu").addClass("hide");
	var failed = 0;
	var optionFilter = $('#optionFilter').val();
	var inputFilter = $('#inputFilter').val();
	var optionFilterDate = $('#optionFilterDate').val();
	var inputFilterDate = $('#inputFilterDate').val();
	var inputKM = $('#inputKM').val();
	var dataParams = {
		'optionFilter' : optionFilter,
		'inputFilter' : inputFilter,
		'optionFilterDate' : optionFilterDate,
		'inputFilterDate' : inputFilterDate,
		'inputKM' : inputKM
	}
	if(optionFilterDate==2 || optionFilterDate==3){
		if(!inputFilterDate && !inputFilter){
			failed++;
		}
	}
	if(failed == 0){
		$.ajax({
			url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/getDataTimbang',
			data : {
				data : dataParams
			},
			type : 'post',
			dataType : 'html',
			beforeSend : function(){
				$('#dataTimbang').html('<div class="text-center" style="margin-bottom:15px;"><img width="3%" height="3%" src="'+base_url+'assets/images/loading.gif"></div>');
			},
			success : function(data){
				$('#dataTimbang').html(data);
			},
		}).done(function(){
			//var maxHeight = 250;
			var maxHeight = (json_max_width) ? parseInt(json_max_width) : 250;
			var heightTable = parseInt($('#timbangTable').height());
			if( heightTable > maxHeight){
				$('#dataTimbang #timbangTable').scrollabletable({
		      		'max_height_scrollable' : maxHeight,
				});
				$('div').scroll(function(){
					$("#contextMenu").addClass("hide");
				});
			}
		});
	
	}
	else{
		toastr.warning('Parameter input harus lengkap.', 'Informasi');
	}
	
	
}

function kontrolOptionFilter(){
	$('#inputFilter').val('');
}

function kontrolOptionFilterSPB(){
	$('#inputFilterSPB').val('');
}

function viewSPB(elm){
	var status = $(elm).attr('data-status');
	if(status == 1){
		// var data = '<form class="form-horizontal">';
		var data = '';
			data += '<div class="row">';
			data += '<div class="col-md-6">';
			// data += '<div class="form-group">';
			// data += '<div class="col-md-4">';
			// data += '<select onchange="kontrolOptionFilterSPB()" type="text" class="form-control" id="optionFilterSPB" name="optionFilterSPB">';
			// data += '<option value="no_spb">No. SPB</option>';
			// data += '<option value="no_masuk">No. Masuk</option>';
			// data += '<option value="namabarang">Nama Barang</option>';
			// data += '<option value="namasupplier">Nama Supplier</option>';
			// data += '</select>';
			// data += '</div>';
			data += '<div class="col-md-6">';
			data += '<div class="input-group">';
			data += '<input type="text" id="inputFilterSPB" name="inputFilterSPB" class="form-control parameter" onkeyup="getSpbbyBarcode(this, event)">';
			data += '<span onclick="getSPB()" class="input-group-addon"><span class="glyphicon-search glyphicon"></span>';
			data += '</span>';
			data += '</div>';
			data += '</div>';
			data += '</div>';
			data += '</div>';
			data += '</div>';
			data += '<div id="dataSPB" class="row">';
			data += '</div>';
			// data += '</form>';
		var box = bootbox.dialog({
			title : "Daftar Surat Perintah Bongkar",
			className : "very-large",
			message : data
		});
		
		box.bind('shown.bs.modal', function() {
			var no_spb = $('#inputFilterSPB').val();			
			getSPB(no_spb);
			$('input#inputFilterSPB').focus();
		});

		box.bind('hidden.bs.modal', function() {
			kontrolSPB();
		});
	}
}

function getSpbbyBarcode(elm, e){
	e.preventDefault();
	var _tiket_masuk = $(elm).val();
	if(_tiket_masuk.length == 10 && $.trim($(elm).val()) != ""){
		getSPB($.trim($(elm).val()));
	}
}

function kontrolSPB(){
	var noSPB = $('#inputNoSPB').val();
	var noMasuk = $('#inputNoMasuk').val();
	var legendNoMasuk = noMasuk.substr(0,2);
	var idStatusKendaraan = $('div.radio input[type="radio"]:checked').attr('id');
	var statusKendaraan = $('#'+idStatusKendaraan).val();
	switch(statusKendaraan){
		case 'dalam':
			if(legendNoMasuk == 'TM'){
				kontrolNoMasukTM(noSPB, noMasuk, function(result){
					switch(result){
						case 2:
							toastr.warning('Kendaraan dengan nomor masuk '+noMasuk+' belum dilakukan probe. Silahkan probe terlebih dahulu.', 'Informasi');
							batal();
						break;
						case 3:
							toastr.warning('Kendaraan dengan nomor masuk '+noMasuk+' masih proses Probe. Silahkan tunggu hingga proses probe selesai.', 'Informasi');
							batal();
						break;
						default:
							getKendaraanMasuk(1);
						break;
					}
				});
			}
			else{
				getKendaraanMasuk(1);
			}
		break;
		case 'keluar':
			mode = 3;
			getKendaraanMasuk(1);
		break;
	}
}

function kontrolNoMasukTM(noSPB, noMasuk, callback){
	
	$.ajax({
		url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/kontrolNoMasukTM',
		data : {
			noSPB : noSPB,
			noMasuk : noMasuk
		},
		type : 'post',
		dataType : 'json',
		beforeSend : function(){
		},
		success : function(data){
			callback(data);
		},
	}).done(function(){
		
	})
	
}

function kontrolKendaraanKosong(noMasuk){
	
	$.ajax({
		url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/kontrolKendaraanKosong',
		data : {
			noMasuk : noMasuk
		},
		type : 'post',
		dataType : 'json',
		beforeSend : function(){
		},
		success : function(data){
			var idStatusKendaraan = $('div.radio input[type="radio"]:checked').attr('id');
			var statusKendaraan = $('#'+idStatusKendaraan).val();
			switch(statusKendaraan){
				case 'dalam':
					if(data>0){
						toastr.warning('Kendaraan kosong akan ambil karung, timbang tara.', 'Informasi');
						statusTimbang = 0;
						$('#inputBeratTimbangTara').removeAttr('readonly');
						$('#inputBeratTimbangGross').attr('readonly', true);
						$('#inputBeratTimbangTara').focus().select();
					}
					else{
						statusTimbang = 1;
					}
				break;
				case 'keluar':
					if(data>0){
						toastr.warning('Kendaraan dari ambil karung, timbang gross.', 'Informasi');
						statusTimbang = 0;
						$('#inputBeratTimbangGross').removeAttr('readonly');
						$('#inputBeratTimbangTara').attr('readonly', true);
						$('#inputBeratTimbangGross').focus().select();
					}
					else{
						statusTimbang = 1;
					}
				break;
			}
		},
	}).done(function(){
		kontrolAmbilKarung(noMasuk);
	})
	
}

function kontrolAmbilKarung(noMasuk){
	var noSPB = $('#inputNoSPB').val();
	var idStatusKendaraan = $('div.radio input[type="radio"]:checked').attr('id');
	var statusKendaraan = $('#'+idStatusKendaraan).val();
	$.ajax({
		url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/kontrolAmbilKarung',
		data : {
			noSPB : noSPB,
			noMasuk : noMasuk,
			timbang : statusKendaraan
		},
		type : 'post',
		dataType : 'json',
		beforeSend : function(){
		},
		success : function(data){
			if(data.result == 1){
				var dataKarung = data['message'][0];
				toastr.warning('Kendaraan telah ambil karung. (berat tara/truk = berat tara/truk dengan nomor timbang = '+dataKarung.NOSTRUKTIMBANG+' dan nomor spb = '+dataKarung.NOSPB+') setelah timbang gross kendaraan bisa keluar.', 'Informasi');
				if(parseFloat(dataKarung.BERATTRUK) > 0){
					$('#inputBeratTimbangTara').val(dataKarung.BERATTRUK);
				}
				else{
					toastr.warning('Kendaraan tidak bisa timbang. Nomor timbang = '+dataKarung.NOSTRUKTIMBANG+' dan nomor spb = '+dataKarung.NOSPB+') harus timbang tara/keluar terlebih dahulu.', 'Informasi');
					batal();
				}
			}
		},
	}).done(function(){
		
	})
	
}

function timbang(){
	initialButton();
	$('#inputNoSPB').next().attr('data-status', 1);
	$('#btnTimbang').hide();
	$('#btnSimpan').show();
	$('#btnSimpan').removeAttr('disabled');
	$('#btnUbah').hide();
	$('#btnHapus').hide();
	$('#btnBatal').show();
	$('#btnBatal').removeAttr('disabled');
	$('#btnInputManual').removeAttr('disabled');
	$('div.radio input[type="radio"]').removeAttr('disabled');
	$('#for_spb').click();
	mode = 1;
}

function simpan(){
	$('#inputNoSPB').next().attr('data-status', 0);

	switch(mode){
		case 1:
			simpanTimbang();
		break;
		case 2:
			ubahTimbang(1);
		break;
		case 3:
			ubahTimbang(0);
		break;
	}
}

function ubah(){
	$('#inputNoSPB').next().attr('data-status', 0);
	$('#btnTimbang').hide();
	$('#btnSimpan').show();
	$('#btnSimpan').removeAttr('disabled');
	$('#btnUbah').hide();
	$('#btnHapus').hide();
	$('#btnBatal').show();
	$('#btnBatal').removeAttr('disabled');
	$('#btnInputManual').removeAttr('disabled');
	$('div.radio input[type="radio"]').removeAttr('disabled');
	mode = 2;
}

function hapus(){
	$('#inputNoSPB').next().attr('data-status', 0);
}

function batal(){
	$('#inputNoSPB').next().attr('data-status', 0);
	initialButton();
	$('#for_spb').click();
}

function getSPB(no_spb = ""){
	no_spb = no_spb == '' ? $.trim($('input#inputFilterSPB').val()) : no_spb;
	var idStatusKendaraan = $('div.radio input[type="radio"]:checked').attr('id');
	var statusKendaraan = $('#'+idStatusKendaraan).val();
	var optionFilterSPB = $('#optionFilterSPB').val();
	var inputFilterSPB = $('#inputFilterSPB').val();
	var dataParamsSPB = {
		'optionFilter' : optionFilterSPB,
		'inputFilter' : inputFilterSPB,
		'statusKendaraan' : statusKendaraan,
		'no_spb' : no_spb
	}
	$.ajax({
		url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/getDataSPB',
		data : {
			data : dataParamsSPB
		},
		type : 'post',
		dataType : 'html',
		beforeSend : function(){
			$('#dataSPB').html('<div class="text-center" style="margin-bottom:15px;"><img width="3%" height="3%" src="'+base_url+'assets/images/loading.gif"></div>');
		},
		success : function(data){
			$('#dataSPB').html(data);
		},
	}).done(function(){
		var maxHeight = 250;
		var heightTable = parseInt($('#spbTable').height());
		if( heightTable > maxHeight){
			$('#dataSPB #spbTable').scrollabletable({
	      		'max_height_scrollable' : maxHeight,
			});
			$('div').scroll(function(){
				$("#contextMenu").addClass("hide");
			});
		}
	})
	
}

function spbSelected(elm){
	$('div#spb input[type="text"]').val('');
	var noSPB = $(elm).find('td.col-no-spb').text();
	var noMasuk = $(elm).find('td.col-no-masuk').text();
	$('#inputNoSPB').val(noSPB);
	$('#inputNoMasuk').val(noMasuk);
	$('div.bootbox').modal('hide');
	checkAcknowledge(elm);
}

function getKendaraanMasuk(saved){
	$('#print label.value').text('N/A');
	var inputNoMasuk = $('#inputNoMasuk').val();
	if(inputNoMasuk){
		$.ajax({
			url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/getDataKendaraanMasuk',
			data : {
				inputNoMasuk : inputNoMasuk
			},
			type : 'post',
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(data){
				console.log(data);
				if(saved == 1){
					$('#optionFilter').prop('selectedIndex', 1);
					$('#inputFilter').val(data.NOMERMASUK);
					$('#optionFilterDate').prop('selectedIndex', 2);
				}

				//$('#inputNoSPB').val(data.NOSPB);
				$('#inputNoMasuk').val(data.NOMERMASUK);
				$('#inputNoUrut').val(data.NOURUT);
				$('#inputTanggalDatang').val(data.TANGGAL);
				$('#inputNoOP').val(data.NOMERORDER);
				$('#inputNoPolisi').val(data.NOPOL);
				$('#inputNamaSopir').val(data.NAMASOPIR);
				$('#inputJamDatang').val(data.JAM);
				$('#inputJenisPacking').val(data.JENISPACKING);
				$('#inputJenisKendaraan').val(data.JENISKENDARAAN);

				if (data.JENISKENDARAAN == "GANDENG") {
					$('#beratGross').addClass('hide');
					$('#beratGrossGandeng').removeClass('hide');
					$('#beratNetto').addClass('hide');
					$('#beratNettoGandeng').removeClass('hide');
					$('#beratTara').addClass('hide');
					$('#beratTaraGandeng').removeClass('hide');

					$('#inputNoStrukTimbang').val(data.NOSTRUKTIMBANG);
					$('#inputWaktuTimbangGross').val(data.TANGGALGROSS+' '+data.JAMGROSS);
					$('#inputWaktuTimbangTara').val(data.TANGGALTARA+' '+data.JAMTARA);
					$('#inputBeratTimbangGrossDepan').val(data.BERATGROSS_DEPAN);
					$('#inputBeratTimbangTaraDepan').val(data.BERATTARA_DEPAN);
					$('#inputBeratTimbangNettoDepan').val(data.BERATGROSS_DEPAN-data.BERATTARA_DEPAN);
					$('#inputBeratTimbangGrossBelakang').val(data.BERATGROSS_BELAKANG);
					$('#inputBeratTimbangTaraBelakang').val(data.BERATTARA_BELAKANG);
					$('#inputBeratTimbangNettoBelakang').val(data.BERATGROSS_BELAKANG-data.BERATTARA_BELAKANG);
				} else {
					$('#beratGross').removeClass('hide');
					$('#beratGrossGandeng').addClass('hide');
					$('#beratNetto').removeClass('hide');
					$('#beratNettoGandeng').addClass('hide');
					$('#beratTara').removeClass('hide');
					$('#beratTaraGandeng').addClass('hide');


					$('#inputNoStrukTimbang').val(data.NOSTRUKTIMBANG);
					$('#inputWaktuTimbangGross').val(data.TANGGALGROSS+' '+data.JAMGROSS);
					$('#inputBeratTimbangGross').val(data.BERATGROSS);
					$('#inputWaktuTimbangTara').val(data.TANGGALTARA+' '+data.JAMTARA);
					$('#inputBeratTimbangTara').val(data.BERATTARA);
					$('#inputBeratTimbangNetto').val(data.BERATNETTO);
				}
				/*
				$('#inputNoStrukTimbang').val(data.NOSTRUKTIMBANG);
				$('#inputWaktuTimbangGross').val(data.TANGGALGROSS+' '+data.JAMGROSS);
				$('#inputBeratTimbangGross').val(data.BERATGROSS);
				$('#inputWaktuTimbangTara').val(data.TANGGALTARA+' '+data.JAMTARA);
				$('#inputBeratTimbangTara').val(data.BERATTARA);
				$('#inputBeratTimbangNetto').val(data.BERATNETTO);
				*/

				$('#print label.labelCetakNoStrukTimbang').text(data.NOSTRUKTIMBANG);
				$('#print label.labelCetakTanggalTimbang').text(data.TANGGALTIMBANG);
				$('#print label.labelCetakJamGross').text(data.JAMGROSS);
				$('#print label.labelCetakJamTara').text(data.JAMTARA);
				$('#print label.labelCetakSupplier').text(data.SUPPLIER);
				$('#print label.labelCetakBahanBaku').text(data.BAHANBAKU);
				$('#print label.labelCetakNoSpb').text(data.NOSPB);
				$('#print label.labelCetakNoPolisi').text(data.NOPOL);
				$('#print label.labelCetakNoContainer').text(data.NOMERCONTAINER);
				
				
				$('#print label.labelCetakBeratGross').text(data.BERATGROSS+' Kg');
				$('#print label.labelCetakBeratTara').text(data.BERATTARA+' Kg');
				$('#print label.labelCetakBeratNetto').text(data.BERATNETTO+' Kg');
				
				if(parseFloat(data.BERATTARA) <= 0){
					$('#print label.labelCetakSupplier').addClass('hide');
					$('#print label.labelCetakNoPolisi').addClass('hide');
				}
				else{
					
					$('#print label.labelCetakSupplier').removeClass('hide');
					$('#print label.labelCetakNoPolisi').removeClass('hide');
				}
				
			},
		}).done(function(){
			if(saved == 1){
				searchData();
				$('#for_timbang').click();

				kontrolKendaraanKosong(inputNoMasuk);
			}
		});
	}
	
}

function login(){
	var akses = 0 ;
	var failed = 0 ;
	var html = '';
		html += '<div class="form-horizontal">';
		html += '<div class="form-group">';
		html += '<label class="col-md-4 control-label text-right" for="">Nama User</label>';
		html += '<div class="col-md-5">';
		html += '<input type="text" placeholder="Nama User" name="inputUsername" id="inputUsername" class="form-control">';
		html += '</div>';
		html += '</div>';
		html += '<div class="form-group">';
		html += '<label class="col-md-4 control-label text-right" for="">Password</label>';
		html += '<div class="col-md-5">';
		html += '<input type="password" placeholder="Password" name="inputPassword" id="inputPassword" class="form-control">';
		html += '</div>';
		html += '</div>';
		html += '</div>';
	var box = bootbox.dialog({
		title : "Akses User",
		message : html,
		buttons : {
			success : {
				label : "OK",
				className : "btn-success",
				callback : function() {
					if(!$('#inputUsername').val() || !$('#inputPassword').val()){
						toastr.warning('Parameter input belum lengkap.', 'Informasi');

						return false;
					}
					else{
						checkAkses(function(result){
							akses = result;
							if(result != 1){
								failed = 1;
							}
							return true;
						});
					}
				}
			},
			danger : {
				label : "Batal",
				className : "btn-danger",
				callback : function() {
					return true;
				}
			},
		}
	});
	box.bind('shown.bs.modal', function() {
		$('#inputUsername').val('').focus().select();
	});

	box.bind('hidden.bs.modal', function() {
		$('#inputBeratTimbangGross').attr('readonly', true);
		$('#inputBeratTimbangTara').attr('readonly', true);
		if(akses == 1){
			var idStatusKendaraan = $('div.radio input[type="radio"]:checked').attr('id');
			var statusKendaraan = $('#'+idStatusKendaraan).val();
			switch(statusKendaraan){
				case 'dalam':
					$('#inputBeratTimbangGross').removeAttr('readonly');
					$('#inputBeratTimbangGross').focus().select();
				break;
				case 'keluar':
					$('#inputBeratTimbangTara').removeAttr('readonly');
					$('#inputBeratTimbangTara').focus().select();
				break;
			}
		}
		else{
			if(failed == 1){
				toastr.warning('User tidak memiliki otoritas buka manual penimbangan.', 'Informasi');
			}
		}
	});
}

function checkAkses(callback){
	var username = $('#inputUsername').val();
	var password = $('#inputPassword').val();
	$.ajax({
		url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/checkAkses',
		data : {
			username : username,
			password : password
		},
		type : 'post',
		dataType : 'html',
		beforeSend : function(){
		},
		success : function(data){
			callback(data);
		},
	}).done(function(){
	})
	
}

function getBerat(dataParams, callback){
	$.ajax({
		url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/getBerat',
		data : {
			data : dataParams
		},
		type : 'post',
		dataType : 'json',
		beforeSend : function(){
		},
		success : function(data){
			callback(data);
		},
	}).done(function(){
	})
	
}

function timbangSelected(elm){
	$("#contextMenu").addClass("hide");
	if(!$('#btnSimpan').is(':visible')){
		var noSPB = $(elm).find('td.col-no-spb').text();
		var noMasuk = $(elm).find('td.col-no-masuk').text();
		$('#inputNoSPB').val(noSPB);
		$('#inputNoMasuk').val(noMasuk);
		$('#btnUbah').removeAttr('disabled');
		$('#btnHapus').removeAttr('disabled');
		if(!$('#inputKM').val()){
			getKendaraanMasuk(0);
		}
	}
}

function checkAcknowledge(elm){
	var noMasuk = $(elm).find('td.col-no-masuk').text();
	console.log('no_masuk', noMasuk);
	$.ajax({
		url : 'acknowledge/checkProsesAck',
		data : {
			proses : "timbang",
			keyword: noMasuk,
			encode: 'encode'
		},
		type : 'post',
		dataType : 'json',
		beforeSend : function(){
		},
		success : function(data){
			console.log('data ack', data);
			if(!data.is_valid){
				toastr.error(data.message);							
				$('#btnSimpan').prop('disabled', true);
			}else{
				$('#btnSimpan').prop('disabled', false);
			}
		},
	}).done(function(){
	});
	return;
}

function ubahTimbang(flag){
	console.log("ubah timbang");
	var inputNoStrukTimbang = $('#inputNoStrukTimbang').val();
	var jenisKendaraan = $('#inputJenisKendaraan').val();
	
	if (jenisKendaraan == "GANDENG") {
			var inputBeratTimbangGrossBelakang = $('#inputBeratTimbangGrossBelakang').val();// != 0; ? $('#inputBeratTimbangGrossBelakang').val() : 0 ;
			var inputBeratTimbangTaraBelakang = $('#inputBeratTimbangTaraBelakang').val();// != 0 ? $('#inputBeratTimbangTaraBelakang').val() : 0 ;
			var inputBeratTimbangGross = $('#inputBeratTimbangGrossDepan').val() ;//!= 0 ;? $('#inputBeratTimbangGrossDepan').val() : 0 ;
			var inputBeratTimbangTara = $('#inputBeratTimbangTaraDepan').val() ;//!= 0 ;//? $('#inputBeratTimbangTaraDepan').val() : 0;
	} else {
		var inputBeratTimbangGross = $('#inputBeratTimbangGross').val() != 0 ? $('#inputBeratTimbangGross').val() : 0 ;
		var inputBeratTimbangTara = $('#inputBeratTimbangTara').val() != 0 ? $('#inputBeratTimbangTara').val() : 0 ;
	}

	console.log(inputBeratTimbangGross);
	console.log(inputBeratTimbangTara);

	if(
		(inputBeratTimbangGross && inputBeratTimbangTara && (parseFloat(inputBeratTimbangGross) > 0 || parseFloat(inputBeratTimbangTara) > 0)
		&& jenisKendaraan != "GANDENG")
		||
		((inputBeratTimbangGross || inputBeratTimbangGrossBelakang) && (inputBeratTimbangTara || inputBeratTimbangTaraBelakang) && ((parseFloat(inputBeratTimbangGross) > 0 || parseFloat(inputBeratTimbangTara) > 0) || parseFloat(inputBeratTimbangGrossBelakang) > 0 || parseFloat(inputBeratTimbangTaraBelakang) > 0)
		&& jenisKendaraan == "GANDENG")			
	){
		//if(parseFloat(inputBeratTimbangGross) >= parseFloat(inputBeratTimbangTara)){
		if(
			(statusTimbang != 0 && parseFloat(inputBeratTimbangGross) <= 0 && jenisKendaraan != "GANDENG")
			||
			(statusTimbang != 0 && (parseFloat(inputBeratTimbangGross) <= 0 && parseFloat(inputBeratTimbangGrossBelakang) <= 0) && jenisKendaraan == "GANDENG")
		){
			$('#inputBeratTimbangGross').val('0').focus().select();
			toastr.warning('Masukkan data berat gross.','Informasi');
		}
		else{
			if(
				((statusTimbang) == 0 && parseFloat(inputBeratTimbangTara) <= 0 && flag == 1 && jenisKendaraan != "GANDENG")
				||
				((statusTimbang) == 0 && (parseFloat(inputBeratTimbangTara) <= 0 && parseFloat(inputBeratTimbangTaraBelakang) <= 0) && flag == 1 && jenisKendaraan == "GANDENG")
			){
				$('#inputBeratTimbangGross').val('0').focus().select();
				toastr.warning('Masukkan data berat gross.','Informasi');
			}
			else{
				var dataParams = {
					'inputNoStrukTimbang' : inputNoStrukTimbang,
					'inputWaktuTimbangGross' : $('#inputWaktuTimbangGross').val(),
					'inputWaktuTimbangTara' : $('#inputWaktuTimbangTara').val(),
					'inputBeratTimbangGross' : inputBeratTimbangGross,
					'inputBeratTimbangTara' : inputBeratTimbangTara,
					'inputBeratTimbangGrossBelakang' : inputBeratTimbangGrossBelakang,
					'inputBeratTimbangTaraBelakang' : inputBeratTimbangTaraBelakang,
					'inputBeratTimbangNetto' : $('#inputBeratTimbangNetto').val(),
					'jenisKendaraan' : jenisKendaraan
				}

				var counter_time_finger = 0;
				var departemen = 'ubah_timbang';
				var finger = function(){
					$.ajax({
						url : 'probe/kendaraanmasuk/validasiFingerAll',
						type : 'POST',
						dataType:'json',
						async : false,
						beforeSend:function(){
							message.loadingProses('Sedang Proses Verifikasi Finger...')
						},
						error: function(){
							toastr.error("Gagal Verifikasi Finger");
							message.closeLoading();
						},
						success: function(resp){
							if(resp.is_valid){	
								message.closeLoading();
								clearInterval(intFinger);
								$.ajax({
									url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/ubahTimbang',
									data : {
										data : dataParams
									},
									type : 'post',
									dataType : 'json',
									beforeSend : function(){
									},
									success : function(data){
										console.log(data);
										if(data > 0){
											initialButton();
											$('#optionFilter').prop('selectedIndex', 0);
											$('#inputFilter').val(inputNoStrukTimbang);
											$('#optionFilterDate').prop('selectedIndex', 2);
											searchData();
											setTimeout(function(){
												$('table#timbangTable tbody tr:first').click();
											}, 700);
											$('#for_timbang').click();
											toastr.success('Ubah data timbang '+inputNoStrukTimbang+' berhasil.','Informasi');

											// insertGagalFinger(departemen, 'update');
										}
										else {
											toastr.error('Ubah data timbang '+inputNoStrukTimbang+' gagal.','Informasi');
										}
									},
								}).done(function(){
								});
								return;
							}else{
								if(counter_time_finger >= 30){
									message.closeLoading();
									counter_time_finger = 0;
									clearInterval(intFinger);
									toastr.error("Finger Print Telah gagal");
		
									//
									insertGagalFinger(departemen,  $('#inputNoMasuk').val());
								}else{
									counter_time_finger +=1;
									toastr.error(resp.message);
								}
							}
						}
					});	
				}
			
				var intFinger = setInterval(finger, 1000); 				
			}
		}
		/*
		}
		else{
			$('#inputBeratTimbangTara').val('0').focus().select();
			toastr.warning('Masukkan data berat gross.','Informasi');
		}
		*/
	}
	else{
		toastr.warning('Berat timbang harus > 0.','Informasi');
	}
}

function insertGagalFinger(departemen, update = ''){
	var url = window.location.href;
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: {
			module: departemen,
			update: update,
			url: url,
			doc_num: update
		},
		async: false,
		url: "finger/insertGagalFinger",
		beforeSend: function () {
			// message.loadingProses("Proses Simpan..");
		},

		error: function () {
			// message.closeLoading();
			toastr.error("Gagal");
		},

		success: function (resp) {
			// message.closeLoading();
			
			if(update != ''){                        
				// toastr.success("Berhasil Disimpan");
				var reload = function(){
					// window.location.reload();
					window.close();
					window.opener.location.reload(true);
				};

				setTimeout(reload(), 1000);
			}else{
				toastr.error("Gagal Disimpan");
			}
		}
	});
}

function simpanTimbang(){
	console.log("simpan timbang");
	var inputNoStrukTimbang = $('#inputNoStrukTimbang').val();
	var inputNoMasuk = $('#inputNoMasuk').val();
	var jenisKendaraan = $('#inputJenisKendaraan').val();
	console.log(jenisKendaraan);
	if (jenisKendaraan == "GANDENG") {
		console.log("benar gandeng");
	}else{
		console.log("truk tidak gandeng");
	}
	/*
	var inputBeratTimbangGross = $('#inputBeratTimbangGross').val() != 0 ? $('#inputBeratTimbangGross').val() : $('#inputBeratTimbangGrossDepan').val();
	var inputBeratTimbangTara = $('#inputBeratTimbangTara').val() != 0 ? $('#inputBeratTimbangTara').val() : $('#inputBeratTimbangTaraDepan').val();
	var inputBeratTimbangNetto = $('#inputBeratTimbangNetto').val() != 0 ? $('#inputBeratTimbangNetto').val() : $('#inputBeratTimbangNettoDepan').val();
	var inputBeratTimbangGrossBelakang = $('#inputBeratTimbangGrossBelakang').val() != 0 ? $('#inputBeratTimbangGrossBelakang').val() : 0;
	var inputBeratTimbangTaraBelakang = $('#inputBeratTimbangTaraBelakang').val() != 0 ? $('#inputBeratTimbangTaraBelakang').val() : 0;
	var inputBeratTimbangNettoBelakang = $('#inputBeratTimbangTaraBelakang').val() != 0 ? $('#inputBeratTimbangNettoBelakang').val() : 0;
	*/
	if (jenisKendaraan == "GANDENG") {
			console.log("masuk gandeng");
			var inputBeratTimbangGrossBelakang = $('#inputBeratTimbangGrossBelakang').val() != 0 ? $('#inputBeratTimbangGrossBelakang').val() : 0 ;
			var inputBeratTimbangTaraBelakang = $('#inputBeratTimbangTaraBelakang').val() != 0 ? $('#inputBeratTimbangTaraBelakang').val() : 0 ;
			var inputBeratTimbangGross = $('#inputBeratTimbangGrossDepan').val();// != 0 ? $('#inputBeratTimbangGrossDepan').val() : 0 ;
			var inputBeratTimbangTara = $('#inputBeratTimbangTaraDepan').val();// != 0 ? $('#inputBeratTimbangTaraDepan').val() : 0;
			var inputBeratTimbangNetto = $('#inputBeratTimbangNettoDepan').val() != 0 ? $('#inputBeratTimbangNettoDepan').val() : 0;
			var inputBeratTimbangNettoBelakang = $('#inputBeratTimbangTaraBelakang').val() != 0 ? $('#inputBeratTimbangNettoBelakang').val() : 0;
	} else {
		var inputBeratTimbangGross = $('#inputBeratTimbangGross').val();// != 0 ? $('#inputBeratTimbangGross').val() : 0 ;
		var inputBeratTimbangTara = $('#inputBeratTimbangTara').val();// != 0 ? $('#inputBeratTimbangTara').val() : 0 ;
		var inputBeratTimbangNetto = $('#inputBeratTimbangNetto').val() != 0 ? $('#inputBeratTimbangNetto').val() : 0;
	}

	var dataParams = {
		'inputNoStrukTimbang' : inputNoStrukTimbang,
		'inputWaktuTimbangGross' : $('#inputWaktuTimbangGross').val(),
		'inputWaktuTimbangTara' : $('#inputWaktuTimbangTara').val(),
		'inputBeratTimbangGross' : inputBeratTimbangGross,
		'inputBeratTimbangTara' : inputBeratTimbangTara,
		'inputBeratTimbangNetto' : inputBeratTimbangNetto,
		'inputBeratTimbangGrossBelakang' : inputBeratTimbangGrossBelakang,
		'inputBeratTimbangTaraBelakang' : inputBeratTimbangTaraBelakang,
		'inputBeratTimbangNettoBelakang' : inputBeratTimbangNettoBelakang,
		'inputNoSPB' : $('#inputNoSPB').val(),
		'inputNoMasuk' : inputNoMasuk,
		'inputNoOP' : $('#inputNoOP').val(),
		'inputNoPolisi' : $('#inputNoPolisi').val(),
		'iputBerat' : 0,
		'jenisKendaraan' : jenisKendaraan
	}

	if(inputNoMasuk){	
		console.log(inputBeratTimbangGross);
		console.log(inputBeratTimbangTara);
		console.log(parseFloat(inputBeratTimbangGross));
		console.log(parseFloat(inputBeratTimbangTara));
		if(
			(inputBeratTimbangGross && inputBeratTimbangTara && (parseFloat(inputBeratTimbangGross) > 0 || parseFloat(inputBeratTimbangTara) > 0)
			&& jenisKendaraan != "GANDENG")
			||
			((inputBeratTimbangGross || inputBeratTimbangGrossBelakang) && (inputBeratTimbangTara || inputBeratTimbangTaraBelakang) && ((parseFloat(inputBeratTimbangGross) > 0 || parseFloat(inputBeratTimbangTara) > 0) || parseFloat(inputBeratTimbangGrossBelakang) > 0 || parseFloat(inputBeratTimbangTaraBelakang) > 0)
			&& jenisKendaraan == "GANDENG")
		){
			//if(parseFloat(inputBeratTimbangGross) >= parseFloat(inputBeratTimbangTara)){
				
			if(
				(statusTimbang != 0 && parseFloat(inputBeratTimbangGross) <= 0 && jenisKendaraan != "GANDENG")
				||
				(statusTimbang != 0 && (parseFloat(inputBeratTimbangGross) <= 0 && parseFloat(inputBeratTimbangGrossBelakang) <= 0) && jenisKendaraan == "GANDENG")
			){
				$('#inputBeratTimbangGross').val('0').focus().select();
				$('#inputBeratTimbangTara').val('0');
				toastr.warning('Masukkan data berat gross.','Informasi');
			}
			else{
				getBerat(dataParams, function(dataResult){
					dataParams['iputBerat'] = dataResult.berat;
					switch(dataResult.result){
						case 1:
							aksiSimpanTimbang(dataParams, inputNoStrukTimbang);
							console.log("masuk case 1");
						break;
						case 2:

							var html = '<div class="row form-horizontal">';
								html += '<div class="col-md-12">';
								html += '<div class="form-group">';
								html += '<label class="col-md-12">Berat timbang netto lebih kecil dari berat standart karung - Toleransi '+dataResult.toleransi+' Kg (Berat Netto = '+inputBeratTimbangNetto+' - Berat Standart = '+dataResult.berat+')</label>';
								html += '</div>';
								html += '</div>';
								html += '</div>';
							dialogBerat(html, dataParams, inputNoStrukTimbang);
						break;
						case 3:

							var html = '<div class="row form-horizontal">';
								html += '<div class="col-md-12">';
								html += '<div class="form-group">';
								html += '<label class="col-md-12">Berat timbang netto lebih besar dari berat standart karung + Toleransi '+dataResult.toleransi+' Kg (Berat Netto = '+inputBeratTimbangNetto+' + Berat Standart = '+dataResult.berat+')</label>';
								html += '</div>';
								html += '</div>';
								html += '</div>';
							dialogBerat(html, dataParams, inputNoStrukTimbang);
						break;
					}
					
				});
			}
			/*

			}
			else{
				$('#inputBeratTimbangTara').val('0').focus().select();
				toastr.warning('Masukkan data berat gross.','Informasi');
			}
			*/

		}
		else{
			toastr.warning('Berat timbang harus > 0.','Informasi');
		}
	}
	else{
		toastr.warning('Lengkapi data kendaraan.','Informasi');
	}
	
}

function dialogBerat(html, dataParams, inputNoStrukTimbang){
	var konfirmasi = 0;
	var box = bootbox.dialog({
		title : "Konfirmasi",
		message : html,
		buttons : {
			danger : {
				label : "Tidak",
				className : "btn-danger",
				callback : function() {
					return true;
				}
			},
			success : {
				label : "Ya",
				className : "btn-success",
				callback : function() {
					konfirmasi = 1;
					return true;
				}
			},
		}
	});
	
	box.bind('hidden.bs.modal', function() {
		if(konfirmasi == 1){
			aksiSimpanTimbang(dataParams, inputNoStrukTimbang);
		}
	});
	
	
}

function aksiSimpanTimbang(dataParams, inputNoStrukTimbang){
	var counter_time_finger = 0;
	var departemen = 'simpan_timbang';
	var finger = function(){
		$.ajax({
			url : 'probe/kendaraanmasuk/validasiFingerAll',
			type : 'POST',
			dataType:'json',
			async : false,
			beforeSend:function(){
				message.loadingProses('Sedang Proses Verifikasi Finger...')
			},
			error: function(){
				toastr.error("Gagal Verifikasi Finger");
				message.closeLoading();
			},
			success: function(resp){
				if(resp.is_valid){	
					message.closeLoading();
					clearInterval(intFinger);
					$.ajax({
						url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/simpanTimbang',
						data : {
							data : dataParams,
						},
						type : 'post',
						dataType : 'json',
						beforeSend : function(){
						},
						success : function(data){
							
							if(data.result == 1){
								initialButton();
								$('#optionFilter').prop('selectedIndex', 0);
								$('#inputFilter').val(inputNoStrukTimbang);
								$('#optionFilterDate').prop('selectedIndex', 2);
								searchData();
								setTimeout(function(){
									$('table#timbangTable tbody tr:first').click();
								}, 700);
								$('#for_timbang').click();
								toastr.success('Simpan data timbang '+inputNoStrukTimbang+' berhasil.','Informasi');
								// insertGagalFinger(departemen, 'update');
								//untuk timelin
								insertGagalFinger(departemen, dataParams.inputNoMasuk);
							}
							else {
								toastr.error('Simpan data timbang '+inputNoStrukTimbang+' gagal.','Informasi');
							}
							
						},
					}).done(function(){
					})
					return;
				}else{
					if(counter_time_finger >= 30){
							message.closeLoading();
							counter_time_finger = 0;
							clearInterval(intFinger);
							toastr.error("Finger Print Telah gagal");

							//
							insertGagalFinger(departemen,  $('#inputNoMasuk').val());
						}else{
							counter_time_finger += 1;
							toastr.error(resp.message);
						}
				}
			}
		});	
	}

	var intFinger = setInterval(finger, 1000); 		
}

function setCetakKendaraanMasuk(){
	var inputNoMasuk = $('#inputNoMasuk').val();
	var inputNoStrukTimbang = $('#inputNoStrukTimbang').val();
	if(inputNoStrukTimbang && inputNoMasuk){
		// var finger = function(){
		// 	$.ajax({
		// 		url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/validasiFingerAll',
		// 		type : 'POST',
		// 		dataType:'json',
		// 		async : false,
		// 		beforeSend:function(){
		// 			message.loadingProses('Sedang Proses Verifikasi Finger...')
		// 		},
		// 		error: function(){
		// 			toastr.error("Gagal Verifikasi Finger");
		// 			message.closeLoading();
		// 		},
		// 		success: function(resp){
		// 			if(resp.is_valid){	
		// 				message.closeLoading();
		// 				clearInterval(intFinger);
						$.ajax({
							url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/setCetakKendaraanMasuk',
							data : {
								noStrukTimbang: inputNoStrukTimbang
							},
							type : 'post',
							dataType : 'json',
							beforeSend : function(){
							},
							success : function(dataResult){
								if(dataResult.result == 1){
									inputNoMasuk = inputNoMasuk.replace('#','_');
									window.open(dataResult.url+''+inputNoMasuk);
								}
								else{
									toastr.warning('Cetak gagal.', 'Informasi');
									// toastr.warning(dataResult.message);
								}
							},
						}).done(function(){
						});
						// return;
		// 			}else{
		// 				toastr.error(resp.message);	
		// 			}
		// 		}
		// 	});	
		// }
	
		// var intFinger = setInterval(finger, 1000);    						
	}
}

function setNomerOrder(){
	if($('#menuNomerOrder').attr('data-nomerorder')){
		toastr.warning('Nomer order sudah disetting.', 'Informasi');
	}
	else{
		var konfirmasi = 0;
		var html = '<div class="row form-horizontal">';
			html += '<div class="col-md-12">';
			html += '<div class="form-group">';
			html += '<label class="col-md-12">Setting nomer order untuk kendaraan '+($('#menuNomerOrder').attr('data-no-pol'))+'?</label>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
		var box = bootbox.dialog({
			title : "Konfirmasi",
			message : html,
			buttons : {
				success : {
					label : "Ya",
					className : "btn-success",
					callback : function() {
						konfirmasi = 1;
						return true;
					}
				},
				danger : {
					label : "Tidak",
					className : "btn-danger",
					callback : function() {
						return true;
					}
				},
			}
		});

		box.bind('hidden.bs.modal', function() {
			if(konfirmasi == 1){
				$.ajax({
					url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/setNomerOrder',
					data : {
						noStrukTimbang: $('#menuNomerOrder').attr('data-nostruktimbang'),
						noMasuk: $('#menuNomerOrder').attr('data-value')
					},
					type : 'post',
					dataType : 'json',
					beforeSend : function(){
					},
					success : function(dataResult){
						if(dataResult.result == 1){
							initialButton();
							searchData();
						}
						else{
							toastr.warning('Set nomer order gagal.', 'Informasi');
						}
					},
				}).done(function(){
				});
			}
		});
	}
}

function cetakSampel2(){
	var noMasuk = $('#menuSampel2').attr('data-value');
	var sampel2 = $('#menuSampel2').attr('data-sampel2');
	if(!sampel2){
		toastr.warning('Sampel 2 belum dibuat.', 'Informasi');
	}
	else{
		var counter_time_finger = 0;
		var departemen = 'cetak_sample2';

		var finger = function(){
			$.ajax({
				url :'probe/kendaraanmasuk/validasiFingerAll',
				type : 'POST',
				dataType:'json',
				async : false,
				beforeSend:function(){
					message.loadingProses('Sedang Proses Verifikasi Finger...')
				},
				error: function(){
					toastr.error("Gagal Verifikasi Finger");
					message.closeLoading();
				},
				success: function(resp){
					if(resp.is_valid){	
						message.closeLoading();
						clearInterval(intFinger);
						// return;
						setSamplingStart(sampel2, function(dataResult){
							//if(dataResult == 1){								
								window.open(base_url+'admin_plan/kamar_timbang_kendaraan_masuk_erp/printSampel2?id='+noMasuk);								
								setTimeout(insertGagalFinger(departemen, 'update'), 6000);
							//}
							//else{
							//	toastr.warning('Sampel tidak bisa dicetak.', 'Informasi');
							//}
						});
						return;
					}else{
						if(counter_time_finger >= 30){
							message.closeLoading();
							counter_time_finger = 0;
							clearInterval(intFinger);
							toastr.error("Finger Print Telah gagal");

							//
							insertGagalFinger(departemen,  $('#inputNoMasuk').val());
						}else{
							counter_time_finger += 1;
							toastr.error(resp.message);
						}
					}
				}
			});	
		}
		
		// callfinger();
		var intFinger = setInterval(finger, 1000);		
	}
}


function setSamplingStart(sampel2, callback){
		$.ajax({
			url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/setSamplingStart',
			data : {
				sampel2: sampel2
			},
			type : 'post',
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(dataResult){
				callback(dataResult);
			},
		}).done(function(){
		});
}

function setSelected(elm){
	$(elm).select();
}

function getBeratTimbang(elm){  
		$(elm).removeAttr('readonly');
	    setTimeout(function(){
			var berat = $(elm).val();
			berat = (berat) ? parseInt(berat) : 0;
			$(elm).val(berat);
			
			$(elm).attr('readonly', true);
	    }, 0);
		
}

function setBeratTimbang(elm){
	$('#nilaiTimbang').text('');
	$('#nilaiTimbang').text($(elm).val());
	
	if($(elm).attr('data-timbang') == 'tara'){
		var gross = $('#inputBeratTimbangGross').val();
		var tara = $('#inputBeratTimbangTara').val();
		var netto = parseInt(gross) - parseInt(tara);
		$('#inputBeratTimbangNetto').val(netto);
	}

	if($(elm).attr('data-timbang') == 'taraDepan'){
		var gross = $('#inputBeratTimbangGrossDepan').val();
		var tara = $('#inputBeratTimbangTaraDepan').val();
		var netto = parseInt(gross) - parseInt(tara);
		$('#inputBeratTimbangNettoDepan').val(netto);
	}

	if($(elm).attr('data-timbang') == 'taraBelakang'){
		var gross = $('#inputBeratTimbangGrossBelakang').val();
		var tara = $('#inputBeratTimbangTaraBelakang').val();
		var netto = parseInt(gross) - parseInt(tara);
		$('#inputBeratTimbangNettoBelakang').val(netto);
	}
}

function replaceTimbang(elm){
	$(elm).select().focus().val($(elm).val());
	var _elm = '#'+($(elm).attr('id'));
	setBeratTimbang(_elm);
		
}
function getDataTimbang(elm){
		var id = ($(elm).prev().attr('data-timbang') == 'tara') ? 'inputBeratTimbangTara' : 'inputBeratTimbangGross';
		$.ajax({
			url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/getNilaiTimbang',
			data : {
			},
			type : 'post',
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(dataResult){
				console.log('Nilai Timbang = ('+dataResult+')');
				var _elm = '#'+id;
				if (dataResult) {
				} else {
					// toastr.warning('Silahkan klik kirim data timbang.', 'Informasi');
					if (id == 'inputBeratTimbangTara') {
						dataResult = 2000;
					} else {
						dataResult = 30000;
					}
				}
				$(_elm).val(dataResult);
				setBeratTimbang(_elm);
				$(elm).focus().select();
			},
		}).done(function(){
		});
}

function getDataTimbangGrossGandeng(elm){
		var id = ($(elm).prev().attr('data-timbang') == 'grossDepan') ? 'inputBeratTimbangGrossDepan' : 'inputBeratTimbangGrossBelakang';
		$.ajax({
			url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/getNilaiTimbang',
			data : {
			},
			type : 'post',
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(dataResult){
				console.log('Nilai Timbang = ('+dataResult+')');
				var _elm = '#'+id;
				if(dataResult){
				}
				else{
					// toastr.warning('Silahkan klik kirim data timbang.', 'Informasi');
					dataResult = 0;
				}
				$(_elm).val(dataResult);
				setBeratTimbang(_elm);
				$(elm).focus().select();
			},
		}).done(function(){
		});
}

function getDataTimbangTaraGandeng(elm){
		var id = ($(elm).prev().attr('data-timbang') == 'taraDepan') ? 'inputBeratTimbangTaraDepan' : 'inputBeratTimbangTaraBelakang';
		$.ajax({
			url : 'admin_plan/kamar_timbang_kendaraan_masuk_erp/getNilaiTimbang',
			data : {
			},
			type : 'post',
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(dataResult){
				console.log('Nilai Timbang = ('+dataResult+')');
				var _elm = '#'+id;
				if(dataResult){
				}
				else{
					// toastr.warning('Silahkan klik kirim data timbang.', 'Informasi');
					dataResult = 0;
				}
				$(_elm).val(dataResult);
				setBeratTimbang(_elm);
				$(elm).focus().select();
			},
		}).done(function(){
		});
}