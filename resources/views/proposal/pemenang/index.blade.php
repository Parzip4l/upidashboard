@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />     
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
@php 
    use Carbon\Carbon;
    use App\PemenangM;
    use App\Proposal;
    use App\KontrakPemenang;
    $currentYear = Carbon::now()->year;

    $pemenang = PemenangM::where('tahun', $currentYear)->first();

    $winnerproposal = null;
    $kontrak = null;
    if ($pemenang) {
        $winnerproposal = Proposal::find($pemenang->proposal_id);
        $kontrak = KontrakPemenang::where('proposal_id',$pemenang->proposal_id)->first();
    }
@endphp
@if(!$pemenang)
  <div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Data Proposal</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Ketua Inovator</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposal as $data)
                            <tr>
                                <td>{{$data->judul_proposal}}</td>
                                <td>{{$data->tipe_proposal}}</td>
                                <td>{{$data->ketua_inovator}}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm" onclick="confirmWinner({{ $data->id }})">
                                        Tetapkan Sebagai Pemenang
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
  </div>
@else 
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5>Data Pemenang Tahun {{$currentYear}}</h5>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Data Proposal</h5>
                    <div class="data-pemenang-details mt-4 mx-2">
                        <div class="group-data-pemenang mb-2">
                            <h6>Judul Proposal</h6>
                            <p class="text-muted">{{$winnerproposal->judul_proposal}}</p>
                        </div>
                        <div class="group-data-pemenang mb-2">
                            <h6>Ketua Inovator</h6>
                            <p class="text-muted">{{$winnerproposal->ketua_inovator}}</p>
                        </div>
                        <div class="group-data-pemenang mb-2">
                            <h6>Skema Proposal</h6>
                            <p class="text-muted">
                                @if ($winnerproposal->skema == 1)
                                    Hilirisasi inovasi hasil riset untuk tujuan komersialisasi
                                @elseif ($winnerproposal->skema == 2)
                                    Hilirisasi kepakaran untuk menjawab Kebutuhan DUDI
                                @elseif ($winnerproposal->skema == 3)
                                    Pengembangan Produk inovasi bersama DUDI/Mitra Inovasi
                                @elseif ($winnerproposal->skema == 4)
                                    Peningkatan TKDN atau Produk Substitusi Impor
                                @else
                                    Skema tidak diketahui
                                @endif
                            </p>
                        </div>
                        <div class="group-data-pemenang mb-2">
                            <h6>Tipe Proposal</h6>
                            <p class="text-muted">{{$winnerproposal->tipe_proposal}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-4">Kontrak Proposal</h5>
                    @if(!$kontrak)
                        <h5>Kontrak Belum dibuat</h5>
                        <a href="{{ route('generate.word', $winnerproposal->id) }}" class="btn btn-primary btn-sm mt-2">
                            Generate Kontrak
                        </a>
                    @else 
                        <h5>Kontrak Sudah Dibuat</h5>
                        <a href="{{ route('generate.word', $winnerproposal->id) }}" target="_blank" class="btn btn-primary btn-sm mt-2">
                            Download Kontrak
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script>
        function confirmWinner(idProposal) {
            Swal.fire({
                title: 'Yakin menetapkan sebagai pemenang?',
                text: "Data ini akan disimpan ke database!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tetapkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirimkan data ke server menggunakan AJAX
                    fetch('/penetapan-pemenang', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id_proposal: idProposal,
                            tahun: new Date().getFullYear(),
                            ditetapkan_oleh: '{{ Auth::user()->id }}'
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Berhasil!',
                                'Data telah disimpan sebagai pemenang.',
                                'success'
                            ).then(() => {
                                // Reload halaman setelah konfirmasi
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menyimpan data.',
                                'error'
                            );
                        }
                    }).catch(error => {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan pada server.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush