<div class="card">
    <div class="card-header">
        <div class="card-title">Edit Data guru</div>
    </div>
    <div class="ket"></div>
    <form id="exampleValidation" method="POST" class="simpan" novalidate>

        <div class="form-group row">
            <label class="col-md-4">Nik</label>
            <div class="col-md-4">
                <input name="nik" value="{{ $data->nik }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Nama</label>
            <div class="col-md-4">
                <input name="nama" value="{{ $data->nama }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Jenis kelamin</label>
            <div class="col-md-4">
                <select class="form-control" id="jk" name="jk">
                    <option value="">- Jenis Kelamin -</option>
                    @foreach (Properti_app::JenisKel() as $jk => $val)
                    <option value="{{ $jk }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Tempat Lahir</label>
            <div class="col-md-4">
                <input name="ttl" value="{{ $data->ttl }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Email</label>
            <div class="col-md-4">
                <input name="email" value="{{ $data->email }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">password</label>
            <div class="col-md-4">
                <input name="password" value="{{ $data->password }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Alamat</label>
            <div class="col-md-4">
                <textarea class="form-control" name="alamat">{{ $data->alamat }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Telp.</label>
            <div class="col-md-4">
                <input name="telp" value="{{ $data->telp }}" class="form-control" />
            </div>
        </div>


        <div class="form-group row">
            <label class="col-md-4">Inensif</label>
            <div class="col-md-4">
                <input name="intensif" value="{{ $data->intensif }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Jam mengajar</label>
            <div class="col-md-4">
                <input name="jam_mengajar" value="{{ $data->jam_mengajar }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Nominal jam</label>
            <div class="col-md-4">
                <input name="nominal_jam" value="{{ $data->nominal_jam }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Bpjs</label>
            <div class="col-md-4">
                <input name="bpjs" value="{{ $data->bpjs }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Koperasi</label>
            <div class="col-md-4">
                <input name="koperasi" value="{{ $data->koperasi }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Simpanan</label>
            <div class="col-md-4">
                <input name="simpanan" value="{{ $data->simpanan }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Tabungan</label>
            <div class="col-md-4">
                <input name="tabungan" value="{{ $data->tabungan }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Pendidikan</label>
            <div class="col-md-4">
                <select class="form-control" name="pendidikan">
                    @foreach (Properti_app::jenjangApp() as $item => $val)
                    <option value="{{ $item }}">
                        {{ $val }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        
        <div class="form-group row">
            <label class="col-md-4">status</label>
            <div class="col-md-4">

                <select class="form-control" name="status">
                    @foreach (Properti_app::jenjangPeg() as $item => $val)
                    <option value="{{ $item }}">
                        {{ $val }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4">Pendidikan</label>
            <div class="col-md-4">
                <select class="form-control" name="pendidikan">
                    @foreach (Properti_app::jenjangApp() as $item => $val)
                    <option value="{{ $item }}">
                        {{ $val }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">status</label>
            <div class="col-md-4">
                <select class="form-control" name="pendidikan">
                    @foreach (Properti_app::jenjangPeg() as $item => $val)
                    <option value="{{ $item }}">
                        {{ $val }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-action">
            <div class="row">
                <div class="col-md-12">
                    <input class="btn btn-success btn-sm" type="submit" value="Simpan">
                    <button class="btn btn-danger btn-sm" type="reset">Batal</button>
                </div>
            </div>
    </form>
</div>