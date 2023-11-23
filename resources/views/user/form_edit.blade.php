<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _('Edit Data User Data Hak Akses') }}</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan" enctype="multipart/form-data">

        <div class="card-body">
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Username<span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="username" name="username" value="{{ $username }}"
                        disabled>
                    <small>Username tidak bisa di ganti *</small>
                </div>

                <label for="name" class="col-md-2 text-left">Nama<span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $name }}">
                </div>
            </div>

            <div class="form-group row">

                <label for="name" class="col-md-2 text-left">Password <span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <label for="name" class="col-md-2 text-left">Email<span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="email" class="form-control" id="email" name="email" value="{{ $email }}">
                </div>


            </div>
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Konfirmasi <br /> Password <span
                        class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="password" class="form-control" id="password" name="password_k">
                </div>

                <label for="name" class="col-md-2 text-left">Level Akses <span class="required-label">*</span></label>
                <div class="col-md-4">
                    {{-- select level was here --}}
                    <select name="tmlevel_id" class="form-control">
                        @foreach ($level as $lev)
                            @php
                                $selected = $lev->id == $id_lev ? 'selected' : '';
                            @endphp
                            <option value="{{ $lev->id }}" {{ $selected }}>{{ $lev->level }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-2 text-left">Foto<span class="required-label">*</span></label>
                    <div class="col-md-4">
                        <img src="{{ asset('assets') }}/img/profile.jpg" alt="" class="header-avatar"
                            id="cc_upload_preview" class="img-responsive" style="width: 200px;height: 250px"
                            onerror="this.onerror=null;this.src='{{ asset('assets') }}/img/profile.jpg';">
                        <br /> <br />
                        <input type='file' id="foto" name="foto" class='form-control' placeholder='Foto..'>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <label for="name" class="col-md-2 text-left">Proyek </label>
                    <div class="col-md-4">
                        @php echo Properti_app::comboproyek($tmproyek_id) @endphp
                    </div>
                </div>
            </div>
        </div>

        <div class="card-action">
            <div class="row">
                <div class="col-md-12">
                    <input class="btn btn-success" type="submit" value="Simpan">
                    <button class="btn btn-danger" type="reset">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{ Auth::user()->proyekid }}

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });

    $(function() {

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#cc_upload_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#foto").change(function() {
            var ext = $('#foto').val().split('.').pop().toLowerCase();
            //Allowed file types
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                swal('File Error', 'tidak bisa upload', 'warning');
                $('#foto').val('');
            } else {
                readURL(this);
            }
        });

        $('.simpan').on('submit', function(e) {
            e.preventDefault();



            if ($('input[name="password_k"]').val() != $('input[name="password"]').val()) {
                $.notify({
                    icon: 'flaticon-alarm-1',
                    title: 'Kesalahan',
                    message: 'Password tidak sama',
                }, {
                    type: 'secondary',
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    time: 3000,
                    z_index: 2000
                });
            } else if ($('input[name="password_k"]').val() == '') {
                $.notify({
                    icon: 'flaticon-alarm-1',
                    title: 'Kesalahan',
                    message: 'Konfirmasi Passowrd Wajib di isi.',
                }, {
                    type: 'secondary',
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    time: 3000,
                    z_index: 2000
                });
            } else {
                var datastring = new FormData(this);
                $.ajax({
                    url: "{{ route('master.user.update', $id) }}",
                    method: "PUT",
                    data: datastring,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#datatable').DataTable().ajax.reload();
                        $('#formmodal').modal('hide');
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Info',
                            message: 'Berhasil di Simpan',
                        }, {
                            type: 'secondary',
                            placement: {
                                from: "center",
                                align: "right"
                            },
                            time: 1000,
                            z_index: 2000
                        });
                    },
                    error: function(data) {
                        var div = $('#container');
                        setInterval(function() {
                            var pos = div.scrollTop();
                            div.scrollTop(pos + 2);
                        }, 10)
                        err = '';
                        respon = data.responseJSON;
                        $.each(respon.errors, function(index, value) {
                            err += "<li>" + value + "</li>";
                        });
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Opp Seperti nya lupa inputan berikut :',
                            message: err,
                        }, {
                            type: 'secondary',
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            time: 3000,
                            z_index: 2000
                        });

                    }
                })
            }
        });
    });
    // sellect 2

</script>
