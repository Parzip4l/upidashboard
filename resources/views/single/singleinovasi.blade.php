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

<!-- Custom Nav Single -->
<div class="row">
    <div class="col-md-12">
        <div class="nav-custom-wrap d-flex mb-3">
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary active" data-content="konsep">Konsep</a>
            </div>
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="timeline">Timeline</a>
            </div>
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="pra-kontrak">Pra Kontrak</a>
            </div>
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="pelaksanaan">Pelaksanaan</a>
            </div>
            <div class="nav-item-custom me-2">
                <a href="#" class="btn btn-sm btn-custom btn-primary" data-content="monitoring">Monitoring Internal</a>
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
                                        <p>TKT : {{$data->tkt}} - <a href="{{ asset('storage/' .$data->bukti_tkt) }}" target="_blank">Download Bukti TKT</a></p>
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
                                <div class="head-details-wrap d-flex justify-content-between">
                                    <div class="component-1">
                                        <h6>{{$data->ketua_inovator}}</h6>
                                        <p class="text-muted">{{$data->nama_perguruan_tinggi}} - {{$data->program_studi}}</p>
                                    </div>
                                    <div class="component-2">
                                        <h6 class="mb-1">{{$data->nama_industri}}</h6>
                                    </div>
                                </div>
                                
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

                    </div>
                </div>
            </div>

            <!-- Kolaborasi -->
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

            <!-- Mitra -->
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
            @if($data->status === 'submited')
            <div class="card mt-4">
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="lengkapdata">
                        <label class="form-check-label" for="lengkapdata">
                            Apakah Data Sudah Lengkap?
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="sesuaidata">
                        <label class="form-check-label" for="sesuaidata">
                            Apakah Data Sudah Sesuai?
                        </label>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm disabled" id="lanjutkanBtn" disabled>Lanjutkan Proses</a>
                </div>
            </div>
            @endif
            @if (Auth::user()->role === 'reviewer')
            <div class="card mt-4">
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="lengkapdata">
                        <label class="form-check-label" for="lengkapdata">
                            Apakah Data Sudah Lengkap?
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="sesuaidata">
                        <label class="form-check-label" for="sesuaidata">
                            Apakah Data Sudah Sesuai?
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="revisi">
                        <label class="form-check-label" for="revisi">
                            Revisi Diperlukan
                        </label>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm disabled" id="lanjutkanBtn" disabled>Lanjutkan Proses</a>
                    <a href="#" class="btn btn-warning btn-sm disabled" id="revisiBtn" disabled>Revisi</a>
                    
                    <!-- Revision feedback textarea -->
                    <div id="feedbackSection" class="mt-3" style="display:none;">
                        <label for="feedbackText">Catatan Revisi / Komentar:</label>
                        <textarea id="feedbackText" class="form-control" name="feedback" rows="3" placeholder="Masukkan catatan revisi/ Komentar ..."></textarea>
                    </div>
                </div>
            </div>
            @endif
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
                    <div id="contentTimeline">
                        <ul class="timeline">
                            <li class="event {{ $timeline->proposal_upload === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Upload Proposal</h3>
                                
                            </li>
                            <li class="event {{ $timeline->administrasi === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Administrasi</h3>
                                    
                            </li>
                            <li class="event {{ $timeline->substansi === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Seleksi Subtansi</h3>
                                    
                            </li>
                            <li class="event {{ $timeline->revisi === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Revisi</h3>
                                    
                            </li>
                            <li class="event {{ $timeline->revisi_upload === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Upload Revisi</h3>
                                    
                            </li>
                            <li class="event {{ $timeline->verifikasi_revisi === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Verifikasi Proposal Revisi</h3>
                                    
                            </li>
                            <li class="event {{ $timeline->penetapan_pemenang === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Penetapan Pemenang</h3>
                                    
                            </li>
                            <li class="event {{ $timeline->kontrak === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Kontrak</h3>
                                    
                            </li>
                            <li class="event {{ $timeline->pelaksanaan === '1' ? 'completed' : 'not-completed' }}">
                                <p class="text-primary tx-12 mb-2">{{$data->created_at}}</p>
                                <h3 class="title text-primary">Pelaksanaan</h3>
                                    
                            </li>
                        </ul>
                    </div>
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
                    <img src="{{ asset('/proposaldraft.png') }}" alt="" style="max-width : 50%;">
                    <h3 class="mt-4">Data Tidak Tersedia</h3>
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
        border-left: 3px solid #6571ff;
        border-bottom-right-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        background: none!important;
        margin: 0px 20px;
        position: relative;
        padding: 0px;
        list-style: none;
        max-width: 100%;
    }

    .timeline .event {
        border-bottom: 1px dashed #e9ecef;
        padding: 10px;
        padding-left : 20px;
        margin-bottom: 10px;
        position: relative;
    }

    .timeline .event:after {
        box-shadow: 0 0 0 3px #6571ff;
        left: -15px;
        background: #fff;
        border-radius: 50%;
        height: 9px;
        width: 9px;
        content: "";
        top: 25px;
    }

    .timeline .event.not-completed:after {
        box-shadow: 0 0 0 3px #adb5bd;
        left: -15px;
        background: #fff;
        border-radius: 50%;
        height: 9px;
        width: 9px;
        content: "";
        top: 25px;
    }

    li.event.completed {
        background: #6571ff1a;
        border-radius: 20px;
        border-bottom: none;
        margin-left: 10px;
    }
    li.event.not-completed {
        background: #eee;
        border-radius: 20px;
        border-bottom: none;
        margin-left: 10px;
    }

    .timeline .event:last-of-type {
        padding-bottom: 25px;
        margin-bottom: 0;
        border: none;
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
// review.js

document.addEventListener("DOMContentLoaded", function () {
    const lengkapdataCheckbox = document.getElementById('lengkapdata');
    const sesuaidataCheckbox = document.getElementById('sesuaidata');
    const revisiCheckbox = document.getElementById('revisi');
    const lanjutkanBtn = document.getElementById('lanjutkanBtn');
    const revisiBtn = document.getElementById('revisiBtn');
    const feedbackSection = document.getElementById('feedbackSection');
    const feedbackText = document.getElementById('feedbackText');
    const proposalId = document.getElementById('IDProposal')?.value; // Optional chaining in case the element is not present

    function updateButtonState() {
        if (lengkapdataCheckbox.checked && sesuaidataCheckbox.checked) {
            lanjutkanBtn.classList.remove('disabled');
            lanjutkanBtn.removeAttribute('disabled');
        } else {
            lanjutkanBtn.classList.add('disabled');
            lanjutkanBtn.setAttribute('disabled', true);
        }

        if (revisiCheckbox && revisiCheckbox.checked) {
            revisiBtn.classList.remove('disabled');
            revisiBtn.removeAttribute('disabled');
            feedbackSection.style.display = 'block';
        } else {
            revisiBtn.classList.add('disabled');
            revisiBtn.setAttribute('disabled', true);
            feedbackSection.style.display = 'none';
        }
    }

    if (lengkapdataCheckbox) lengkapdataCheckbox.addEventListener('change', updateButtonState);
    if (sesuaidataCheckbox) sesuaidataCheckbox.addEventListener('change', updateButtonState);
    if (revisiCheckbox) revisiCheckbox.addEventListener('change', updateButtonState);

    lanjutkanBtn?.addEventListener('click', function (e) {
        e.preventDefault();
        if (!lanjutkanBtn.classList.contains('disabled')) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda yakin ingin melanjutkan proses?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/update-status-review/${proposalId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Berhasil!', 'Status berhasil diubah menjadi review.', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Gagal!', 'Terjadi kesalahan, status tidak diubah.', 'error');
                            }
                        })
                        .catch(error => Swal.fire('Gagal!', error.message, 'error'));
                }
            });
        }
    });

    revisiBtn?.addEventListener('click', function (e) {
        e.preventDefault();
        if (!revisiBtn.classList.contains('disabled')) {
            const feedback = feedbackText.value.trim();
            if (!feedback) {
                Swal.fire('Perhatian!', 'Silakan masukkan catatan revisi.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda yakin ingin mengirimkan revisi?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, revisi',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/update-status-revisi/${proposalId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body: JSON.stringify({ feedback: feedback })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Berhasil!', 'Revisi berhasil dikirim.', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Gagal!', 'Terjadi kesalahan, revisi tidak dikirim.', 'error');
                            }
                        })
                        .catch(error => Swal.fire('Gagal!', error.message, 'error'));
                }
            });
        }
    });
});

</script>
@endpush