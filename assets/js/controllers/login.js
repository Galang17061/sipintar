var login = {
    module: function () {
        return 'login';
    },

    sign_in: function (elm, e) {
        // console.log(e);
        e.preventDefault();

        var username = $('#username').val();
        var password = $('#password').val();

        if (validation.run()) {
            $.ajax({
                type: 'POST',
                data: {
                    username: username,
                    password: password
                },
                dataType: 'json',
                async: false,
                url: login.module() + '/sign_in',
                error: function () {
                    //     message.error('.message', 'Login Gagal, Terjadi Error di Server');
                    toastr.error("Login Gagal, Terjadi Error di Server");
                },

                success: function (resp) {
                    if (resp.is_valid) {
                        //      message.success('.message', 'Login Berhasil Dilakukan');
                        toastr.success("Login Berhasil Dilakukan");
                        setTimeout(login.goto_dashboard(resp.is_siswa), 1000);
                    } else {
                        //      message.error('.message', 'Username atau Password Tidak Valid');
                        toastr.error("Username atau Password Tidak Valid");
                    }
                }
            });
        }
    },

    goto_dashboard: function (is_siswa) {
        url = "dashboard";
        if (is_siswa) {
            url = "daftar_ujian_ready";
        }
        window.location = url;
    }
};