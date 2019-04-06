@auth
    <script>
        $("#form-password").on("submit", function (e) {
            $.ajax({
                type: 'POST',
                url: '{{route('client.update.settings')}}',
                data: new FormData($("#form-password")[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        swal('Account Settings', 'Password lama Anda salah!', 'error');
                        $("#error_curr_pass").addClass('has-danger');
                        $("#error_new_pass").removeClass('has-danger');
                        $("#check_password").addClass('is-invalid');
                        $("#password, #password-confirm").removeClass('is-invalid');
                        $(".aj_pass").text("Password lama Anda salah!").parent().show();
                        $(".aj_new_pass").text("").parent().hide();

                    } else if (data == 1) {
                        swal('Account Settings', 'Konfirmasi password Anda tidak cocok!', 'error');
                        $("#error_curr_pass").removeClass('has-danger');
                        $("#error_new_pass").addClass('has-danger');
                        $("#check_password").removeClass('is-invalid');
                        $("#password, #password-confirm").addClass('is-invalid');
                        $(".aj_pass").text("").parent().hide();
                        $(".aj_new_pass").text("Konfirmasi password Anda tidak cocok!").parent().show();

                    } else {
                        swal('Account Settings', 'Password Anda berhasil diperbarui!', 'success');
                        $("#form-password").trigger("reset");
                        $("#error_curr_pass").removeClass('has-danger');
                        $("#error_new_pass").removeClass('has-danger');
                        $("#check_password").removeClass('is-invalid');
                        $("#password, #password-confirm").removeClass('is-invalid');
                        $(".aj_pass").text("").parent().hide();
                        $(".aj_new_pass").text("").parent().hide();
                        $("#show_password_settings").click();
                    }
                },
                error: function () {
                    swal('Oops...', 'Terjadi suatu kesalahan!', 'error');
                }
            });
            return false;
        });

        document.getElementById("file-input").onchange = function () {
            var files_size = this.files[0].size,
                max_file_size = 2000000, allowed_file_types = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'],
                file_name = $(this).val().replace(/C:\\fakepath\\/i, ''),
                progress_bar_id = $("#progress-upload .progress-bar");

            if (!window.File && window.FileReader && window.FileList && window.Blob) {
                swal('PERHATIAN!', "Browser yang Anda gunakan tidak support! Silahkan perbarui atau gunakan browser yang lainnya.", 'warning');

            } else {
                if (files_size > max_file_size) {
                    swal('ERROR!', "Ukuran total " + file_name + " adalah " + humanFileSize(files_size) +
                        ", ukuran file yang diperbolehkan adalah " + humanFileSize(max_file_size) +
                        ", coba unggah file yang ukurannya lebih kecil!", 'error');

                } else {
                    $(this.files).each(function (i, ifile) {
                        if (ifile.value !== "") {
                            if (allowed_file_types.indexOf(ifile.type) === -1) {
                                swal('ERROR!', "Tipe file " + file_name + " tidak support!", 'error');

                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('client.update.settings')}}',
                                    data: new FormData($("#form-ava")[0]),
                                    contentType: false,
                                    processData: false,
                                    mimeType: "multipart/form-data",
                                    xhr: function () {
                                        var xhr = $.ajaxSettings.xhr();
                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (event) {
                                                var percent = 0;
                                                var position = event.loaded || event.position;
                                                var total = event.total;
                                                if (event.lengthComputable) {
                                                    percent = Math.ceil(position / total * 100);
                                                }
                                                //update progressbar
                                                $("#progress-upload").css("display", "block");
                                                progress_bar_id.css("width", +percent + "%");
                                                progress_bar_id.text(percent + "%");
                                                if (percent == 100) {
                                                    progress_bar_id.removeClass("progress-bar-info");
                                                    progress_bar_id.addClass("progress-bar");
                                                } else {
                                                    progress_bar_id.removeClass("progress-bar");
                                                    progress_bar_id.addClass("progress-bar-info");
                                                }
                                            }, true);
                                        }
                                        return xhr;
                                    },
                                    success: function (data) {
                                        $(".show_ava").attr('src', data);
                                        swal('SUKSES!', 'Avatar Anda berhasil diperbarui!', 'success');
                                        $("#progress-upload").css("display", "none");
                                    },
                                    error: function () {
                                        swal('Oops...', 'Terjadi suatu kesalahan!', 'error');
                                    }
                                });
                                return false;
                            }
                        } else {
                            swal('Oops...', 'Tidak ada file yang dipilih!', 'error');
                        }
                    });
                }
            }
        };

        function humanFileSize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024));
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        };
    </script>
@endauth