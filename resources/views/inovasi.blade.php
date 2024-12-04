@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.bootstrap5.min.css" rel="stylesheet"/>
<link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Data Registrasi</h5>
                <a href="{{ route('hilirasasi-inovasi.export') }}" class="btn btn-success">Export to Excel</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table yajra-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Perguruan Tinggi</th>
                                <th>Program Studi</th>
                                <th>Judul Inovasi</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
<script type="text/javascript">
  $(function () {
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('hilirasasi-inovasi.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'fakultas_kamda', name: 'fakultas_kamda'},
            {data: 'prodi', name: 'prodi'},
            {
                data: 'judul_proposal', 
                name: 'judul_proposal',
                render: function(data, type, row) {
                    return data.length > 30 ? data.substring(0, 30) + '...' : data;
                }
            },
            {
                data: 'status', 
                name: 'status',
                render: function(data, type, row) {
                    return `<select class="form-select status-select" data-id="${row.id}">
                        <option value="pending" ${data == 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="disetujui" ${data == 'disetujui' ? 'selected' : ''}>Approved</option>
                        <option value="ditolak" ${data == 'ditolak' ? 'selected' : ''}>Rejected</option>
                    </select>`;
                }
            },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
    // Redirect to the show page on click
    $('.yajra-datatable').on('click', '.details', function () {
        var id = $(this).data('id');
        window.location.href = `{{ url('hilirasasi-inovasi/single') }}/${id}`;
    });

    // Handle status change
    $('.yajra-datatable').on('change', '.status-select', function() {
        var id = $(this).data('id');
        var status = $(this).val();
        $.ajax({
            url: "{{ route('hilirasasi-inovasi.update-status') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update status.',
                });
            }
        });
    });
  });
</script>

<script type="text/javascript">
  $(function () {
    // Handle Details button click
    $('.yajra-datatable').on('click', '.details', function () {
        var id = $(this).data('id');
        var fotoProdukInovasi = $(this).data('foto-produk-inovasi');
        var dokumenProdukInovasi = $(this).data('dokumen-produk-inovasi');

        // Set data in the modal
        $('#modal-foto-produk-inovasi').attr('href', "{{ url('hilirasasi-inovasi/download/foto_produk_inovasi/') }}/" + id);
        $('#modal-dokumen-produk-inovasi').attr('href', "{{ url('hilirasasi-inovasi/download/dokumen_produk_inovasi/') }}/" + id);
        $('#modal-poster-inovasi').attr('href', "{{ url('hilirasasi-inovasi/download/poster_inovasi/') }}/" + id);
        $('#modal-powerpoint').attr('href', "{{ url('hilirasasi-inovasi/download/powerpoint/') }}/" + id);
        $('#modal-video-inovasi').attr('href', "{{ url('hilirasasi-inovasi/download/video_inovasi/') }}/" + id);
        // Show the modal
        $('#detailsModal').modal('show');
    });

    // Handle download links
    $('#modal-foto-produk-inovasi, #modal-dokumen-produk-inovasi','#modal-poster-inovasi','#modal-powerpoint','#modal-video-inovasi').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                // Notify success
                Swal.fire({
                    title: 'Success!',
                    text: 'File downloaded successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function (xhr) {
                // Notify failure
                Swal.fire({
                    title: 'Error!',
                    text: 'File download failed. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
  });
</script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    @endif
</script>
@endpush
f(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    @endif
</script>
@endpush
