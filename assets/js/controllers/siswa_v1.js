var siswa_data = {
    module: function () {
        return 'siswa';
    },

    simpan: function () {
        console.log(url.base_url(siswa_data.module()));
        if (validation.run()) {
            siswa_data.exec_save();
        }
    },

    get_post_data: function () {
        var data = {
            'id': $('#id').val(),
            'nama': $('#nama').val(),
            'nis': $('#nis').val(),
            'kelas': $('#kelas').val(),
            'password': $('#password').val(),
            'jurusan': $('#jurusan').val()
        };
        return data;
    },

    exec_save: function () {
        var data = siswa_data.get_post_data();
        var formData = new FormData();
        formData.append('data', JSON.stringify(data));

        $.ajax({
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            url: url.base_url(siswa_data.module()) + 'save',
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

                siswa_data.resetformInput();
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    },

    resetformInput: function () {
        $('#jurusan').val('');
        $('#nama').val('');
        $('#kelas').val('');
        $('#nis').val('');
        $('#password').val('');
    },

    search: function (elm, e) {
        if (e.keyCode == 13 && $(elm).val() != '') {
            var keyword = $(elm).val();
            $.ajax({
                type: 'POST',
                data: {
                    keyword: keyword
                },
                dataType: 'html',
                async: false,
                url: siswa_data.module() + '/search',
                beforeSend: function () {
                    // message.showDialog('Proses Mendapatkan Data..');
                },
                success: function (resp) {
                    message.closeDialog();
                    $('.data_siswa').html(resp);
                    helper.freezeHeaderTable();
                }
            });
        }
    },

    remove: function (id) {
        var html = '<div>';
        html += '<p>Apakah anda yakin akan menghapus data ini ? </p>';
        html += '<div class="text-right">';
        html += '<button class="btn btn-primary" onclick="siswa_data.exec_remove(' + id + ')">Ya</button> &nbsp;';
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
            url: url.base_url(siswa_data.module()) + 'remove' + '/' + id,
            success: function (resp) {
                if (resp.is_valid) {
                    message.success('.message', 'Data ' + id + ' Berhasil Dihapus');
                    setTimeout(siswa_data.reloadPage(), 1000);
                } else {
                    message.error('.message', 'Data ' + id + ' Gagal Dihapus');
                }

                message.closeDialog();
            }
        });
    },

    resetLogin: function (siswa) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            async: false,
            url: url.base_url(siswa_data.module()) + 'resetLogin' + '/' + siswa,
            error: function () {
                message.error('.message', 'Jaringan Error');
            },

            success: function (resp) {
                if (resp.is_valid) {
                    message.success('.message', 'Login Siswa Berhasil Direset');
                    setTimeout(siswa_data.reloadPage(), 1000);
                } else {
                    message.error('.message', 'Login Siswa Gagal Direset');
                }
            }
        });
    },

    importSiswa: function () {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            async: false,
            url: url.base_url(siswa_data.module()) + 'importSiswa',
            success: function (resp) {
                // message.showMaterialDialog('Import File Siswa', resp);
                //    message.showDialog(resp);
                bootbox.dialog({
                    message: resp,
                    size: 'large'
                });
            }
        });
    },

    execUploadFileSiswa: function (csv_data) {
        var data = csv_data;
        var formData = new FormData();
        formData.append('data', JSON.stringify(csv_data));

        $.ajax({
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            async: false,
            url: url.base_url(siswa_data.module()) + 'execUploadFileSiswa',
            beforeSend: function () {
                $('.loading_data').html('<i class="mdi mdi-autorenew mdi-18px">Proses Uploaded.....</i>');
            },

            error: function () {
                message.error('.message', 'Jaringan Bermasalah');
            },

            success: function (resp) {
                if (resp.is_valid) {
                    message.success('.message', 'Siswa Berhasil Dimasukkan');
                    var reload = function () {
                        window.location.reload();
                    };
                    setTimeout(reload(), 1000);
                } else {
                    message.error('.message', 'Siswa Gagal Dimasukkan');
                }
                $('.loading_data').html('');
            }
        });
    },

    getUploadedData: function (elm) {
        if (window.FileReader) {
            var file_csv = $(elm).get(0).files[0];
            var file_name = file_csv.name;
            var data_from_file = file_csv.name.split('.');
            var type_file = $.trim(data_from_file[data_from_file.length - 1]);

            var setNameFiletoTextInput = $(elm).closest('.input-field').find('.file-path').val(file_name).css({
                'font-size': '12px'
            });
            if (type_file == 'csv') {
                if (file_csv.size <= 512000) {
                    var reader = new FileReader();
                    reader.readAsText(file_csv);

                    reader.onload = function (event) {
                        var data_csv;
                        var csv = event.target.result;
                        data_csv = helper.processExtractCsv(csv);
                        var csv_data = [];
                        for (var i = 0; i < data_csv.length; i++) {
                            csv_data.push(data_csv[i]);
                        }

                        siswa_data.execUploadFileSiswa(csv_data);
                    };
                } else {
                    message.error('.message', 'Gagal Upload, Ukuran File Maximal 512 KB');
                }
            } else {
                message.error('.message', 'File Harus Berformat csv');
                $(elm).val('');
            }
        } else {
            message.error('.message', 'FileReader is Not Supported');
        }
    },

    callPagination: function () {
        (function (name) {
            var container = $('#pagination-' + name);
            var sources = function () {
                var result = [];

                for (var i = 1; i < 196; i++) {
                    result.push(i);
                }

                return result;
            }();


            var options = {
                dataSource: sources,
                callback: function (response, pagination) {
                    //     console.log("iki respon",pagination);
                    //     window.console && console.log(response, pagination);

                    var dataHtml = '<ul class="pagination">';

                    dataHtml += '<li class="disabled"><a href="#!"><i class="mdi mdi-chevron-left"></i></a></li>';
                    $.each(response, function (index, item) {
                        dataHtml += '<li><a href="#!">' + item + '</a></li>';
                    });

                    dataHtml += '<li class="waves-effect"><a href="#!"><i class="mdi mdi-chevron-right"></i></a></li>';
                    dataHtml += '</ul>';

                    container.prev().html(dataHtml);
                }
            };

            //$.pagination(container, options);

            container.addHook('beforeInit', function () {
                window.console && console.log('beforeInit...');
            });
            container.pagination(options);

            container.addHook('beforePageOnClick', function () {
                window.console && console.log('beforePageOnClick...');
                //return false
            });
        })('demo1');
    },

    removeAll: function (elm, e) {
        e.preventDefault();
        var check_data = $('.check_siswa');

        console.log(check_data);
        var data = [];
        $.each(check_data, function () {
            if ($(this).is(':checked')) {
                data.push({
                    'id': $(this).closest('tr').attr('data_id')
                });
            }
        });

        var formData = new FormData();
        formData.append('data', JSON.stringify(data));

        console.log("data", data);
        if (data.length > 0) {
            $.ajax({
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                async: false,
                url: url.base_url(siswa_data.module()) + "removeAll",
                error: function () {
                    message.error('.message', 'Soal Error Dimasukkan');
                    message.closeLoading();
                },

                beforeSend: function () {

                },

                success: function (resp) {
                    if (resp.is_valid) {
                        message.success('.message', 'Soal Sukses Dimasukkan');
                        var reload = function () {
                            window.location.reload();
                        };

                        setTimeout(reload(), 1000);
                    } else {
                        message.error('.message', 'Soal Gagal Dimasukkan');
                    }
                }
            });
        } else {
            message.error('.message', 'Soal Belum Ada yang Dipilih');
        }
    },

    checkAll: function (elm) {
        var check_data = $('.check_siswa');
        if ($(elm).is(':checked')) {
            $.each(check_data, function () {
                if (!$(this).is(':checked')) {
                    $(this).prop('checked', true);
                }
            });
        } else {
            $.each(check_data, function () {
                $(this).prop('checked', false);
            });
        }
    },

    checked: function () {
        var check_data = $('.check_siswa');
        var total_data = check_data.length;
        var checked = 0;

        $.each(check_data, function () {
            if ($(this).is(':checked')) {
                checked += 1;
            }
        });

        console.log(checked + " dan " + total_data);
        if (checked == total_data) {
            console.log("podo");
            $('#check_all_head').prop('checked', true);
        } else {
            console.log("ga podo");
            $('#check_all_head').prop('checked', false);
        }
    }
};

$(function () {

});