@extends('layouts.template')
@section('content')
    @include('layouts.breadcum')
    <script>
        // document.body.style.overflow = 'hidden';
    </script>
    <style>
        #dragdrop .well {
            background: #fff
        }

        #dragdrop .well .header {
            color: #000;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 6px
        }

        #dragdrop .well .subheader {
            color: #969696;
            font-size: 12px;
            padding: 8px;
            border-bottom: 1px solid #ccc;
            background: #fff;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-top-right-radius: 2px;
            -moz-border-radius-topleft: 2px;
            -moz-border-radius-topright: 2px;
            border-top-left-radius: 2px;
            border-top-right-radius: 2px
        }

        #dragdrop .well .subheader .buttonsml {
            background: #5bb95b;
            padding: 3px;
            color: #fff;
            font-size: 11px;
            line-height: 9px
        }

        .draglist-shift {
            margin-left: -3% !important;
            width: 53% !important
        }

        .sortable-list {
            background-color: #fff;
            list-style: none;
            margin-bottom: 10px;
            min-height: 30px;
            padding: 15px
        }

        .sortable-list:last-child {
            margin-bottom: 0
        }

        .placeholder {
            background-color: #ff0;
            border: 1px dashed #666;
            height: 40px;
            margin-bottom: 5px
        }

        .dragbleList {
            max-height: 400px;
            overflow: auto
        }

        .sortable-item {
            background: #f1f1f1 url(dragListicon.png?ezimgfmt=ng%3Awebp%2Fngcb6)10px 10px no-repeat;
            cursor: move;
            display: block;
            margin-bottom: 2px;
            padding: 6px 6px 6px 24px;
            color: #5a5a5a;
            font-size: 12px
        }
    </style>
    <script>
        const fixedElts = document.querySelectorAll('nav a');
        const parentElt = document.querySelectorAll('main');
        const bubbleFixedScroll = e => {
            if (e.deltaMode) {
                parentElt.scrollTop += e.deltaY;
            }
        };
        fixedElts.forEach(fixedElt => {
            fixedElt.addEventListener('card-body', bubbleFixedScroll)
        });
    </script>



    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div id="sortable-div" class="addSub row">
                    <div class="col-md-6" id="dragdrop">


                        <div class="form-group">
                            <select class="form-control select2" name="jenis_column_id" id="jenis_column_id" required>
                                <option value="">Pilih Jenis</option>
                                @foreach (Properti_app::jenis_surat() as $jenis_surat => $val)
                                    <option value="{{ $jenis_surat }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br />

                        <div class="asdsadasdsa____">

                        </div>
                        <div class="alert alert-success">Column Database</div>

                        <ul class="sortable-list" style="width: 90%;background:#fff">
                            @foreach ($column as $columns)
                                <li class="sortable-item alert alert-info">

                                    @if ($columns != 'site_id' && $columns != 'site_name' && $columns != 'alamat_site')
                                        <input type="hidden" name="column_x[]"
                                            value="replace(tmsurat_master.{{ $columns }},'.','') as {{ $columns }}" />
                                    @else
                                        <input type="hidden" name="column_x[]" value="tmsurat_master.{{ $columns }}" />
                                    @endif
                                    <i class="fa fa-list"></i>
                                    @if ($columns == 'nomor_pks')
                                        Nomor PKS
                                    @else
                                        {{ ucwords(str_replace('_', ' ', $columns)) }}
                                    @endif
                                    <br />
                                </li>
                            @endforeach
                        </ul>

                    </div>


                    <div class="col-md-6" id="dragdrop">
                        <div class="well clearfix" style="overflow:  auto">
                            <div class="alert alert-info">Di pilih</div>
                            <form method="GET" action="{{ route('master.download_report') }}" id="download_dzx">

                                <ul class="sortable-list">
                                    <li class="sortable-item alert alert-info ui-sortable-handle"
                                        style="position: relative; left: 0px; top: 0px;">
                                        <input type="hidden" name="column_x[]" value="tmsurat_master.site_id">
                                        <i class="fa fa-list"></i>
                                        Site Id
                                        <br>
                                    </li>
                                    <li class="sortable-item alert alert-info ui-sortable-handle"
                                        style="position: relative; left: 0px; top: 0px;">
                                        <input type="hidden" name="column_x[]" value="tmsurat_master.site_name">
                                        <i class="fa fa-list"></i>
                                        Site Name
                                        <br>
                                    </li>
                                </ul>
                                {{-- <div class="form-group row">
                                    <div class="col-md-5">
                                        <select class="form-control" name="jenis_surat_id" id="jenis_surat_id">
                                            @foreach (Properti_app::jenis_surat() as $jenisSurats => $key)
                                                <option value="{{ $jenisSurats }}"> {{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <button class="btn btn-primary btn-sm"><i class="fa fa-save"></i>Generat
                                    Report
                                </button>
                                <br /> <br />

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(function() {
            $('#sortable-div .sortable-list').sortable({
                connectWith: '#sortable-div .sortable-list',
                placeholder: 'placeholder',
                // containment: 'parent'
                cursor: 'crosshair',
                update: function(event, ui) {
                    var order = $("#sortable").sortable("toArray");
                    var inputan_group_parent = $('#jenis_sx').val();
                    var jenis_pilih = $('#jenis_pilih').val();

                    if (inputan_group_parent != jenis_pilih) {
                        //ENABLE WHATEVER HERE
                    }
                }
            });
            $('#jenis_column_id').on('change', function() {
                var id = $(this).val();
                $.post('{{ url('jenis_show/') }}/' + id).done(function(data) {
                    $('.asdsadasdsa____').html(data);
                    // $('.asdsadasdsa____').sortable({});
                    $('#sortable-div .sortable-list').sortable({
                        connectWith: '#sortable-div .sortable-list',
                        placeholder: 'placeholder',
                        // containment: 'parent'
                        cursor: 'crosshair',
                        update: function(event, ui) {
                            var order = $("#sortable").sortable("toArray");
                            var inputan_group_parent = $('#jenis_sx').val();
                            var jenis_pilih = $('#jenis_pilih').val();

                            if (inputan_group_parent != jenis_pilih) {
                                //ENABLE WHATEVER HERE
                            }
                        }
                    });
                });
            });

        });

        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
@endsection
