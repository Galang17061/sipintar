$(function () {

	getAntrianNBBM();
	getPrintNBBM();

	$('#DbtnSimpan').attr('disabled', true);

	$('#inputBeratTimbangGross, #inputBeratTimbangTara').numeric({
		allowPlus: false,
		allowMinus: false,
		allowThouSep: false,
		allowDecSep: true
	});

	$('#nbbm-tab a').click(function (e) {
		e.preventDefault();

		var tabIndex = $($(this).attr('href')).index();
		switch (tabIndex) {
			case 1:
				getPrintNBBM();
				break;
		}
	});

	$("body").on("contextmenu", "table#antrianNBBMTable tbody tr td", function (e) {
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
		(noMasuk.substr(0, 2) == 'KM') ? $('#menuSampel2').removeClass('hide'): $('#menuSampel2').addClass('hide');
		($('#inputKM').val()) ? $('#menuSampel2').removeClass('hide'): $('#menuSampel2').addClass('hide');
		//(!noOrder) ? $('#menuNomerOrder').removeClass('hide') : $('#menuNomerOrder').addClass('hide');
		return false;
	});

});

function cetakDepan() {
	$('#btnInputManual').val('depan');
}

function cetakBelakang() {
	$('#btnInputManual').val('belakang');
}

function setCetakNBBM() {
	var pInputNoNBBM = $('#pInputNoNBBM').val();
	var pInputNoMasuk = $('#pInputNoMasuk').val();
	var pInputNoStrukTimbangN = $('#pInputNoStrukTimbangN').val();
	var jenisKendaraan = $('#pInputJenisKendaraan').val();
	var cetakan = $('#btnInputManual').val();

	$.ajax({
		url: 'admin_plan/nbbm/setCetakNBBM',
		data: {
			noNBBM: pInputNoNBBM
			//jenisKendaraan : jenisKendaraan		
		},
		type: 'post',
		dataType: 'json',
		beforeSend: function () {},
		success: function (data) {
			console.log("print");
			var tmpInputNoMasuk = pInputNoMasuk.replace('#', '_');
			//location.href = data.url+'noStrukTimbang='+pInputNoStrukTimbangN+'&noMasuk='+tmpInputNoMasuk+'&jenis='+jenisKendaraan+'&cetakan='+cetakan;
			window.open(data.url + 'noStrukTimbang=' + pInputNoStrukTimbangN + '&noMasuk=' + tmpInputNoMasuk + '&jenis=' + jenisKendaraan + '&cetakan=' + cetakan);
			//window.open(data.url+'noStrukTimbang='+pInputNoStrukTimbangN+'&noMasuk='+tmpInputNoMasuk);
		},
	}).done(function () {

	});

}

function setCetakNBBMDepan() {
	var pInputNoNBBM = $('#pInputNoNBBM').val();
	var pInputNoMasuk = $('#pInputNoMasuk').val();
	var pInputNoStrukTimbangN = $('#pInputNoStrukTimbangN').val();
	var jenis = "DEPAN";
	$.ajax({
		url: 'admin_plan/nbbm/setCetakNBBMDepan',
		data: {
			noNBBM: pInputNoNBBM,
			jenis: jenis
		},
		type: 'post',
		dataType: 'json',
		beforeSend: function () {},
		success: function (data) {
			var tmpInputNoMasuk = pInputNoMasuk.replace('#', '_');
			window.open(data.url + 'noStrukTimbang=' + pInputNoStrukTimbangN + '&noMasuk=' + tmpInputNoMasuk + '&cetakan=' + jenis);
		},
	}).done(function () {

	});

}

function setCetakNBBMBelakang() {
	var pInputNoNBBM = $('#pInputNoNBBM').val();
	var pInputNoMasuk = $('#pInputNoMasuk').val();
	var pInputNoStrukTimbangN = $('#pInputNoStrukTimbangN').val();
	$.ajax({
		url: 'admin_plan/nbbm/setCetakNBBMBelakang',
		data: {
			noNBBM: pInputNoNBBM
		},
		type: 'post',
		dataType: 'json',
		beforeSend: function () {},
		success: function (data) {
			var tmpInputNoMasuk = pInputNoMasuk.replace('#', '_');
			window.open(data.url + 'noStrukTimbang=' + pInputNoStrukTimbangN + '&noMasuk=' + tmpInputNoMasuk);
		},
	}).done(function () {

	});

}

function getAntrianNBBM() {
	var dOptionFilter = $('#dOptionFilter').val();
	var dInputFilter = $('#dInputFilter').val();
	var dataParams = {
		'dOptionFilter': dOptionFilter,
		'dInputFilter': dInputFilter
	}
	$.ajax({
		url: 'admin_plan/nbbm/getAntrianNBBM',
		data: {
			data: dataParams
		},
		type: 'post',
		dataType: 'html',
		beforeSend: function () {
			$('#dataAntrianNBBM').html('<div class="text-center" style="margin-bottom:15px;"><img width="3%" height="3%" src="' + base_url + 'assets/images/loading.gif"></div>');
		},
		success: function (data) {
			$('#dataAntrianNBBM').html(data);
		},
	}).done(function () {
		var maxHeight = 250;
		var heightTable = parseInt($('#antrianNBBMTable').height());
		if (heightTable > maxHeight) {
			$('#dataAntrianNBBM #antrianNBBMTable').scrollabletable({
				'max_height_scrollable': maxHeight,
			});
			$('div').scroll(function () {
				$("#contextMenu").addClass("hide");
			});
		}
	});

}

function getPrintNBBM() {
	var failed = 0;
	var pOptionFilter = $('#pOptionFilter').val();
	var pInputFilter = $('#pInputFilter').val();
	var pOptionFilterDate = $('#pOptionFilterDate').val();
	var pInputFilterDate = $('#pInputFilterDate').val();

	var dataParams = {
		'pOptionFilter': pOptionFilter,
		'pInputFilter': pInputFilter,
		'pOptionFilterDate': pOptionFilterDate,
		'pInputFilterDate': pInputFilterDate,
	}
	if (pOptionFilterDate == 3) {
		if (!pInputFilterDate && !pInputFilter) {
			failed++;
		}
	}
	if (failed == 0) {
		$.ajax({
			url: 'admin_plan/nbbm/getPrintNBBM',
			data: {
				data: dataParams
			},
			type: 'post',
			dataType: 'html',
			beforeSend: function () {
				$('#dataPrintNBBM').html('<div class="text-center" style="margin-bottom:15px;"><img width="3%" height="3%" src="' + base_url + 'assets/images/loading.gif"></div>');
			},
			success: function (data) {
				$('#dataPrintNBBM').html(data);
			},
		}).done(function () {
			var maxHeight = 250;
			var heightTable = parseInt($('#printNBBMTable').height());
			if (heightTable > maxHeight) {
				$('#dataPrintNBBM #printNBBMTable').scrollabletable({
					'max_height_scrollable': maxHeight,
				});
				$('div').scroll(function () {
					$("#contextMenu").addClass("hide");
				});
			}
		});

	} else {
		toastr.warning('Parameter input harus lengkap.', 'Informasi');
	}

}

function dOptionFilterKontrol() {
	$('#dInputFilter').val('').focus().select();
}

function getDetailAntrianNBBM(elm) {
	$('#DbtnSimpan').removeAttr('disabled');
	$('table#antrianNBBMTable tbody tr').removeClass('selected');
	$('div.truk input').val('');
	$('td.td-label-keterangan').text('');
	var tr = $(elm);
	tr.addClass('selected');
	$('#dInputNoMasuk').val(tr.find('td.col-no-masuk').text());
	$('#dInputNoPolisi').val(tr.find('td.col-no-polisi').text());
	$('#dInputNamaSopir').val(tr.find('td.col-nama-sopir').text());
	$('#dInputJamDatang').val(tr.find('td.col-tanggal-datang').text());
	$('#dInputJenisPacking').val(tr.attr('data-jenis-packing'));
	$('#dInputJenisKendaraan').val(tr.attr('data-jenis-kendaraan'));
	var keterangan = tr.find('td.col-keterangan').text();
	$('td.td-label-keterangan').text(keterangan);
	var warna = (keterangan == 'IMPORT') ? 'red' : 'blue';
	$('td.td-label-keterangan').css('color', warna);
}

function dProsesLanjut() {
	var noStrukTimbang = $('table#antrianNBBMTable tbody tr.selected td.col-no-struktimbang').text();
	$('#pInputNoStrukTimbangN').val(noStrukTimbang);
	var nomerMasuk = $('#dInputNoMasuk').val();
	getDataStrukTimbang(noStrukTimbang, nomerMasuk, function (result) {
		if (result == 1) {
			prosesLanjut();
		} else {
			toastr.warning('Data tidak ada.', 'Informasi');
		}
	});

}

function getDetailNBBM(elm) {
	//resetPrintNBBM();
	var noStrukTimbang = $(elm).find('td.col-no-timbang').text();
	var nomerMasuk = $(elm).find('td.col-no-masuk').text();
	getDataStrukTimbang(noStrukTimbang, nomerMasuk, function (result) {
		if (result == 1) {} else {}
	});
}

function prosesLanjut() {
	//var no_sampel = $('#pInputNoSampel2').val();
	//var kode_brg = $('#pInputKode').val();
	var dataParams = {
		'nomerMasuk': $('#dInputNoMasuk').val(),
		'noPolisi': $('#dInputNoPolisi').val(),
		'nomerOrder': $('table#antrianNBBMTable tbody tr.selected').attr('data-no-order'),
		'noStrukTimbang': $('#pInputNoStrukTimbangN').val(),
		'noPolisi': $('#pInputNoPolisi').val(),
		'noSampel': $('#pInputNoSampel2').val(), //no_sampel.replace(" ,", ""),
		'kodeBarang': $('#pInputKode').val(), //kode_brg.replace(" ,", ""),
		'collyTrm': $('#pInputBeratTerimaSak').val(),
		'collyRaf': $('#pInputBeratTerimaSak').val(),
		'kgTrm': $('#pInputBeratTerimaKg').val(),
		'taraKrg': $('#pInputTaraKarungLbr').val(),
		'kgB': $('#pInputBeratTerimaKg').val(),
		'kgN': $('#pInputBeratNetto').val(),
		'catatan1': $('#pInputCatatanKT').val(),
		'catatan2': $('#pInputCatatanQC').val(),
		'biayaLainLain': $('#pInputBiayaLain').val(),
		'ketLainLain': $('#pInputKeterangan').val(),
		'noContainer': $('#pInputNoMasuk').attr('data-no-container'),
		'tonase': $('#pInputNoMasuk').attr('data-tonase')
	};
	console.log(dataParams);


	var finger = function () {
		$.ajax({
			url: url.base_url("probe/kendaraanmasuk") + "validasiFingerAll",
			type: 'POST',
			dataType: 'json',
			async: false,
			beforeSend: function () {
				message.loadingProses('Sedang Proses Verifikasi Finger...')
			},
			error: function () {
				toastr.error("Gagal Verifikasi Finger");
				message.closeLoading();
			},
			success: function (resp) {
				if (resp.is_valid) {
					message.closeLoading();
					clearInterval(intFinger);
					//fungsi bawah

					$.ajax({
						url: 'admin_plan/nbbm/prosesLanjutNBBM',
						data: {
							data: dataParams
						},
						type: 'post',
						dataType: 'json',
						beforeSend: function () {

						},
						success: function (data) {
							if (data.result == 1) {
								resetDaftarNBBM();

								getAntrianNBBM();
								resetPrintNBBM();

								getPrintNBBM();
								toastr.success('Proses lanjut berhasil.', 'Informasi');
							} else {
								toastr.error('Proses lanjut gagal.', 'Informasi');
							}
						},
					}).done(function () {});
					return;
				} else {
					toastr.error(resp.message);
				}
			}
		});
	}

	var intFinger = setInterval(finger, 3000);
}

function getDataStrukTimbang(noStrukTimbang, nomerMasuk, callback) {
	$.ajax({
		url: 'admin_plan/nbbm/getDataStrukTimbang',
		data: {
			noStrukTimbang: noStrukTimbang,
			nomerMasuk: nomerMasuk
		},
		type: 'post',
		dataType: 'json',
		beforeSend: function () {},
		success: function (data) {
			$('#pInputNoNBBM').val(data.N.NO_NBBM);
			$('#pInputWaktuNBBM').val(data.N.SERVER_TIME);
			$('#pInputNoSampel2').val(data.N.NO_SAMPEL2);
			$('#pInputNoMasuk').val(data.N.NOMERMASUK);
			$('#pInputNoMasuk').attr('data-no-container', data.N.NOCONTAINER);
			$('#pInputNoMasuk').attr('data-tonase', data.N.TONASE);
			$('#pInputNoOP').val(data.N.NOMERORDER);
			$('#pInputBiayaLain').val(data.N.BIAYALAINLAIN);
			$('#pInputKeterangan').val(data.N.KET_LAINLAIN);
			$('#pInputNoStrukTimbangN').val(data.N.NOSTRUKTIMBANG);

			$('#pInputKode').val(data.N.KODE_BARANG);
			$('#pInputNama').val(data.B.NAMA);
			$('#pInputJenis').val(data.B.JENIS);
			$('#pInputUmurSimpan').val(data.B.UMUR_SIMPAN);
			$('#pInputMinimalStok').val(data.B.MIN_STOCK);
			$('#pInputBeratTerimaSak').val(data.N.COLLY);
			$('#pInputBeratTerimaKg').val(data.N.KG_TERIMA);
			$('#pInputTaraKarungLbr').val(data.N.TARA_KRG);
			$('#pInputTaraKarungKg').val(data.N.KG_TARA);
			$('#pInputBeratNetto').val(data.N.KG_NETTO);

			$('#pInputNoPolisi').val(data.N.NOPOL);
			$('#pInputNamaSopir').val(data.N.NAMASOPIR);
			$('#pInputJamDatang').val(data.N.WAKTUDATANG);
			$('#pInputJenisPacking').val(data.N.JENISPACKING);
			$('#pInputJenisKendaraan').val(data.N.JENISKENDARAAN);
			$('#pInputNoStrukTimbangK').val(data.N.NOSTRUKTIMBANG);
			$('#pInputBeratTrukMuatan').val(data.N.BERATGROSS);
			$('#pInputBeratTrukKosong').val(data.N.BERATTRUK);

			$('#pInputCatatanQC').val(data.N.CATATAN_QC);

			$('div#analisa-fisik').html(data.A.F);
			$('div#analisa-kimia').html(data.A.K);

			$('div#print_preview').html(data.P);
			/*
			 $('div#analisa-fisik #fisikTable').scrollabletable({
			 'max_height_scrollable' : 100,
			 });
			 */
			callback(data.result);
		},
	}).done(function () {});

}

function resetDaftarNBBM() {
	$('div.truk input').val('');
	$('#DbtnSimpan').attr('disabled', true);
	$('td.td-label-keterangan').text('');
}

function resetPrintNBBM() {
	$('div#data-nbbm').find('input, textarea').val('');
	$('#fisikTable tbody, #kimiaTable tbody').html('');
	$('#pInputNoMasuk').attr('data-no-container', '');
	$('#pInputNoMasuk').attr('tonase', '');
	$('#p').html('');
}