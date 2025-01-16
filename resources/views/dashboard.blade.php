@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Hi {{ Auth::user()->name }}, Welcome to Hilirisasi Inovasi UPI</h4>
  </div>
</div>
@if (Auth::user()->role === 'admin' || Auth::user()->role === 'reviewer')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6>Semua Pengajuan</h6>
            </div>
            <div class="card-body">
                <h4>{{$hilirisasi}}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6>Pengajuan Pending</h6>
            </div>
            <div class="card-body">
                <h4>{{$pending}}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6>Pengajuan Disetujui</h6>
            </div>
            <div class="card-body">
                <h4>{{$approved}}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6>Pengajuan Ditolak</h6>
            </div>
            <div class="card-body">
                <h4>{{$rejected}}</h4>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-4">Data Proposal Perlu Direview</h6>
                </div>
                <div class="d-flex flex-column">
                    @php 
                        $no = 1;
                    @endphp
                    @foreach($dataPending as $data)
                    <a href="{{route('hilirasasi-inovasi.show', $data->id)}}" class="d-flex align-items-center border-bottom pb-3 pt-3">
                        <div class="me-3 align-self-start">
                           {{$no++}}
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal text-body mb-1 limited-text" style="text-transform:capitalize;">{{$data->judul_proposal}}</h6>
                            </div>
                            <p class="text-muted tx-13">{{$data->fakultas_kamda}} - {{$data->prodi}}</p>
                            
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-xl-8 stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-4">Data Proposal Terbaru</h6>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th class="pt-0">#</th>
                <th class="pt-0">Judul</th>
                <th class="pt-0">Status</th>
                <th class="pt-0">Ketua Inovator</th>
                <th class="pt-0">Aksi</th>
              </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1;
                @endphp
                @foreach($dataTerbaru as $databaru)
                @php 
                    $user = App\User::where('id',$databaru->user_id)->first();
                @endphp
                    <tr>
                        <td>{{$no++}}</td>
                        <td class="limited-text">{{$databaru->judul_proposal}}</td>
                        <td>
                        <span class="badge 
                            @if($databaru->status == 'ditolak') bg-danger
                            @elseif($databaru->status == 'review') bg-warning
                            @elseif($databaru->status == 'revisi') bg-warning
                            @elseif($databaru->status == 'submited') bg-primary
                            @elseif($databaru->status == 'disetujui') bg-success
                            @else bg-secondary
                            @endif">
                            {{$databaru->status}}
                        </span>
                        </td>
                        <td>{{$databaru->ketua_inovator}}</td>
                        <td><a href="{{route('hilirasasi-inovasi.show', $databaru->id)}}" class="btn btn-sm btn-primary">Details</a></td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div> 
    </div>
  </div>
</div> <!-- row -->
@endif

<!-- User Ara -->
@if (Auth::user()->role === 'user')
@php 

    // Mengambil data proposal yang dibuat oleh pengguna saat ini
    $dataProposal = App\Proposal::where('created_by', Auth::user()->id)->first();
    $dataTeam = collect(); // Default collection kosong
    $user = Auth::user(); // Ambil data user langsung dari Auth
    $kolaborasi = null;

    if ($dataProposal) {
        // Jika $dataProposal ditemukan, ambil data terkait
        $dataTeam = App\TeamComposition::where('proposal_id', $dataProposal->id)->get();
        $kolaborasi = App\Collaboration::where('proposal_id', $dataProposal->id)->first();
    }
@endphp
@if($dataProposal)

<div class="alert-banner @if($dataProposal->status == 'ditolak') error
            @elseif($dataProposal->status == 'review') warning
            @elseif($dataProposal->status == 'submited') info
            @elseif($dataProposal->status == 'selesai di review') info
            @elseif($dataProposal->status == 'revisi') warning
            @elseif($dataProposal->status == 'waiting-verifikasi-revisi') warning
            @elseif($dataProposal->status == 'sebagai pemenang') success
            @else bg-secondary @endif">
    <div class="alert-content">
        <h4>Proposal {{$dataProposal->status}}</h4>
        <p>{{$dataProposal->judul_proposal}}</p>
        <p>
            @if($dataProposal->status ==='waiting-verifikasi-revisi')
                Proposal Anda sedang menunggu proses verifikasi. Harap menunggu hasil verifikasi
            @elseif($dataProposal->status ==='revisi')
                Proposal Anda memerlukan revisi. Silakan periksa catatan dan lakukan perbaikan.
            @elseif($dataProposal->status ==='submited')
                Proposal Anda sedang menunggu proses verifikasi administrasi.
            @elseif($dataProposal->status ==='selesai di review')
                Proposal Anda telah selesai di review, silahkan menunggu untuk penetapan pemenang.
            @elseif($dataProposal->status ==='sebagai pemenang')
                Proposal Anda telah ditetapkan sebagai pemenang, silahkan menunggu untuk penandatanganan kontrak.
            @endif
        </p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-8 grid-margin grid-margin-xl-0">
        <div class="card">
            <div class="card-body">
                <div class="card-title-head-custom d-flex justify-content-between">
                    <div class="judul align-self-center">
                        <h6 class="card-title align-self-center mb-0">Proposal Data </h6>
                        <span class="badge 
                            @if($dataProposal->status == 'ditolak') bg-danger
                            @elseif($dataProposal->status == 'review') bg-warning
                            @elseif($dataProposal->status == 'revisi') bg-warning
                            @elseif($dataProposal->status == 'disetujui') bg-success
                            @elseif($dataProposal->status == 'waiting-verifikasi-revisi') bg-warning
                            @else bg-secondary
                            @endif">
                            {{$dataProposal->status}}
                        </span>
                    </div>
                    <div class="tombol-edit-wrap d-flex align-self-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="contentProposal">Hide Data</button>
                        <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="contentProposal" style="display: none;">Show Data</button>
                        @if($dataProposal->status == 'revisi')
                        <a href="{{route('proposals.edit', $dataProposal->id)}}" class="btn btn-sm btn-warning text-white">Edit Data Proposal</a>
                        @endif
                    </div>
                </div>
                <div id="contentProposal" class="content">
                    <div class="data-content mt-4">
                        <div class="alert alert-primary" role="alert">
                            {{$dataProposal->judul_proposal}}
                        </div>
                        <div class="details-data-proposal">
                            <p class="text-muted pb-4">{{$dataProposal->deskripsi_keunggulan_inovasi}}</p>
                            <div class="component-one mb-4 d-flex justify-content-between">
                                <div class="data align-self-center">
                                    <p>Skema: 
                                        @if ($dataProposal->skema == 1)
                                            Hilirisasi inovasi hasil riset untuk tujuan komersialisasi
                                        @elseif ($dataProposal->skema == 2)
                                            Hilirisasi kepakaran untuk menjawab Kebutuhan DUDI
                                        @elseif ($dataProposal->skema == 3)
                                            Pengembangan Produk inovasi bersama DUDI/Mitra Inovasi
                                        @elseif ($dataProposal->skema == 4)
                                            Peningkatan TKDN atau Produk Substitusi Impor
                                        @else
                                            Skema tidak diketahui
                                        @endif
                                    </p>
                                    <p>TKT : {{$dataProposal->tkt}} - <a href="{{ asset('storage/' .$dataProposal->bukti_tkt) }}" target="_blank">Download Bukti TKT</a></p>
                                </div>
                                <div class="data-2">
                                    <span class="badge rounded-pill bg-primary">
                                        @if ($dataProposal->tema == 1)
                                            Ekonomi Hijau
                                        @elseif ($dataProposal->tema == 2)
                                            Ekonomi Digital
                                        @elseif ($dataProposal->tema == 3)
                                            Kemandirian Kesehatan
                                        @elseif ($dataProposal->tema == 4)
                                            Ekonomi Biru
                                        @elseif ($dataProposal->tema == 5)
                                            Pengembangan Pariwisata
                                        @elseif ($dataProposal->tema == 6)
                                            Inovasi Pendidikan
                                        @elseif ($dataProposal->tema == 7)
                                            Non Tematik (Umum)
                                        @else
                                            Tema tidak diketahui
                                        @endif
                                    </span>

                                </div>
                            </div>
                            <div class="head-details-wrap d-flex justify-content-between">
                                <div class="component-1">
                                    <h6>{{$dataProposal->ketua_inovator}}</h6>
                                    <p class="text-muted">{{$dataProposal->nama_perguruan_tinggi}} - {{$dataProposal->program_studi}}</p>
                                </div>
                                <div class="component-2">
                                    <h6 class="mb-1">{{$dataProposal->nama_industri}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-content-details-proposal mt-4" style="border:none;">
                        <div class="details-data d-flex justify-content-between mt-2">
                            <div class="cp">
                                <p class="text-muted">SK Penetapan</p>
                                <h6>-</h6>
                                <p class="text-muted mt-2">Durasi Pelaksanaan</p>
                                <h6>{{$dataProposal->durasi_pelaksanaan}} Bulan</h6>
                            </div>
                            <div class="cp">
                                <p class="text-muted">Dana Hilirisasi Inovasi</p>
                                <h6>Rp. {{ number_format($dataProposal->dana_hilirisasi_inovasi, 0, ',', '.') }}</h6>
                            </div>
                            <div class="cp">
                                <p class="text-muted">Mitra Tunai</p>
                                <h6>Rp. {{ number_format($dataProposal->mitra_tunai, 0, ',', '.') }}</h6>
                            </div>
                            <div class="cp">
                                <p class="text-muted">Mitra Natuna</p>
                                <h6>Rp. {{ number_format($dataProposal->mitra_natura, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($dataProposal->status === 'sebagai pemenang')
        <!-- Kontrak -->
        <div class="card mt-4">
            <div class="card-body">
                <div class="card-title-head-custom d-flex justify-content-between">
                    <div class="judul align-self-center">
                        <h6 class="card-title align-self-center mb-0">Kontrak Pemenang</h6>
                    </div>
                    <div class="tombol-edit-wrap d-flex align-self-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="contentKontrak">Hide Data</button>
                        <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="contentKontrak" style="display: none;">Show Data</button>
                    </div>
                </div>
                <div id="contentKontrak" class="content">
                    <div class="data-content mt-4">
                        <div class="details-data-proposal">
                            <div class="draft-status-wrap">
                                <div class="draft-content">
                                    @php
                                        $pemenang = App\PemenangM::where('proposal_id', $dataProposal->id)->first();
                                        $kontrak = App\KontrakPemenang::where('proposal_id', $dataProposal->id)->first();
                                    @endphp
                                    @if(!$kontrak)
                                    <img src="{{ asset('/proposaldraft.png') }}" alt="" style="max-width : 50%;">
                                    <h3 class="mt-4">Kontrak Belum Dibuat</h3>
                                    @else
                                    <p class="text-muted"><a href="{{ $kontrak->kontrak }}">Download Kontrak</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- End Kontrak -->

        <!-- Komentar -->
        <div class="card mt-4">
            <div class="card-body">
                <div class="card-title-head-custom d-flex justify-content-between">
                    <div class="judul align-self-center">
                        <h6 class="card-title align-self-center mb-0">Komentar / Catatan</h6>
                    </div>
                    <div class="tombol-edit-wrap d-flex align-self-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="contentKomentar">Hide Data</button>
                        <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="contentKomentar" style="display: none;">Show Data</button>
                    </div>
                </div>
                <div id="contentKomentar" class="content">
                    <div class="data-content mt-4">
                        <div class="details-data-proposal">
                            <div class="draft-status-wrap">
                                <div class="draft-content">
                                    @php
                                        $revisi = App\Revisi::where('proposal_id', $dataProposal->id)->first();
                                    @endphp
                                    @if(!$revisi)
                                    <img src="{{ asset('/proposaldraft.png') }}" alt="" style="max-width : 50%;">
                                    <h3 class="mt-4">Tidak ada Komentar / Catatan</h3>
                                    @else
                                    <p class="text-muted">{{$revisi->catatan}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="card-title-head-custom d-flex justify-content-between">
                    <div class="judul align-self-center">
                        <h6 class="card-title align-self-center mb-0">Details Kolaborasi</h6>
                    </div>
                    <div class="tombol-edit-wrap d-flex align-self-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="kolaborasiData">Hide Data</button>
                        <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="kolaborasiData" style="display: none;">Show Data</button>
                    </div>
                </div>
                <div id="kolaborasiData" class="content">
                    <div class="data-content mt-4">
                        <div class="details-data-proposal">
                            <div class="kolaborasi-content">
                                <div class="header-kolaborasi">
                                    <h5>1. Latar belakang kreasi/reka</h5>
                                </div>
                                <div class="content-kolaborasi mt-4">
                                    <p class="text-muted">
                                        {{$kolaborasi->background}}
                                    </p>
                                </div>
                            </div>
                            <div class="kolaborasi-content mt-4">
                                <div class="header-kolaborasi">
                                    <h5>2. Target calon pengguna soslusi kreasi reka</h5>
                                </div>
                                <div class="content-kolaborasi mt-4">
                                    <p class="text-muted">
                                        {{$kolaborasi->target_users}}
                                    </p>
                                </div>
                            </div>
                            <div class="kolaborasi-content mt-4">
                                <div class="header-kolaborasi">
                                    <h5>3. Tolak ukur kesuksesakan implementasi kreasi reka</h5>
                                </div>
                                <div class="content-kolaborasi mt-4">
                                    <p class="text-muted">
                                        {{$kolaborasi->success_metrics}}
                                    </p>
                                </div>
                            </div>
                            <div class="kolaborasi-content mt-4">
                                <div class="header-kolaborasi">
                                    <h5>4. Kebutuhan konret implementasi kreasi reka</h5>
                                </div>
                                <div class="content-kolaborasi mt-4">
                                    <p class="text-muted">
                                        {{$kolaborasi->implementation_needs}}
                                    </p>
                                </div>
                            </div>
                            <div class="kolaborasi-content mt-4">
                                <div class="header-kolaborasi">
                                    <h5>5. Ekspektasi kerjasama</h5>
                                </div>
                                <div class="content-kolaborasi mt-4">
                                    <p class="text-muted">
                                        {{$kolaborasi->cooperation_expectation}}
                                    </p>
                                </div>
                            </div>
                            <div class="kolaborasi-content mt-4">
                                <div class="header-kolaborasi">
                                    <h5>6. Permasalahan industri yang dihadapi</h5>
                                </div>
                                <div class="content-kolaborasi mt-4">
                                    <p class="text-muted">
                                        {{$kolaborasi->industry_problems}}
                                    </p>
                                </div>
                            </div>
                            <div class="kolaborasi-content mt-4">
                                <div class="header-kolaborasi">
                                    <h5>7. Penjelasan solusi kresi reka yang diciptakan untuk kebutuhan</h5>
                                </div>
                                <div class="content-kolaborasi mt-4">
                                    <p class="text-muted">
                                        {{$kolaborasi->solution_description}}
                                    </p>
                                </div>
                            </div>
                            <div class="kolaborasi-content mt-4">
                                <div class="header-kolaborasi">
                                    <h5>8. Bentuk insentif yang diajukan kepada insan PT</h5>
                                </div>
                                <div class="content-kolaborasi mt-4">
                                    <p class="text-muted">
                                        {{$kolaborasi->proposed_incentives}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mitra Data -->
        <div class="card mt-4">
            @php
                $mitra = App\IndustryPartner::where('proposal_id',$dataProposal->id)->first();
            @endphp
            <div class="card-body">
                <div class="card-title-head-custom d-flex justify-content-between">
                    <div class="judul align-self-center">
                        <h6 class="card-title align-self-center mb-0">Data Mitra</h6>
                    </div>
                    <div class="tombol-edit-wrap d-flex align-self-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="MitraData">Hide Data</button>
                        <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="MitraData" style="display: none;">Show Data</button>
                    </div>
                </div>
                <div id="MitraData" class="content">
                    <div class="data-content mt-4">
                        <div class="details-data-mitra">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <h6>Nama Mitra</h6>
                                    <p class="text-muted">{{$mitra->name}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6>Bidang Usaha </h6>
                                    <p class="text-muted">{{$mitra->business_focus}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6>Skala Usaha </h6>
                                    <p class="text-muted">{{$mitra->business_scale}}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <h6>Alamat</h6>
                                    <p class="text-muted">{{$mitra->address}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6>Email</h6>
                                    <p class="text-muted">{{$mitra->email }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6>Nomor Telepon</h6>
                                    <p class="text-muted">{{$mitra->phone}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Komposisi Team Card -->
        <div class="card mt-4">
            <div class="card-body">
                <div class="card-title-head-custom d-flex justify-content-between">
                    <div class="judul align-self-center">
                        <h6 class="card-title align-self-center mb-0">Komposisi Team</h6>
                    </div>
                    <div class="tombol-edit-wrap d-flex align-self-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="contentTeam">Hide Data</button>
                        <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="contentTeam" style="display: none;">Show Data</button>
                    </div>
                </div>
                <div id="contentTeam" class="content">
                    <div class="data-content mt-4">
                        <div class="details-data-proposal">
                            <!-- Dosen Peneliti -->
                            @foreach($dataTeam as $datateam)
                            <div class="team-content-wrap">
                                <div class="title-team">
                                    <h6>{{$datateam->member_type}}</h6>
                                </div>
                                
                                <div class="item-team p-4 mt-3">
                                    <div class="body-item-team">
                                        <h6 class="mb-2">{{$datateam->name}}</h6>
                                        <p class="text-muted">
                                            {{$datateam->identifier}}
                                        </p>
                                        <p class="text-muted">{{$datateam->faculty_kamda}}</p>
                                        <p class="text-muted"> Status Keaktifan : <span>{{$datateam->active_status}}</span></p>
                                        <p class="text-muted"> Jumlah Keanggotaan : <span>0</span></p>
                                        @php 
                                            $funding = App\FundingHistory::where('team_composition_id',$datateam->id)->get();
                                        @endphp
                                        @if($datateam->member_type === 'Dosen')
                                        <p class="text-muted mt-4 mb-2"><i>Riwayat Pendanaan Matching Fund Hilirisasi Inovasi UPI</i></p>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Proposal</th>
                                                        <th>Tahun</th>
                                                        <th>Nama</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($funding as $datafunding)
                                                        @if(!is_null($datafunding->proposal_title) && !is_null($datafunding->year) && !is_null($datafunding->name) && !is_null($datafunding->status))
                                                        <tr>
                                                            <td>{{$datafunding->proposal_title}}</td>
                                                            <td>{{$datafunding->year}}</td>
                                                            <td>{{$datafunding->name}}</td>
                                                            <td>{{$datafunding->status}}</td>
                                                        </tr>
                                                        @endif
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </div>
                                        @else
                                        <p class="text-muted mt-4 mb-2"><i>Tidak ada riwayat pendanaan!</i></p>
                                        @endif 
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- End Dosen Peneliti -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Berkas Proposal Card -->
        <div class="card mt-4">
            <div class="card-body">
                <div class="card-title-head-custom d-flex justify-content-between">
                    <div class="judul align-self-center">
                        <h6 class="card-title align-self-center mb-0">Berkas Administrasi</h6>
                    </div>
                    <div class="tombol-edit-wrap d-flex align-self-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="contentFiles">Hide Data</button>
                        <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="contentFiles" style="display: none;">Show Data</button>
                    </div>
                </div>
                <div id="contentFiles" class="content">
                    <div class="data-content mt-4">
                        <div class="details-data-proposal">
                            @php
                                $document = App\AdminDocument::where('proposal_id',$dataProposal->id)->first();
                            @endphp
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="{{ asset('storage/' .$document->proposal_file) }}" target="_blank" class="d-flex">
                                                    <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                    <p class="align-self-center text-dark">Proposal usulan</p>
                                                </a>
                                            </div>
                                            <div class="docs-title align-self-center text-center">
                                                <a href="{{ asset('storage/' .$document->proposal_file) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="{{ asset('storage/' .$document->partner_commitment_letter) }}" target="_blank" class="d-flex">
                                                    <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                    <p class="align-self-center text-dark">Surat Pernyataan Komitmen Mitra</p>
                                                </a>
                                            </div>
                                            <div class="docs-title align-self-center text-center">
                                                <a href="{{ asset('storage/' .$document->partner_commitment_letter) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="{{ asset('storage/' .$document->funding_commitment_letter) }}" target="_blank" class="d-flex">
                                                    <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                    <p class="align-self-center text-dark">Pernyataan Komitmen Dana Mitra</p>
                                                </a>
                                            </div>
                                            <div class="docs-title align-self-center text-center">
                                                <a href="{{ asset('storage/' .$document->funding_commitment_letter) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="{{ asset('storage/' .$document->study_commitment_letter) }}" target="_blank" class="d-flex">
                                                    <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                    <p class="align-self-center text-dark">Surat Pernyataan Tidak Sedang Studi Lanjut dan Tidak Berafiliasi dengan Mitra (Ketua dan Anggota Wajib)</p>
                                                </a>
                                            </div>
                                            <div class="docs-title align-self-center text-center">
                                                <a href="{{ asset('storage/' .$document->study_commitment_letter) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="{{ asset('storage/' .$document->applicant_bio_form) }}" target="_blank" class="d-flex">
                                                    <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                    <p class="align-self-center text-dark">Formulir Biodata Pengusul (Ketua dan Anggota)</p>
                                                </a>
                                            </div>
                                            <div class="docs-title align-self-center text-center">
                                                <a href="{{ asset('storage/' .$document->applicant_bio_form) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="{{ asset('storage/' .$document->partner_profile_form) }}" target="_blank" class="d-flex">
                                                    <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                    <p class="align-self-center text-dark">Formulir Profil Mitra</p>
                                                </a>
                                            </div>
                                            <div class="docs-title align-self-center text-center">
                                                <a href="{{ asset('storage/' .$document->partner_profile_form) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="{{ asset('storage/' .$document->cooperation_agreement) }}" target="_blank" class="d-flex">
                                                    <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;">
                                                    <p class="align-self-center text-dark">Surat Pernyataan Kesepakatan Pengusul dan Mitra Melakukan Kerja Sama</p>
                                                </a>
                                            </div>  
                                            <div class="docs-title align-self-center text-center">
                                                <a href="{{ asset('storage/' .$document->cooperation_agreement) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="{{ asset('storage/' .$document->hki_agreement) }}" target="_blank" class="d-flex">
                                                    <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                    <p class="align-self-center text-dark">Perjanjian HKI dengan Mitra</p>
                                                </a>
                                            </div>
                                            <div class="docs-title align-self-center text-center">
                                                <a href="{{ asset('storage/' .$document->hki_agreement) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between">
                                            <div class="file-data me-2">
                                                <a href="javascript:void(0)" onclick="previewExcel('{{ asset('storage/' . $document->budget_plan_file) }}')" class="d-flex">
                                                    <img src="{{ asset('/exceldocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                    <p class="align-self-center text-dark">Rencana Anggaran Biaya berupa file excel.</p>
                                                </a>
                                            </div>
                                            <div class="button align-self-center">
                                                <a href="javascript:void(0)" onclick="previewExcel('{{ asset('storage/' . $document->budget_plan_file) }}')" class="text-dark"><i class="" data-feather="eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="excelPreviewModal" tabindex="-1" aria-labelledby="excelPreviewModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="excelPreviewModalLabel">Preview Rencana Anggaran Biaya</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Container where Excel content will be rendered -->
                                            <div id="excel-preview-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title-head-custom d-flex justify-content-between mb-4">
                    <div class="judul align-self-center">
                        <h6 class="card-title align-self-center mb-0">Timeline </h6>
                    </div>
                    <div class="tombol-edit-wrap d-flex align-self-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="contentTimeline">Hide Timeline</button>
                        <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="contentTimeline" style="display: none;">Show Timeline</button>
                    </div>
                </div>
                @php 
                    $timeline = App\Timeline::where('proposal_id',$dataProposal->id)->first();
                @endphp
                <div id="contentTimeline">
                    <ul class="timeline">
                        <li class="{{ $timeline->proposal_upload === '1' ? 'success completed' : 'danger incompleted' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Upload Proposal</p>
                        </li>
                        <li class="{{ $timeline->administrasi === '1' ? 'success completed' : 'danger incompleted' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Administrasi</p>
                        </li>
                        <li class="{{ $timeline->substansi === '1' ? 'success completed' : 'danger incompleted' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Seleksi Subtansi</p>
                        </li>
                        <li class="{{ $timeline->revisi === '1' ? 'warning incompleted' : 'danger incompleted' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Revisi</p>
                        </li>
                        <li class="{{ $timeline->revisi_upload === '0' ? 'danger incompleted' : 'success completed' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Upload Revisi</p>
                        </li>
                        <li class="{{ $timeline->revisi_upload === '1' ? 'warning incompleted' : 'danger incompleted' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Verifikasi Proposal Revisi</p>
                        </li>
                        <li class="{{ $timeline->penetapan_pemenang === '1' ? 'success completed' : 'danger incompleted' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Penetapan Pemenang</p>
                        </li>
                        <li class="{{ $timeline->kontrak === '1' ? 'success completed' : 'danger incompleted' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Kontrak</p>
                        </li>
                        <li class="{{ $timeline->pelaksanaan === '1' ? 'success completed' : 'danger incompleted' }}">
                            <small class="text-muted">{{$dataProposal->created_at}}</small>
                            <p class="action">Pelaksanaan</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@else 
<div class="notfound">
    <img src="{{ asset('/proposalnotfound.png') }}" alt="" style="max-width :45%; margin: 0 auto;">
    <h5 class="text-muted">Anda belum mengajukan Proposal, Silahkan ajukan terlebih dahulu !</h5 class="text-muted">
    <a href="{{url('proposals')}}" class="btn btn-sm btn-primary mt-2">Ajukan Proposal</a>
</div>

@endif
@endif
<!-- End User Area -->

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script>
    function previewExcel(fileUrl) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", fileUrl, true);
        xhr.responseType = "arraybuffer";
        xhr.onload = function () {
            var data = new Uint8Array(xhr.response);
            var workbook = XLSX.read(data, { type: "array" });
            var sheetName = workbook.SheetNames[0]; // Get the first sheet
            var sheet = workbook.Sheets[sheetName];
            var htmlTable = XLSX.utils.sheet_to_html(sheet);
            document.getElementById("excelTable").innerHTML = htmlTable;
            document.getElementById("excelPreview").style.display = "block";
        };
        xhr.send();
    }
</script>
    
    <script>
        document.querySelectorAll('.minimizeButton').forEach(button => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-target');
                document.getElementById(target).style.display = 'none'; // Hide content
                button.style.display = 'none'; // Hide minimize button
                button.nextElementSibling.style.display = 'inline'; // Show maximize button
            });
        });

        document.querySelectorAll('.maximizeButton').forEach(button => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-target');
                document.getElementById(target).style.display = 'block'; // Show content
                button.style.display = 'none'; // Hide maximize button
                button.previousElementSibling.style.display = 'inline'; // Show minimize button
            });
        });
    </script>
    <style>
        .limited-text {
            max-width: 300px; /* Set the maximum width as needed */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notfound {
            text-align:center;
        }

        .timeline {
            border-left: none!important;
            border-bottom-right-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            background: none!important;
            margin: 0px 20px;
            position: relative;
            padding: 0px;
            list-style: none;
            max-width: 100%;
        }

        li {
            list-style: none;
        }

        .timeline li {
            position: relative;
            padding-bottom: 32px;
            padding-left: 32px;
        }
        .timeline li:before {
            content: "";
            position: absolute;
            display: block;
            top: 1.7rem;
            left: 0;
            width: 8px;
            height: 8px;
            background-color: #fff;
            border-radius: 100%;
        }
        .timeline li:not([class]):before {
            box-shadow: inset 0px 0px 0px 2px #cccccc;
        }
        .timeline li:after {
            content: "";
            position: absolute;
            display: block;
            top: calc(1.7rem + 12px);
            left: 3px;
            bottom: -1.5rem;
            width: 2px;
            background-color: #cccccc;
        }

        .timeline li:last-child:before {
            top: 1.825rem;
        }
        .timeline li:last-child:after {
            content: none;
        }
        .timeline li.success:before {
            background-color: #048b3f;
        }
        .timeline li.success:not(.incompleted):after {
            background-color: #048b3f;
        }
        .timeline li.warning:before {
            background-color: #f2a51a;
        }
        .timeline li.warning:not(.incompleted):after {
            background-color: #739e41;
        }
        .timeline li.danger:before {
            background-color: #cc2952;
        }

        .footer-content-details-proposal {
            border-top : 2px solid #eee;
        }

        .docs-title p {
            font-size : 12px;
            color : #555;
            margin-top : 10px;
        }

        p.action {
            font-weight:500;
            font-size:14px;
        }

        .file-data img {
            width: 30px;
        }
        /* Excel Table Preview Styles */
        .excel-table-container {
            max-height: 500px; /* Adjust as needed */
            overflow-y: auto; /* Scrollable if the table exceeds the max height */
            padding: 10px;
        }

        .excel-table-container table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        .excel-table-container table, .excel-table-container th, .excel-table-container td {
            border: 1px solid #ddd;
        }

        .excel-table-container th, .excel-table-container td {
            padding: 8px;
            text-align: left;
        }

        .excel-table-container th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .excel-table-container td {
            background-color: #fff;
        }

        .excel-table-container table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .excel-table-container table tr:hover {
            background-color: #f1f1f1;
        }
        .content-kolaborasi {
            padding: 20px;
            border : 1px dashed#aaa;
            border-radius : 20px;
        }
        .draft-content img {
            width: 100px;
        }

        .draft-content {
            padding: 50px;
            border: 2px dashed #aaa;
            border-radius: 30px;
            text-align: center;
        }

        .alert-banner {
            display: flex;
            align-items: center;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            position: relative;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .alert-icon {
            font-size: 20px;
            margin-right: 15px;
        }

        .alert-content h4 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .alert-content p {
            margin: 5px 0 10px;
            font-size: 14px;
        }

        .alert-content a {
            font-size: 14px;
            color: inherit;
            text-decoration: underline;
            cursor: pointer;
        }

        .alert-close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: inherit;
        }

        .alert-banner.success {
            background-color: #dff2d8;
            color: #2d662b;
        }

        .alert-banner.info {
            background-color: #d9f2fa;
            color: #2a6476;
        }

        .alert-banner.warning {
            background-color: #fff6da;
            color: #7d591d;
        }

        .alert-banner.error {
            background-color: #f8d7da;
            color: #842029;
        }

    </style>
    <script>
        function previewExcel(fileUrl) {
            var previewContainer = document.getElementById('excel-preview-container');
            
            if (!previewContainer) {
                console.error('Elemen preview container tidak ditemukan!');
                return; // Stop the function if the container is not found
            }

            previewContainer.innerHTML = ""; // Clear previous content
            
            // Fetch the file (XHR request)
            fetch(fileUrl)
                .then(response => response.arrayBuffer())
                .then(data => {
                    // Use SheetJS to read the file
                    var workbook = XLSX.read(data, { type: 'array' });

                    // Create a HTML table from the first sheet
                    var sheetName = workbook.SheetNames[0];
                    var worksheet = workbook.Sheets[sheetName];
                    var html = XLSX.utils.sheet_to_html(worksheet);

                    // Add custom class for better styling
                    previewContainer.innerHTML = `<div class="excel-table-container">${html}</div>`;

                    // Optional: If you want to do more manipulations or adjustments on the HTML
                    // You can add additional code here
                })
                .catch(error => {
                    previewContainer.innerHTML = "<p class='text-danger'>Failed to load the file. Please try again.</p>";
                    console.error(error);
                });

            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('excelPreviewModal'), {
                keyboard: false
            });
            myModal.show();
        }
    </script>
@endpush