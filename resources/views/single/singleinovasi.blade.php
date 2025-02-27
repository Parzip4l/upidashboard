@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Proposal</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$data->judul_proposal}}</li>
  </ol>
</nav>
@php 
    $user = App\User::where('id',$data->user_id)->first();
@endphp
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!-- Custom Nav Single -->
<div class="row">
    <div class="col-md-12">
        <div class="nav-custom-wrap d-flex mb-3">
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary active" data-content="konsep">Konsep</a>
            </div>
            @if(Auth::user()->role == 'admin' && $data->status === 'submited')
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="adm">Cek Administrasi</a>
            </div>
            @endif
            @if(Auth::user()->role == 'reviewer' && $data->status === 'review')
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="nilai">Penilaian</a>
            </div>
            @endif
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="pra-kontrak">Pra Kontrak</a>
            </div>
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="pelaksanaan">Pelaksanaan</a>
            </div>
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="monitoring">Monitoring Internal</a>
            </div>
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="timeline">Log Aktivitas</a>
            </div>
            <input type="hidden" class="idProposal" id="IDProposal" value="{{$data->id}}">
        </div>
    </div>
</div>
<!-- End Custom Nav -->
<div id="konsep" class="content-section active">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title-head-custom d-flex justify-content-between">
                        <div class="judul align-self-center">
                            <h6 class="card-title align-self-center mb-0">Proposal Data </h6>
                            <span class="badge 
                                @if($data->status == 'ditolak') bg-danger
                                @elseif($data->status == 'review') bg-warning
                                @elseif($data->status == 'revisi') bg-warning
                                @elseif($data->status == 'disetujui') bg-success
                                @else bg-secondary
                                @endif">
                                {{$data->status}}
                            </span>
                        </div>
                    
                        <div class="d-flex justify-content-between align-self-center">
                            <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="contentProposal">Hide Data</button>
                            <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="contentProposal" style="display: none;">Show Data</button>
                            @if($previousProposal)
                                <a href="{{ route('hilirasasi-inovasi.show', $previousProposal->id) }}" class="btn btn-sm btn-secondary me-2">
                                    Previous Proposal
                                </a>
                            @endif

                            @if($nextProposal)
                                <a href="{{ route('hilirasasi-inovasi.show', $nextProposal->id) }}" class="btn btn-sm btn-primary ml-auto">
                                    Next Proposal
                                </a>
                            @endif
                            
                        </div>
                    </div>
                    <div id="contentProposal">
                        <div class="data-content mt-4">
                            <!-- title Proposal -->
                            <div class="alert alert-primary" role="alert">
                                {{$data->judul_proposal}}
                            </div>
                            <div class="details-data-proposal">
                                <p class="text-muted pb-4">{{$data->deskripsi_keunggulan_inovasi}}</p>
                                <div class="component-one mb-4 d-flex justify-content-between">
                                    <div class="data align-self-center">
                                        <p>Skema: 
                                            @if ($data->skema == 1)
                                                Hilirisasi inovasi hasil riset untuk tujuan komersialisasi
                                            @elseif ($data->skema == 2)
                                                Hilirisasi kepakaran untuk menjawab Kebutuhan DUDI
                                            @elseif ($data->skema == 3)
                                                Pengembangan Produk inovasi bersama DUDI/Mitra Inovasi
                                            @elseif ($data->skema == 4)
                                                Peningkatan TKDN atau Produk Substitusi Impor
                                            @else
                                                Skema tidak diketahui
                                            @endif
                                        </p>
                                        <p>TKT : {{$data->tkt}}</p>
                                    </div>
                                    <div class="data-2">
                                        <span class="badge rounded-pill bg-primary">
                                            @if ($data->tema == 1)
                                                Ekonomi Hijau
                                            @elseif ($data->tema == 2)
                                                Ekonomi Digital
                                            @elseif ($data->tema == 3)
                                                Kemandirian Kesehatan
                                            @elseif ($data->tema == 4)
                                                Ekonomi Biru
                                            @elseif ($data->tema == 5)
                                                Pengembangan Pariwisata
                                            @elseif ($data->tema == 6)
                                                Inovasi Pendidikan
                                            @elseif ($data->tema == 7)
                                                Non Tematik (Umum)
                                            @else
                                                Tema tidak diketahui
                                            @endif
                                        </span>

                                    </div>
                                    
                                </div>
                                @if(Auth::user()->role == 'admin')
                                <div class="head-details-wrap d-flex justify-content-between">
                                    <div class="component-1">
                                        <h6>{{$data->ketua_inovator}}</h6>
                                        <p class="text-muted">{{$data->nama_perguruan_tinggi}} - {{$data->program_studi}}</p>
                                    </div>
                                    <div class="component-2">
                                        <h6 class="mb-1">{{$data->nama_industri}}</h6>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Skema Pendanaan -->
                        <div class="footer-content-details-proposal mt-4" style="border:none;">
                            <div class="details-data d-flex justify-content-between mt-2">
                                <div class="cp">
                                    <p class="text-muted">SK Penetapan</p>
                                    <h6>-</h6>
                                    <p class="text-muted mt-2">Durasi Pelaksanaan</p>
                                    <h6>{{$data->durasi_pelaksanaan}} Bulan</h6>
                                </div>
                                <div class="cp">
                                    <p class="text-muted">Dana Hilirisasi Inovasi</p>
                                    <h6>Rp. {{ number_format($data->dana_hilirisasi_inovasi, 0, ',', '.') }}</h6>
                                </div>
                                <div class="cp">
                                    <p class="text-muted">Mitra Tunai</p>
                                    <h6>Rp. {{ number_format($data->mitra_tunai, 0, ',', '.') }}</h6>
                                </div>
                                <div class="cp">
                                    <p class="text-muted">Mitra Natuna</p>
                                    <h6>Rp. {{ number_format($data->mitra_natura, 0, ',', '.') }}</h6>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Assign Reviewer -->
                         <hr>
                         <h5>Reviewer Proposal</h5>
                         <div class="reviewer-wrap mt-3">
                            <form action="{{route('reviewer.set')}}" id="reviewer-assign" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" name="id_proposal" value="{{$data->id}}">
                                            <label for="reviewer1">Reviewer 1</label>
                                            <select name="reviewer1" id="reviewer1" class="form-control">
                                                <option value="">-- Select Reviewer --</option>
                                                @foreach($datareviewer as $reviewer)
                                                    <option value="{{ $reviewer->id }}" 
                                                        {{ isset($existingReviewer) && $existingReviewer->reviewer1 == $reviewer->id ? 'selected' : '' }}>
                                                        {{ $reviewer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reviewer1">Reviewer 2</label>
                                            <select name="reviewer2" id="reviewer2" class="form-control">
                                                <option value="">-- Select Reviewer --</option>
                                                @foreach($datareviewer as $reviewer)
                                                    <option value="{{ $reviewer->id }}" 
                                                        {{ isset($existingReviewer) && $existingReviewer->reviewer2 == $reviewer->id ? 'selected' : '' }}>
                                                        {{ $reviewer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-small {{ isset($existingReviewer) ? 'btn-warning' : 'btn-primary' }} mt-2" type="submit">
                                    {{ isset($existingReviewer) ? 'Update Data' : 'Submit Data' }}
                                </button>
                                
                            </form>
                         </div>

                    </div>
                </div>
            </div>

            <!-- Kolaborasi -->
            @if(Auth::user()->role == 'admin')
            <div class="card mt-4">
                <div class="card-body">
                    <div class="card-title-head-custom d-flex justify-content-between">
                        <div class="judul align-self-center">
                            <h6 class="card-title align-self-center mb-0">Detail Kolaborasi</h6>
                        </div>
                        <div class="tombol-edit-wrap d-flex align-self-center">
                            <button class="btn btn-sm btn-outline-secondary me-2 minimizeButton" data-target="kolaborasiData">Hide Data</button>
                            <button class="btn btn-sm btn-outline-secondary me-2 maximizeButton" data-target="kolaborasiData" style="display: none;">Show Data</button>
                        </div>
                    </div>
                    @php    
                        $kolaborasi = App\Collaboration::where('proposal_id',$data->id)->first();
                        $timeline = App\Timeline::where('proposal_id',$data->id)->first();
                    @endphp
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
            @endif

            <!-- Mitra -->
            @if(Auth::user()->role == 'admin')
            <div class="card mt-4">
                @php
                    $mitra = App\IndustryPartner::where('proposal_id',$data->id)->first();
                    $dataTeam = App\TeamComposition::where('proposal_id',$data->id)->get();
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
                                <div class="team-content-wrap mb-4">
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
            @endif

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
                                    $document = App\AdminDocument::where('proposal_id',$data->id)->first();
                                @endphp
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="card">
                                            <div class="card-body d-flex justify-content-between">
                                                <div class="file-data me-2">
                                                    <a href="{{ asset('storage/' .$document->roadmap) }}" target="_blank" class="d-flex">
                                                        <img src="{{ asset('/pdfdocs.png') }}" alt="" style="max-width :100%;" class="me-2">
                                                        <p class="align-self-center text-dark">Roadmap Proposal</p>
                                                    </a>
                                                </div>
                                                <div class="docs-title align-self-center text-center">
                                                    <a href="{{ asset('storage/' .$document->roadmap) }}" target="_blank" class="text-dark"><i class="" data-feather="eye"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    @if(Auth::user()->role == 'admin')
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
                                    @endif
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
        @if(Auth::user()->role == 'admin')
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
                    <div id="contentTimeline">
                        <ul class="timeline">
                            <li class="{{ $timeline->proposal_upload === '1' ? 'success completed' : 'danger incompleted' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Upload Proposal</p>
                            </li>
                            <li class="{{ $timeline->administrasi === '1' ? 'success completed' : 'danger incompleted' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Administrasi</p>
                            </li>
                            <li class="{{ $timeline->substansi === '1' ? 'success completed' : 'danger incompleted' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Seleksi Subtansi</p>
                            </li>
                            <li class="{{ $timeline->revisi === '1' ? 'warning incompleted' : 'danger incompleted' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Revisi</p>
                            </li>
                            <li class="{{ $timeline->revisi_upload === '0' ? 'danger incompleted' : 'success completed' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Upload Revisi</p>
                            </li>
                            <li class="{{ $timeline->revisi_upload === '1' ? 'warning incompleted' : 'danger incompleted' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Verifikasi Proposal Revisi</p>
                            </li>
                            <li class="{{ $timeline->penetapan_pemenang === '1' ? 'success completed' : 'danger incompleted' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Penetapan Pemenang</p>
                            </li>
                            <li class="{{ $timeline->kontrak === '1' ? 'success completed' : 'danger incompleted' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Kontrak</p>
                            </li>
                            <li class="{{ $timeline->pelaksanaan === '1' ? 'success completed' : 'danger incompleted' }}">
                                <small class="text-muted">{{$data->created_at}}</small>
                                <p class="action">Pelaksanaan</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div id="nilai" class="content-section" style="display: none;">
    <div class="card">
        <div class="card-body">
            <div class="nilai-wrap">
                <div class="nilai-content">
                    @if (!$nilai)
                    <form id="rubrikForm" action="{{route('proposal.nilaidata')}}" method="POST" onsubmit="return confirmSubmission(event)">
                        @csrf
                        <div class="table-responsive">
                            <input type="hidden" name="id_proposal" value="{{$data->id}}">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Aspek Penilaian</th>
                                        <th>Indikator</th>
                                        <th>Bobot (%)</th>
                                        <th>Skor (1-4)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="3">Kualitas Proposal</td>
                                        <td>Kejelasan Tujuan dan Sasaran</td>
                                        <td>10%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="tujuan_sasaran" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Tujuan dan sasaran kurang jelas, tidak relevan</small><br>
                                                <small>2: Tujuan dan sasaran kurang jelas</small><br>
                                                <small>3: Tujuan dan sasaran cukup jelas, relevan</small><br>
                                                <small>4: Tujuan dan sasaran sangat jelas, relevan</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kejelasan Metodologi</td>
                                        <td>5%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="metodologi" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Metodologi tidak jelas dan tidak sesuai tujuan</small><br>
                                                <small>2: Metodologi cukup jelas namun kurang sesuai</small><br>
                                                <small>3: Metodologi jelas dan sesuai tujuan</small><br>
                                                <small>4: Metodologi sangat jelas dan sesuai tujuan</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kejelasan Jadwal dan Tahapan Kegiatan</td>
                                        <td>5%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="jadwal_tahapan" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Jadwal dan tahapan kurang jelas</small><br>
                                                <small>2: Jadwal dan tahapan cukup jelas namun tidak terperinci</small><br>
                                                <small>3: Jadwal dan tahapan cukup terperinci</small><br>
                                                <small>4: Jadwal dan tahapan sangat jelas dan terperinci</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Inovasi dan Keberlanjutan</td>
                                        <td>Kebaruan Inovasi</td>
                                        <td>15%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="inovasi" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Inovasi tidak baru dan tidak memiliki potensi</small><br>
                                                <small>2: Inovasi kurang baru dan kurang memiliki potensi</small><br>
                                                <small>3: Inovasi cukup baru dan berpotensi</small><br>
                                                <small>4: Inovasi sangat baru dan sangat berpotensi</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Potensi Keberlanjutan Program</td>
                                        <td>15%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="keberlanjutan_program" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Program tidak berkelanjutan dan tidak dapat diterapkan dalam jangka panjang</small><br>
                                                <small>2: Program cukup berkelanjutan namun hanya untuk jangka pendek</small><br>
                                                <small>3: Program cukup berkelanjutan dan dapat diterapkan jangka menengah</small><br>
                                                <small>4: Program sangat berkelanjutan dan dapat diterapkan jangka panjang</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Potensi Dampak Program</td>
                                        <td>Potensi Dampak Sosial dan/atau Ekonomi</td>
                                        <td>15%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="keberlanjutan" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Dampak sosial dan/atau ekonomi tidak signifikan dan negatif.</small><br>
                                                <small>2: Dampak sosial dan/atau ekonomi cukup signifikan namun kurang positif. </small><br>
                                                <small>3: Dampak sosial dan/atau ekonomi signifikan dan cukup positif.</small><br>
                                                <small>4: Dampak sosial dan/atau ekonomi sangat signifikan dan positif</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Potensi Dampak terhadap Capaian IKU</td>
                                        <td>15%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="dampak_sosial_ekonomi" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Dampak terhadap capaian IKU tidak signifikan dan negatif.</small><br>
                                                <small>2: Dampak terhadap capaian IKU cukup signifikan namun kurang </small><br>
                                                <small>3: Dampak terhadap capaian IKU signifikan dan cukup positif.<br>                                                </small><br>
                                                <small>4: Dampak terhadap capaian IKU sangat signifikan dan positif.</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Kelayakan Implementasi</td>
                                        <td>Kelayakan Implementasi</td>
                                        <td>10%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="implementasi" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Implementasi tidak layak dan tidak realistis</small><br>
                                                <small>2: Implementasi kurang layak dan realistis</small><br>
                                                <small>3: Implementasi cukup layak dan realistis</small><br>
                                                <small>4: Implementasi sangat layak dan realistis</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sumber Daya Manusia</td>
                                        <td>5%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="sdm" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Sumber daya manusia yang terlibat kurang memadai dengan kompetensi yang kurang relevan</small><br>
                                                <small>2: Sumber daya manusia yang terlibat memadai; di antara tim pengusul memiliki kompetensi yang cukup relevan.                                                </small><br>
                                                <small>3: Sumber daya manusia yang terlibat memadai; di antara tim pengusul memiliki kompetensi yang relevan.</small><br>
                                                <small>4: Sumber daya manusia yang terlibat sangat memadai; ketua pengusul dan anggota memiliki kompetensi yang relevan.                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rencana Anggaran</td>
                                        <td>Kesesuaian Anggaran</td>
                                        <td>5%</td>
                                        <td>
                                            <input 
                                                type="number"
                                                class="form-control mb-2" 
                                                name="anggaran" 
                                                min="1" 
                                                max="4" 
                                                required 
                                                oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;"
                                            >
                                            <div>
                                                <small>1: Anggaran tidak sesuai dan tidak terperinci.</small><br>
                                                <small>2: Anggaran cukup sesuai namun kurang terperinci.</small><br>
                                                <small>3: Anggaran cukup sesuai dan terperinci.</small><br>
                                                <small>4: Anggaran sangat sesuai dengan SBU, rasional, dan terperinci.</small>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <br>
                        <button type="submit" class="btn btn-success btn-sm">Submit Penilaian</button>
                    </form>
                    @else
                    <p class="text-success">Anda sudah memberikan penilaian untuk proposal ini.</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Aspek Penilaian</th>
                                    <th>Bobot (%)</th>
                                    <th>Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kejelasan Tujuan dan Sasaran</td>
                                    <td>10%</td>
                                    <td>{{ $nilai->tujuan_sasaran }}</td>
                                </tr>
                                <tr>
                                    <td>Kejelasan Metodologi</td>
                                    <td>5%</td>
                                    <td>{{ $nilai->metodologi }}</td>
                                </tr>
                                <tr>
                                    <td>Kejelasan Jadwal dan Tahapan Kegiatan</td>
                                    <td>5%</td>
                                    <td>{{ $nilai->jadwal_tahapan }}</td>
                                </tr>
                                <tr>
                                    <td>Kebaruan Inovasi</td>
                                    <td>15%</td>
                                    <td>{{ $nilai->inovasi }}</td>
                                </tr>
                                <tr>
                                    <td>Potensi Keberlanjutan Program</td>
                                    <td>15%</td>
                                    <td>{{ $nilai->keberlanjutan_program }}</td>
                                </tr>
                                <tr>
                                    <td>Potensi Dampak Sosial dan/atau Ekonomi</td>
                                    <td>15%</td>
                                    <td>{{ $nilai->dampak_sosial_ekonomi }}</td>
                                </tr>
                                <tr>
                                    <td>Potensi Dampak terhadap Capaian IKU</td>
                                    <td>15%</td>
                                    <td>{{ $nilai->dampak_sosial_ekonomi }}</td>
                                </tr>
                                <tr>
                                    <td>Kelayakan Implementasi</td>
                                    <td>10%</td>
                                    <td>{{ $nilai->implementasi }}</td>
                                </tr>
                                <tr>
                                    <td>Sumber Daya Manusia</td>
                                    <td>5%</td>
                                    <td>{{ $nilai->sdm }}</td>
                                </tr>
                                <tr>
                                    <td>Kesesuaian Anggaran</td>
                                    <td>5%</td>
                                    <td>{{ $nilai->anggaran }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total Nilai</th>
                                    <th>{{ $nilai->nilai_total }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="pra-kontrak" class="content-section" style="display: none;">
    <div class="card">
        <div class="card-body">
            <div class="draft-status-wrap">
                <div class="draft-content">
                    <img src="{{ asset('/proposaldraft.png') }}" alt="" style="max-width : 50%;">
                    <h3 class="mt-4">Data Tidak Tersedia</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="pelaksanaan" class="content-section" style="display: none;">
    <div class="card">
        <div class="card-body">
            <div class="draft-status-wrap">
                <div class="draft-content">
                    <img src="{{ asset('/proposaldraft.png') }}" alt="" style="max-width : 50%;">
                    <h3 class="mt-4">Data Tidak Tersedia</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="adm" class="content-section" style="display: none;">
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
                            $document = App\AdminDocument::where('proposal_id',$data->id)->first();
                        @endphp
                        <div class="row">
                            @php
                                $documents = [
                                    [
                                        'file' => $document->roadmap,
                                        'label' => 'Roadmap Proposal',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $data->bukti_tkt,
                                        'label' => 'Bukti TKT',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->proposal_file,
                                        'label' => 'Proposal usulan',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->partner_commitment_letter,
                                        'label' => 'Surat Pernyataan Komitmen Mitra',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->funding_commitment_letter,
                                        'label' => 'Pernyataan Komitmen Dana Mitra',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->study_commitment_letter,
                                        'label' => 'Surat Pernyataan Tidak Sedang Studi Lanjut dan Tidak Berafiliasi dengan Mitra (Ketua dan Anggota Wajib)',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->applicant_bio_form,
                                        'label' => 'Formulir Biodata Pengusul (Ketua dan Anggota)',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->partner_profile_form,
                                        'label' => 'Formulir Profil Mitra',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->cooperation_agreement,
                                        'label' => 'Surat Pernyataan Kesepakatan Pengusul dan Mitra Melakukan Kerja Sama',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->hki_agreement,
                                        'label' => 'Perjanjian HKI dengan Mitra',
                                        'icon' => '/pdfdocs.png',
                                    ],
                                    [
                                        'file' => $document->budget_plan_file,
                                        'label' => 'Rencana Anggaran Biaya berupa file excel.',
                                        'icon' => '/exceldocs.png',
                                    ],
                                ];
                            @endphp

                            @foreach ($documents as $doc)
                            <div class="col-md-12 mb-3">
                                <div class="card card-doc">
                                    <div class="card-body d-flex justify-content-between">
                                        <div class="file-data d-flex align-items-center">
                                            <div class="form-check me-2">
                                                <input class="form-check-input lengkapdata-checkbox" type="checkbox" id="checkbox-{{ $loop->index }}">
                                            </div>
                                            <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank" class="d-flex">
                                                <img src="{{ asset($doc['icon']) }}" alt="" style="max-width: 100%;" class="me-2">
                                                <p class="align-self-center text-dark">{{ $doc['label'] }}</p>
                                            </a>
                                        </div>
                                        <div class="docs-title align-self-center text-center">
                                            <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank" class="text-dark">
                                                <i class="" data-feather="eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <button id="btn-continue" class="btn btn-primary" disabled>Lanjutkan Proses</button>
                            <button id="btn-reject" class="btn btn-danger">Tolak Proposal</button>
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

<div id="monitoring" class="content-section" style="display: none;">
    <div class="card">
        <div class="card-body">
            <div class="draft-status-wrap">
                <div class="draft-content">
                    <img src="{{ asset('/proposaldraft.png') }}" alt="" style="max-width : 50%;">
                    <h3 class="mt-4">Data Tidak Tersedia</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="timeline" class="content-section" style="display: none;">
    <div class="card">
        <div class="card-body">
            <div class="draft-status-wrap">
                <div class="draft-content">
                    @if(!$logs)
                    <img src="{{ asset('/proposaldraft.png') }}" alt="" style="max-width : 50%;">
                    <h3 class="mt-4">Data Tidak Tersedia</h3>
                    @else 
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $no = 1;
                                @endphp
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{ $log->user->name }}</td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugin-scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
@push('custom-scripts')
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.nav-item-custom a');
        const contentSections = document.querySelectorAll('.content-section');

        navItems.forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();

                // Remove 'active' class from all nav items and hide all content sections
                navItems.forEach(nav => nav.classList.remove('active'));
                contentSections.forEach(section => section.style.display = 'none');

                // Add 'active' class to clicked nav item and show corresponding content
                item.classList.add('active');
                const contentId = item.getAttribute('data-content');
                document.getElementById(contentId).style.display = 'block';
            });
        });
    });
</script>
<style>
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

    p.action {
        font-weight:500;
        font-size:14px;
    }

    .footer-content-details-proposal {
        border-top : 2px solid #eee;
    }

    .nav-item-custom .btn-custom {
        border-radius: 20px !important;
        background-color: #fff;
        color: #4c59ff;
    }

    .nav-item-custom.active .btn-custom {
        background-color: #4c59ff;
        color: #fff;
    }

    .nav-item-custom .btn-custom:hover{
        color : #fff;
        background-color: #4c59ff;
    }

    .team-content-wrap .item-team {
        border-radius : 20px;
        border: 1px dashed#aaa;
    }

    a.btn.btn-sm.btn-custom.btn-primary.active {
        background: #4c59ff;
        color: #fff;
        border-color: #4c59ff;
    }

    .file-data img {
        width: 30px;
    }

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
<script>
    var proposalId = @json($data->id);
    // Fungsi untuk memperbarui status
function updateProposalStatus(proposalId, status, feedback = '') {
    let swalText = status === 'review' 
        ? 'Anda yakin ingin melanjutkan proses?'
        : 'Anda yakin ingin menolak proposal?';

    let swalTitle = status === 'review' 
        ? 'Apakah Anda yakin melanjutkan?'
        : 'Apakah Anda yakin menolak?';

    Swal.fire({
        title: swalTitle,
        text: swalText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: status === 'review' ? 'Ya, lanjutkan' : 'Ya, tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = status === 'review' 
                ? `/update-status-review/${proposalId}` 
                : `/update-status-revisi/${proposalId}`;

            let data = {
                feedback: feedback // hanya mengirim feedback jika statusnya 'revisi'
            };

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil!', data.message, 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Gagal!', 'Terjadi kesalahan, status tidak diubah.', 'error');
                }
            })
            .catch(error => Swal.fire('Gagal!', error.message, 'error'));
        }
    });
}

// Event listener untuk tombol lanjutkan
const lanjutkanBtn = document.getElementById('btn-continue');
lanjutkanBtn?.addEventListener('click', function (e) {
    e.preventDefault();
    if (!lanjutkanBtn.classList.contains('disabled')) {
        updateProposalStatus(proposalId, 'review');
    }
});

// Event listener untuk tombol tolak
const rejectBtn = document.getElementById('btn-reject');
rejectBtn?.addEventListener('click', function (e) {
    e.preventDefault();
    if (!rejectBtn.classList.contains('disabled')) {
        // Menampilkan modal untuk memasukkan catatan
        Swal.fire({
            title: 'Masukkan catatan untuk revisi',
            input: 'textarea',
            inputLabel: 'Komentar atau catatan',
            inputPlaceholder: 'Tuliskan komentar Anda di sini...',
            showCancelButton: true,
            confirmButtonText: 'Kirim',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                const feedback = result.value;
                updateProposalStatus(proposalId, 'revisi', feedback);
            }
        });
    }
});

</script>
<style>
    .card.card-doc {
        border: 1px solid #ddd;
        transition: background-color 0.3s ease;
    }

    .card.card-doc.checked {
        background-color: #007bff!important;
        border-color: #0056b3;
    }

    .card.card-doc.checked .text-dark {
        color: #fff !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.lengkapdata-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const card = checkbox.closest('.card');

                if (this.checked) {
                    card.classList.add('checked');
                } else {
                    card.classList.remove('checked');
                }
            });
        });
    });
</script>
<script>
    document.querySelectorAll('.lengkapdata-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // Cek apakah semua checkbox dicentang
        const allChecked = [...document.querySelectorAll('.lengkapdata-checkbox')]
            .every(cb => cb.checked);

        // Aktifkan atau nonaktifkan tombol berdasarkan kondisi
        const lanjutkanBtn = document.getElementById('btn-continue');
        if (allChecked) {
            lanjutkanBtn.disabled = false; // Aktifkan tombol jika semua dicentang
        } else {
            lanjutkanBtn.disabled = true; // Nonaktifkan tombol jika ada yang belum dicentang
        }
    });
});

</script>
<script>
    function confirmSubmission(event) {
        event.preventDefault(); // Mencegah pengiriman form langsung

        // Tampilkan SweetAlert
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengubah data setelah dikirim!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika pengguna mengonfirmasi
                document.getElementById('rubrikForm').submit();
            }
        });

        return false; // Mencegah pengiriman form secara default
    }
</script>


@endpush