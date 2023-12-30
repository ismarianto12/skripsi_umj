<script src="{{ asset('assets/js/jQuery-2.1.4.min.js') }}">
</script>
<link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">
<script src="{{ asset('assets') }}/js/plugin/datatables/datatables.min.js"></script>

<table id="datatable" class="display table table-striped table-hover">
    <thead>
        <tr>
            <th></th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Created By</th>
            <th style="width: 10%">Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Created By</th>
            <th style="width: 10%">Action</th>
        </tr>
    </tfoot>
    <tbody>
    </tbody>
</table>

<script>
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        order: [1, 'asc'],
        pageLength: 10,
        ajax: {
            url: "{{ route('api.tmbangunan') }}",
            method: 'POST',
            _token: "{{ csrf_token() }}",
        },
        columns: [{
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                align: 'center',
                className: 'text-center'
            },
            {
                data: 'kode',
                name: 'kode'
            },
            {
                data: 'nama_bangunan',
                name: 'nama_banguanan'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });

</script>
