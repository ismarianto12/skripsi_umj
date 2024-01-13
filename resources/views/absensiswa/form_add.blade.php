<div class="card">
    <div class="card-header">
        <div class="card-title">Tambah Data siswa</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group"><label>NIS</label><input type="text" class="form-control " id="nis"
                        name="nis" placeholder="Nomor Induk siswa" value=""></div>
                <div class="form-group form-box"><label>Password</label>
                    <div class="input-group"><input type="password" class="form-control " id="password" name="password"
                            placeholder="Password" value=""></div>
                </div>
                <div class="form-group"><label>Nama Lengkap</label><input type="text" class="form-control "
                        id="nama" name="nama" placeholder="Nama Lengkap" value=""></div>
                <div class="form-group"><label>Email</label><input type="text" class="form-control " id="email"
                        name="email" placeholder="Email" value=""></div>
                <div class="form-group"><label>Nomor Hp</label><input type="number" class="form-control "
                        id="no_hp" name="no_hp" placeholder="Nomor Hp" value=""></div>
                <div class="form-group"><label for="jk" class="col-form-label">Jenis Kelamin:</label><select
                        class="form-control " id="jk" name="jk">
                        <option value="">- Jenis Kelamin -</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select></div>
                <div class="form-group"><label>Tanggal Lahir</label><input type="date" class="form-control "
                        id="ttl" name="ttl" value=""></div>
                <div>
                    <div class="form-group"><label>Provinsi:</label><select class="form-control " name="provinsi">
                            <option value="" selected="">Pilih Provinsi</option>
                            <option data="11" value="ACEH">ACEH</option>
                            <option data="12" value="SUMATERA UTARA">SUMATERA UTARA</option>
                            <option data="13" value="SUMATERA BARAT">SUMATERA BARAT</option>
                            <option data="14" value="RIAU">RIAU</option>
                            <option data="15" value="JAMBI">JAMBI</option>
                            <option data="16" value="SUMATERA SELATAN">SUMATERA SELATAN</option>
                            <option data="17" value="BENGKULU">BENGKULU</option>
                            <option data="18" value="LAMPUNG">LAMPUNG</option>
                            <option data="19" value="KEPULAUAN BANGKA BELITUNG">KEPULAUAN BANGKA BELITUNG
                            </option>
                            <option data="21" value="KEPULAUAN RIAU">KEPULAUAN RIAU</option>
                            <option data="31" value="DKI JAKARTA">DKI JAKARTA</option>
                            <option data="32" value="JAWA BARAT">JAWA BARAT</option>
                            <option data="33" value="JAWA TENGAH">JAWA TENGAH</option>
                            <option data="34" value="DI YOGYAKARTA">DI YOGYAKARTA</option>
                            <option data="35" value="JAWA TIMUR">JAWA TIMUR</option>
                            <option data="36" value="BANTEN">BANTEN</option>
                            <option data="51" value="BALI">BALI</option>
                            <option data="52" value="NUSA TENGGARA BARAT">NUSA TENGGARA BARAT</option>
                            <option data="53" value="NUSA TENGGARA TIMUR">NUSA TENGGARA TIMUR</option>
                            <option data="61" value="KALIMANTAN BARAT">KALIMANTAN BARAT</option>
                            <option data="62" value="KALIMANTAN TENGAH">KALIMANTAN TENGAH</option>
                            <option data="63" value="KALIMANTAN SELATAN">KALIMANTAN SELATAN</option>
                            <option data="64" value="KALIMANTAN TIMUR">KALIMANTAN TIMUR</option>
                            <option data="65" value="KALIMANTAN UTARA">KALIMANTAN UTARA</option>
                            <option data="71" value="SULAWESI UTARA">SULAWESI UTARA</option>
                            <option data="72" value="SULAWESI TENGAH">SULAWESI TENGAH</option>
                            <option data="73" value="SULAWESI SELATAN">SULAWESI SELATAN</option>
                            <option data="74" value="SULAWESI TENGGARA">SULAWESI TENGGARA</option>
                            <option data="75" value="GORONTALO">GORONTALO</option>
                            <option data="76" value="SULAWESI BARAT">SULAWESI BARAT</option>
                            <option data="81" value="MALUKU">MALUKU</option>
                            <option data="82" value="MALUKU UTARA">MALUKU UTARA</option>
                            <option data="91" value="PAPUA BARAT">PAPUA BARAT</option>
                            <option data="94" value="PAPUA">PAPUA</option>
                        </select></div>
                    <div class="form-group"><label>Kabupaten:</label><select class="form-control " name="kabupaten">
                            <option value="" selected="">Pilih Kabupaten</option>
                        </select></div>
                    <div class="form-group"><label>Kecamatan:</label><select class="form-control " name="kecamatan">
                            <option value="" selected="">Pilih Kecamatan</option>
                        </select></div>
                    <div class="form-group"><label>Kelurahan:</label><select class="form-control " name="kelurahan">
                            <option value="" selected="">Pilih Kelurahan</option>
                        </select></div>
                </div>
                <div class="form-group"><label>Alamat</label>
                    <textarea rows="4" class="form-control " id="alamat" name="alamat" placeholder="Alamat Lengkap"></textarea>
                </div>
                <div class="form-group"><label>Nama Ayah</label><input type="text" class="form-control "
                        id="nama_ayah" name="nama_ayah" placeholder="Nama Orang Tua" value=""></div>
                <div class="form-group"><label>Nama Ibu</label><input type="text" class="form-control "
                        id="nama_ibu" name="nama_ibu" placeholder="Nama Orang Tua" value=""></div>
                <div class="form-group"><label>Nama Wali</label><input type="text" class="form-control "
                        id="nama_wali" name="nama_wali" placeholder="Nama Wali" value=""></div>
            </div>
            <div class="col-md-6">
                <div class="form-group"><label>Pekerjaan Ayah</label><select class="form-control " id="pek_ayah"
                        name="pek_ayah">
                        <option value="true">- Pekerjaan Ayah -</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Pedagang">Pedagang</option>
                        <option value="Buruh">Buruh</option>
                        <option value="Pensiunan">Pensiunan</option>
                        <option value="Guru">Guru</option>
                        <option value="Honorer">Honorer</option>
                        <option value="PNS">PNS</option>
                    </select></div>
                <div class="form-group"><label>Pekerjaan Ibu</label><select class="form-control " id="pek_ibu"
                        name="pek_ibu">
                        <option value="true">- Pekerjaan Ibu -</option>
                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Pedagang">Pedagang</option>
                        <option value="Buruh">Buruh</option>
                        <option value="Pensiunan">Pensiunan</option>
                        <option value="Guru">Guru</option>
                        <option value="Honorer">Honorer</option>
                        <option value="PNS">PNS</option>
                    </select></div>
                <div class="form-group"><label>Pekerjaan Wali</label><select class="form-control " id="pek_wali"
                        name="pek_wali">
                        <option value="- Pekerjaan Wali -">- Pekerjaan Wali -</option>
                        <option value="Tidak ada wali">Tidak ada wali</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Pedagang">Pedagang</option>
                        <option value="Buruh">Buruh</option>
                        <option value="Pensiunan">Pensiunan</option>
                        <option value="Guru">Guru</option>
                        <option value="Honorer">Honorer</option>
                        <option value="PNS">PNS</option>
                    </select></div>
                <div class="form-group"><label>Penghasilan Ortu / Wali</label><select class="form-control "
                        id="peng_ortu" name="peng_ortu">
                        <option value="- Penghasilan / Bulan -">- Penghasilan / Bulan -</option>
                        <option value="< Rp.1.000.000">&lt;&lt; Rp.1.000.000</option>
                        <option value="Rp.1.000.000 - Rp.2.000.000">Rp.1.000.000 - Rp.2.000.000</option>
                        <option value="Rp.2.000.000 - Rp.3.000.000">Rp.2.000.000 - Rp.3.000.000</option>
                        <option value="Rp.3.000.000 - Rp.4.000.000">Rp.3.000.000 - Rp.4.000.000</option>
                        <option value="Rp.4.000.000 - Rp.5.000.000">Rp.4.000.000 - Rp.5.000.000</option>
                        <option value="Rp.5.000.000 >">Rp.5.000.000 &gt;&gt;</option>
                    </select></div>
                <div class="form-group"><label>Nomor Telepon Ortu / Wali</label><input type="text"
                        class="form-control " id="no_telp" name="no_telp" placeholder="Nomor Telepon"
                        value=""></div>
                <div class="form-group"><label>Sekolah Asal</label><input type="text" class="form-control "
                        id="sekolah_asal" name="sekolah_asal" placeholder="Sekolah Asal" value=""></div>
                <div class="form-group"><label>Kelas</label><input type="text" class="form-control "
                        id="kelas_old" name="kelas_old" placeholder="Kelas" value=""></div>
                <div class="form-group"><label>Tahun Lulus</label><input type="number" class="form-control "
                        id="thn_lls" name="thn_lls" placeholder="Tahun Lulus" value=""></div>
                <div class="form-group row">
                    <div class="col-sm-3"><img width="100" height="85" id="preview" class="img-thumbnail">
                    </div>
                    <div class="col-sm-9"><input hidden="" type="file" name="img_siswa" class="file"
                            accept="image/*" id="imgInp" value="">
                        <div class="input-group my-3"><input type="text" class="form-control " disabled=""
                                placeholder="Foto siswa" id="file">
                            <div class="input-group-append"><button type="button"
                                    class="browse btn btn-primary">Browse</button></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3"><img
                            src="https://png.pngtree.com/png-vector/20190623/ourmid/pngtree-documentfilepagepenresume-flat-color-icon-vector-png-image_1491048.jpg"
                            width="100" height="85" id="preview1" class="img-thumbnail"></div>
                    <div class="col-sm-9"><input hidden="" type="file" name="img_kk" class="file1"
                            accept="image/*" id="imgInp1">
                        <div class="input-group my-3"><input type="text" class="form-control " disabled=""
                                placeholder="Foto KK (Kartu keluarga)" id="file1">
                            <div class="input-group-append"><button type="button"
                                    class="browse1 btn btn-primary">Browse</button></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3"><img
                            src="https://png.pngtree.com/png-vector/20190623/ourmid/pngtree-documentfilepagepenresume-flat-color-icon-vector-png-image_1491048.jpg"
                            width="100" height="85" id="preview2" class="img-thumbnail"></div>
                    <div class="col-sm-9"><input hidden="" type="file" name="img_ijazah" class="file2"
                            accept="image/*" id="imgInp2">
                        <div class="input-group my-3"><input type="text" class="form-control " disabled=""
                                placeholder="Foto Ijazah" id="file2">
                            <div class="input-group-append"><button type="button"
                                    class="browse2 btn btn-primary">Browse</button></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3"><img
                            src="https://png.pngtree.com/png-vector/20190623/ourmid/pngtree-documentfilepagepenresume-flat-color-icon-vector-png-image_1491048.jpg"
                            width="100" height="85" id="preview3" class="img-thumbnail"></div>
                    <div class="col-sm-9"><input hidden="" type="file" name="img_ktp" class="file3"
                            accept="image/*" id="imgInp3">
                        <div class="input-group my-3"><input type="text" class="form-control " disabled=""
                                placeholder="Foto Akte / KTP" id="file3">
                            <div class="input-group-append"><button type="button"
                                    class="browse3 btn btn-primary">Browse</button></div>
                        </div>
                    </div>
                </div><br>
                <div class="form-group"><label>Tahun Masuk</label><select class="form-control " id="thn_msk"
                        name="thn_msk">
                        <option value="- Pilih Periode -">- Pilih Periode -</option>
                        <option value="2">2022/2023</option>
                    </select></div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group"><label>Pendidikan</label><select class="form-control "
                                    id="pendidikan" name="pendidikan">
                                    <option value="- Pilih pendidikan -">- Pilih pendidikan -</option>
                                    <option value="1">SD</option>
                                    <option value="9">TK</option>
                                    <option value="10">SMP</option>
                                    <option value="12">KB</option>
                                </select></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br><br>
        <div class="_stepbackgroundalkdmsaldkma exssubmitform pt-3 form-group row">
            <div class="col-md-12 text-center"><button type="submit" class="btn-block btn btn-success"
                    style="width: 40%; margin-right: 15px;">Simpan</button><button type="reset"
                    class="btn-block btn btn-danger" style="width: 40%;">Batal</button></div>
        </div>

    </form>
</div>


<script type="text/javascript">
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            // alert('asa');
            $.ajax({
                url: "{{ route('master.siswa.store') }}",
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
                    //  $('.ket').html(
                    //      "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Perahtian donk!</strong> " +
                    //      respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
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
</script>
