$(function(){
	$('input,textarea').keyup(function(){
		upper_text(this);
	});
	listkendaraan();
	/* tiap 5 menit lakukan refresh data, 5 menit = 300000 miliseconds*/
//	setInterval(listkendaraan,300000);
})

function viewData(elm){
	var _tr = $(elm);
	var _obj = {}, _class;
	/* tambahkan kelas tr_terpilih */
	_tr.closest('tbody').find('tr.tr_terpilih').removeClass('tr_terpilih');
	_tr.addClass('tr_terpilih');
	_tr.find('td').each(function(){
		_class = $(this).attr('class');
	if(_class != undefined && _class != ''){
			_obj[_class] = $(this).text();
		}
	});

	_obj['jeniskendaraan'] = _tr.data('jeniskendaraan');
	_obj['jenispacking'] = _tr.data('jenispacking');
	for(var i in _obj){
		$('#detailViewData').find('[name='+i+']').val(_obj[i]);
	}
	var _labelHeader = {
		'Import' : 'KEPUTUSAN HASIL SAMPEL 1',
		'Sampel 1': 'KEPUTUSAN HASIL SAMPEL 1',
		'No Sampel1' : 'KEPUTUSAN HASIL SAMPEL 1',
		'Sampel 2': 'KEPUTUSAN HASIL SAMPEL 2',
		'Timbang' : 'KEPUTUSAN HASIL TIMBANG TARE',
		'Tolak Sampel 2' : 'HASIL ANALISA SAMPEL 2'
	};
	var _keputusan = '';
	var _cekDataServer = 1;


	if($.trim(_obj['ket']) == 'Tolak Sampel 2'){
		_cekDataServer = 0;
		$('#viewKeputusan').find('.keterangan').html('&nbsp;');
		$('#viewKeputusan').find('.keputusan').html('TOLAK').css({
			'color' : 'red'
		});
		$('#viewKeputusan').find('.btn.btn-lanjut').text('Terima');
	}

	console.log(_obj['ket']);
	console.log("#view");
	$('#viewKeputusan').find('.header').html($.trim(_labelHeader[$.trim(_obj['ket'])]));

	console.log('check', _cekDataServer);
	if(_cekDataServer){		
		$.ajax({
			url : 'gudang/antriankendaraan/checkKeputusanSample',
			type : 'post',
			data : { nosampel : _obj.nosampel, ket : _obj.ket , nomermasuk : _obj.nomermasuk},
			dataType : 'json',
			beforeSend : function(){
				$('#viewKeputusan').find('.keputusan').html('');
				$('#viewKeputusan').find('.keterangan').html('');
				if($('#viewKeputusan').find('.btn.btn-lanjut').hasClass('disabled')){
					$('#viewKeputusan').find('.btn.btn-lanjut').addClass('disabled');
				};

				if($('#viewKeputusan').find('.btn.btn-lanjut').text() == 'Terima'){
					$('#viewKeputusan').find('.btn.btn-lanjut').text('Proses Lanjut');
				}
			},
			success : function(data){
				$('#viewKeputusan').find('.keputusan').css({
					'color' : 'blue'
				});
				if(data.status){
					var _keterangan = !empty($.trim(data.content.ket)) ? data.content.ket : '&nbsp;' ;
					$('#viewKeputusan').find('.keputusan').html(data.content.keputusan);
					$('#viewKeputusan').find('.keterangan').html(_keterangan);
					$('#viewKeputusan').find('.btn.btn-lanjut').removeClass('disabled');
					if(data.content.keputusan == 'TOLAK'){
						$('#viewKeputusan').find('.keputusan').css({
							'color' : 'red'
						});
					}

					$('select#silo_khusus').html(data.kavling_khusus);	

					$('select#silo_khusus').removeAttr('disabled');
					$('select#lokasi_bongkar').removeAttr('disabled');
				}else{
					$('#viewKeputusan').find('.keputusan').html(data.content.keputusan);
				}
			},
		})
	}
}

function proseslanjut(elm){
	var ini = $(elm);
	var _text = ini.text();

	console.log('OK', _text);
	var url,data;
	var nomermasuk = $('#detailViewData').find('[name=nomermasuk]').val();
	if(_text == 'Terima'){
		/* update nilai gudang = 1 di t_penolakan */
		url = 'gudang/antriankendaraan/updatepenolakan';
		data = { nomermasuk : nomermasuk};
	}else{
		var _caption = $('#viewKeputusan').find('.header').text();
		console.log(_caption);
		if(_caption == 'KEPUTUSAN HASIL SAMPEL 1'){
			/* tampilkan form untuk cetak spb */
			var _obj = {}, _class, _tr;
			_tr = $('#listKendaraan tr.tr_terpilih');
			_tr.find('td').each(function(){
				_class = $(this).attr('class');
				if(_class != undefined && _class != ''){
					_obj[_class] = $(this).text();
				}
			});
			_obj['jeniskendaraan'] = _tr.data('jeniskendaraan');
			_obj['jenispacking'] = _tr.data('jenispacking');
			_obj['statusbarang'] = _tr.data('statusbarang');
			_obj['colly'] = _tr.data('colly');
			_obj['tonase'] = _tr.data('tonase');
			popupformspb(_obj);
		}
	}
}

function popupformspb(_obj){
	for(var i in _obj){
		$('#formspbmodal').find('[name='+i+']').val(_obj[i]);
	}
		$('#formspbmodal').modal({'backdrop':'static','keyboard':false});
}

function simpanspb(elm){
	var lokasi = $('#lokasi_bongkar').val();
	var silo_destination = $('select#silo_khusus').val();
	var _form = $(elm).closest('form');
	var _obj = {} , _error = 0;
	_form.find('.required').each(function(){
		if(!$.trim($(this).val()).length){
			_error++;
			$(this).next('.help-block').text($(this).attr('placeholder')+' harus diisi');
			$(this).closest('.form-group').addClass('has-error');
		}
	});
	if($(elm).hasClass('disabled')){
		_error++;
		toastr.warning('Masih proses di server');
	}
	if(!_error){
		_form.find('input.kirimData').each(function(){
			_obj[$(this).attr('name')] = $(this).val();
		});
		/* simpan spb ke database */
		$.ajax({
			url : 'gudang/antriankendaraan/simpanSpb',
			type : 'post',
			data : { data : _obj, lokasi : lokasi, silo_destination: silo_destination},
			dataType : 'json',
			beforeSend : function(){
				$(elm).addClass('disabled');
			},
			success : function(data){
				if(data.status){
					$(elm).removeClass('disabled');
					toastr.success(data.message);
					$('#formspbmodal').modal('hide');
					$('#formspbmodal .form-group.has-error').removeClass('has-error');
					$('#listKendaraan tr.tr_terpilih').remove();
					$('#info_jumlah').val($('#listKendaraan tbody>tr').length);
					resetForm();
				}
				else{
					resetForm();
					toastr.error(data.message);
				}
			}
		});
	}

}

function resetForm(){
		$('#viewKeputusan').find('.btn.btn-lanjut').addClass('disabled');
		$('#detailViewData').find('input').val('');
		$('#formspbmodal').find('input').val('');
}

function listkendaraan(){
	var _nilai = $('input[name=inputFilter]').val();
	var _kategori = $('select[name=optionFilter]').val();
	var _data = {};
	if($.trim(_nilai) != ''){
		_data = { id : _kategori , val : _nilai};
	}
	$.ajax({
		url : 'gudang/antriankendaraan/listAntrian',
		data : _data,
		type : 'post',
		dataType : 'html',
		beforeSend : function(){
			$('#listKendaraan').html('Silakan tunggu....');
		},
		success : function(data){
			$('#listKendaraan').html(data);
			/* update jumlah kendaraan */
			$('#info_jumlah').val($('#listKendaraan tbody>tr').length);
		},
	}).done(function(){
		if($('#listKendaraan table').height() > 250){
			$('#listKendaraan table').scrollabletable({
				  'max_height_scrollable' : 250,
				  'max_width' : $('#listKendaraan').width() - 30,
			});
		}
	})
}
