<div class="card">
    <div class="card-header">
        <div class="card-title">Tambah Jadwal Presensi
        </div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">
        <div class="card-body">

            <div class="form-group row">
                <label fror="kelas_id" class="col-md-2 text-left"> Kelas</label>
                <div class="col-md-4">
                    <select class="form-control" name="kelas">
                        @foreach ($kelas as $datakelas)
                            <option value="{{ $datakelas->kelas }}">{{ $datakelas->kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label fror="mapel_id" class="col-md-2 text-left"> Mata Pelajaran</label>
                <div class="col-md-4">
                    <select class="form-control" name="mapel_id">
                        @foreach ($mapel as $mapels)
                            <option value="{{ $mapels->id }}"> {{ $mapels->nama_mapel }} </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="form-group row">
                <label fror="pertemuan" class="col-md-2 text-left"> Pertemuan</label>
                <div class="col-md-4">
                    <select class="form-control" name="pertemuan">
                        @php
                            for ($i = 1; $i <= 16; $i++) {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                        @endphp
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label fror="sesi" class="col-md-2 text-left"> Sesi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="sesi" />
                    <small>Silahkan Kosong kan jika tidak perlu</small>
                </div>
            </div>

            <div class="form-group row">
                <label fror="sesi" class="col-md-2 text-left"> Jam Mulai</label>
                <div class="col-md-4">
                    <input type="time" class="form-control" name="jam_mulai" />
                    <small>Silahkan Kosong kan jika tidak perlu</small>
                </div>
            </div>

            <div class="form-group row">
                <label fror="sesi" class="col-md-2 text-left"> Jam Selesai</label>
                <div class="col-md-4">
                    <input type="time" class="form-control" name="jam_selesai" />
                    <small>Silahkan Kosong kan jika tidak perlu</small>
                </div>
            </div>

            <div class="form-group row">
                <label fror="sesi" class="col-md-2 text-left"> Hari</label>

                <div class="col-md-4">

                    <select name="hari" class="form-control">
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <option value="{{ $hari }}">{{ $hari }}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="form-group row">
                <label fror="jumlah_siswa" class="col-md-2 text-left"> Jumlah Siswa</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="jumlah_siswa" />
                </div>
            </div>
            <div class="form-group row">
                <label fror="guru_id" class="col-md-2 text-left"> Guru Pengampu</label>
                <div class="col-md-4">
                    <select class="form-control" name="guru_id">
                        @foreach ($guru as $gurus)
                            <option value="{{ $gurus->id }}">
                                {{ $gurus->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


        </div>
        <div class="card-action" style="margin-top: 10px">

            <div class="row">
                <div class="col-md-12 row">
                    <button type="submit" class="btn btn-info btn-sm" style="width: 40%">Simpan</button>
                    &nbsp;&nbsp;
                    <button type="reset" class="btn btn-danger btn-sm" style="width: 40%">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('master.jadwal.store') }}",
                method: "POST",
                data: $(this).serialize(),
                chace: false,
                async: false,
                success: function(data) {
                    $('#datatable').DataTable().ajax.reload();
                    $('#formmodal').modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data berhasil di simpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
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
        });

    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });
</script>
