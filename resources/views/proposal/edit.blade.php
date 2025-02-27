@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
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
<div class="step-indicator mb-4">
    <div class="step me-2" id="step1" onclick="goToStep(1)">Data Inovator</div>
    <div class="step me-2" id="step2" onclick="goToStep(2)">Data Kolaborasi</div>
    <div class="step me-2" id="step3" onclick="goToStep(3)">Detail Proposal</div>
    <div class="step me-2" id="step4" onclick="goToStep(4)">Rencana Anggaran Biaya</div>
    <div class="step me-2" id="step5" onclick="goToStep(5)">Komposisi Team</div>
    <div class="step me-2" id="step6" onclick="goToStep(6)">Data Mitra</div>
    <div class="step me-2" id="step7" onclick="goToStep(7)">Berkas Administrasi</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Pengajuan Proposal</h5>
            </div>
            <div class="card-body">
            <form id="proposalForm" action="{{ route('proposals.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div id="multi-step-form">
                    <!-- Step 1: Detail Proposal -->
                    <div class="form-step" id="form-step-1">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nama_fakultas" class="form-label">Nama Fakultas/Kamda</label>
                                    <input type="text" name="fakultas_kamda" id="fakultas_kamda" class="form-control" value="{{$proposal->fakultas_kamda}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nama_prodi">Nama Prodi</label>
                                    <input type="text" name="nama_prodi" id="nama_prodi" class="form-control" value="{{$proposal->prodi}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="ketua_inovator">Ketua Inovator</label>
                                    <input type="text" name="ketua_inovator" id="ketua_inovator" class="form-control" value="{{$proposal->ketua_inovator}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nama_industri">Nama Industri (Mitra)</label>
                                    <input type="text" name="nama_industri" id="nama_industri" class="form-control" value="{{$proposal->nama_industri}}">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>

                    <div class="form-step" id="form-step-2">
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Latar Belakang</label>
                            <textarea name="background" id="detail_kolaborasi" class="form-control" rows="5">{{$proposal->collaboration->background}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Target Calon Pengguna</label>
                            <textarea name="target_users" id="detail_kolaborasi" class="form-control" rows="5">{{$proposal->collaboration->target_users}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Tolak Ukur Kesuksesan</label>
                            <textarea name="success_metrics" id="detail_kolaborasi" class="form-control" rows="5">{{$proposal->collaboration->success_metrics}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Kebutuhan Implementasi</label>
                            <textarea name="implementation_needs" id="detail_kolaborasi" class="form-control" rows="5">{{$proposal->collaboration->implementation_needs}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Ekspektasi Kerjasama</label>
                            <textarea name="cooperation_expectation" id="detail_kolaborasi" class="form-control" rows="5">{{$proposal->collaboration->cooperation_expectation}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Permasalahan Industri</label>
                            <textarea name="industry_problems" id="detail_kolaborasi" class="form-control" rows="5">{{$proposal->collaboration->industry_problems}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Penjelasan Solusi</label>
                            <textarea name="solution_description" id="detail_kolaborasi" class="form-control" rows="5">{{$proposal->collaboration->solution_description}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Bentuk Insentif</label>
                            <textarea name="proposed_incentives" id="detail_kolaborasi" class="form-control" rows="5">{{$proposal->collaboration->proposed_incentives}}</textarea>
                        </div>

                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>

                    <!-- Step 2: Tingkat Kesiapan Teknologi (TKT) -->
                    <div class="form-step" id="form-step-3">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="judul_proposal">Judul Proposal</label>
                                    <input type="text" name="judul_proposal" id="judul_proposal" class="form-control" value="{{$proposal->judul_proposal}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Skema</label>
                                    <select name="skema" id="skema" class="form-control">
                                        <option value="1" {{ $proposal->skema == 1 ? 'selected' : '' }}>Hilirisasi inovasi hasil riset untuk tujuan komersialisasi</option>
                                        <option value="2" {{ $proposal->skema == 2 ? 'selected' : '' }}>Hilirisasi kepakaran untuk menjawab Kebutuhan DUDI</option>
                                        <option value="3" {{ $proposal->skema == 3 ? 'selected' : '' }}>Pengembangan Produk inovasi bersama DUDI/Mitra Inovasi</option>
                                        <option value="4" {{ $proposal->skema == 4 ? 'selected' : '' }}>Peningkatan TKDN atau Produk Substitusi Impor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tema</label>
                                    <select name="tema" id="tema" class="form-control">
                                        <option value="1" {{ $proposal->tema == 1 ? 'selected' : '' }}>Ekonomi Hijau</option>
                                        <option value="2" {{ $proposal->tema == 2 ? 'selected' : '' }}>Ekonomi Digital</option>
                                        <option value="3" {{ $proposal->tema == 3 ? 'selected' : '' }}>Kemandirian Kesehatan</option>
                                        <option value="4" {{ $proposal->tema == 4 ? 'selected' : '' }}>Ekonomi Biru</option>
                                        <option value="5" {{ $proposal->tema == 5 ? 'selected' : '' }}>Pengembangan Pariwisata</option>
                                        <option value="6" {{ $proposal->tema == 6 ? 'selected' : '' }}>Inovasi Pendidikan</option>
                                        <option value="7" {{ $proposal->tema == 7 ? 'selected' : '' }}>Non Tematik (Umum)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="tkt">Tingkat Kesiapan Teknologi (TKT)</label>
                                    <select name="tkt" id="tkt" class="form-control">
                                        <option value="6" {{ $proposal->tkt == 6 ? 'selected' : '' }}>TKT 6</option>
                                        <option value="7" {{ $proposal->tkt == 7 ? 'selected' : '' }}>TKT 7</option>
                                        <option value="8" {{ $proposal->tkt == 8 ? 'selected' : '' }}>TKT 8</option>
                                        <option value="9" {{ $proposal->tkt == 9 ? 'selected' : '' }}>TKT 9</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>

                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>

                    <!-- Step 5: Rencana Anggaran Biaya -->
                    <div class="form-step" id="form-step-4">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="durasi_pelaksanaan">Durasi Pelaksanaan (bulan)</label>
                                    <input type="number" name="durasi_pelaksanaan" id="durasi_pelaksanaan" class="form-control" value="{{$proposal->durasi_pelaksanaan}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="dana_hilirisasi">Dana Hilirisasi Inovasi</label>
                                    <input type="number" name="dana_hilirisasi" id="dana_hilirisasi" class="form-control" value="{{$proposal->dana_hilirisasi_inovasi}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="mitra_tunai">Mitra Tunai</label>
                                    <input type="number" name="mitra_tunai" id="mitra_tunai" class="form-control" value="{{$proposal->mitra_tunai}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="mitra_natura">Mitra Natura</label>
                                    <input type="number" name="mitra_natura" id="mitra_natura" class="form-control" value="{{$proposal->mitra_natura}}">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>

                    <!-- Step 6: Komposisi Tim -->
                    <div class="form-step" id="form-step-5">
                        
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="team-members">Anggota Tim</label>
                                <div id="team-members-list">
                                    <!-- Existing Team Members from $proposal->teamCompositions -->
                                    @foreach($proposal->teamCompositions as $index => $teamMember)
                                        <div class="team-member">
                                            <hr>
                                            <h5>Anggota Tim</h5>
                                            <div class="form-group mb-3 mt-2">
                                                <label>Peran</label>
                                                <select name="team_members[{{ $index }}][member_type]" class="form-control role-select" onchange="updateNidnOrNimLabel(this)">
                                                    <option value="">Pilih Status Member</option>
                                                    <option value="Dosen" {{ $teamMember->member_type == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                                    <option value="Mahasiswa" {{ $teamMember->member_type == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                                    <option value="Staf" {{ $teamMember->member_type == 'Staf' ? 'selected' : '' }}>Staff Non Dosen</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="nidn-nim-label">NIDN/NIM</label>
                                                <input type="text" name="team_members[{{ $index }}][identifier]" class="form-control" value="{{ $teamMember->identifier }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label>Nama</label>
                                                <input type="text" name="team_members[{{ $index }}][name]" class="form-control" value="{{ $teamMember->name }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label>Fakultas/Kamda</label>
                                                <input type="text" name="team_members[{{ $index }}][faculty_kamda]" class="form-control" value="{{ $teamMember->faculty_kamda }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label>Prodi</label>
                                                <input type="text" name="team_members[{{ $index }}][program]" class="form-control" value="{{ $teamMember->program }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label>Status Keaktifan</label>
                                                <input type="text" name="team_members[{{ $index }}][active_status]" class="form-control" value="{{ $teamMember->active_status }}">
                                            </div>

                                            <div class="dosen-history" style="display: {{ $teamMember->member_type == 'Dosen' ? 'block' : 'none' }};">
                                                <label class="form-label">Riwayat Pendanaan Hilirisasi Inovasi</label>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Judul Proposal</th>
                                                            <th>Tahun</th>
                                                            <th>Nama</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="funding-history-body">
                                                        @foreach($teamMember->fundingHistories as $fundingIndex => $funding)
                                                            <tr>
                                                                <td><input type="text" name="team_members[{{ $index }}][funding_history][{{ $fundingIndex }}][proposal_title]" class="form-control" value="{{ $funding->proposal_title }}"></td>
                                                                <td><input type="text" name="team_members[{{ $index }}][funding_history][{{ $fundingIndex }}][year]" class="form-control" value="{{ $funding->year }}"></td>
                                                                <td><input type="text" name="team_members[{{ $index }}][funding_history][{{ $fundingIndex }}][name]" class="form-control" value="{{ $funding->name }}"></td>
                                                                <td>
                                                                    <select name="team_members[{{ $index }}][funding_history][{{ $fundingIndex }}][status]" class="form-control">
                                                                        <option value="Ketua" {{ $funding->status == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                                                                        <option value="Anggota" {{ $funding->status == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                                                                    </select>
                                                                </td>
                                                                <td><button type="button" class="btn btn-danger remove-funding-row">Hapus</button></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-primary add-funding-row mt-2">Tambah Riwayat Pendanaan</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-success mt-3" onclick="addTeamMember()">Tambah Anggota Tim</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>

                    <!-- Step 7: Mitra Utama -->
                    <div class="form-step" id="form-step-6">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nama_mitra">Nama Mitra</label>
                                    <input type="text" name="nama_mitra" id="nama_mitra" class="form-control" value="{{$proposal->industryPartner->name}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fokus_bisnis">Fokus Bisnis/Bidang Usaha</label>
                                    <input type="text" name="fokus_bisnis" id="fokus_bisnis" class="form-control" value="{{$proposal->industryPartner->business_focus}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="skala_usaha">Skala Usaha</label>
                                    <input type="text" name="skala_usaha" id="skala_usaha" class="form-control" value="{{$proposal->industryPartner->business_scale}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="skala_usaha">Alamat Mitra</label>
                                    <textarea name="alamat_mitra" class="form-control" id="">{{$proposal->industryPartner->address}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="skala_usaha">Alamat Email</label>
                                    <input type="email" name="email_mitra" id="email_mitra" class="form-control" value="{{$proposal->industryPartner->email}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="skala_usaha">Telepon Genggam (Whatsapp)</label>
                                    <input type="text" name="telepon_mitra" id="telepon_mitra" class="form-control" value="{{$proposal->industryPartner->phone}}">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>

                    <!-- Step 8: Berkas Administrasi -->
                    <div class="form-step" id="form-step-7">
                        
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="proposal_usulan">1. Roadmap Proposal</label>
                                <input type="file" name="roadmap" id="proposal_usulan" class="form-control" accept=".pdf" onchange="previewFile('proposal_usulan')" value="{{$proposal->adminDocument->roadmap}}">
                                @if($proposal->adminDocument->roadmap)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewProposalModal">Preview File</button>
                                        <div class="modal fade" id="previewProposalModal" tabindex="-1" aria-labelledby="previewProposalModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewProposalModalLabel">Proposal Usulan Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->roadmap) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="bukti_tkt">Upload Bukti Pengukuran TKT</label>
                                <input type="file" name="bukti_tkt" id="bukti_tkt" class="form-control" onchange="previewFile()">

                                @if($proposal->bukti_tkt) <!-- Check if the file exists in the database -->
                                    <div class="mt-2">
                                        <!-- Download link -->
                                        <a href="{{ asset('storage/'.$proposal->bukti_tkt) }}" target="_blank" class="btn btn-link mt-2">Download Existing File</a>
                                        
                                        <!-- Preview button for the existing file -->
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewModal">Preview File</button>

                                        <!-- Modal to show preview -->
                                        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $fileExtension = pathinfo($proposal->bukti_tkt, PATHINFO_EXTENSION);
                                                        @endphp
                                                        <!-- Check if the file is an image or PDF, and display accordingly -->
                                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                                            <img src="{{ asset('storage/'.$proposal->bukti_tkt) }}" alt="Preview" class="img-fluid">
                                                        @elseif($fileExtension == 'pdf')
                                                            <embed src="{{ asset('storage/'.$proposal->bukti_tkt) }}" type="application/pdf" width="100%" height="400px">
                                                        @else
                                                            <p>No preview available for this file type.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- 1. Proposal Usulan (PDF only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="proposal_usulan">Proposal Usulan (PDF only)</label>
                                <input type="file" name="proposal_file" id="proposal_usulan" class="form-control" accept=".pdf" onchange="previewFile('proposal_usulan')" value="{{$proposal->adminDocument->proposal_file}}">
                                @if($proposal->adminDocument->proposal_file)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewProposalModal">Preview File</button>
                                        <div class="modal fade" id="previewProposalModal" tabindex="-1" aria-labelledby="previewProposalModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewProposalModalLabel">Proposal Usulan Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->proposal_file) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 2. Surat Pernyataan Komitmen Mitra (PDF only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="komitmen_mitra">Surat Pernyataan Komitmen Mitra (PDF only)</label>
                                <input type="file" name="partner_commitment_letter" id="komitmen_mitra" class="form-control" accept=".pdf" onchange="previewFile('komitmen_mitra')" value="{{$proposal->adminDocument->partner_commitment_letter}}">
                                @if($proposal->adminDocument->partner_commitment_letter)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewPartnerCommitmentModal">Preview File</button>
                                        <div class="modal fade" id="previewPartnerCommitmentModal" tabindex="-1" aria-labelledby="previewPartnerCommitmentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewPartnerCommitmentModalLabel">Surat Pernyataan Komitmen Mitra Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->partner_commitment_letter) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 3. Pernyataan Komitmen Dana Mitra (PDF only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="komitmen_dana">Pernyataan Komitmen Dana Mitra (PDF only)</label>
                                <input type="file" name="funding_commitment_letter" id="komitmen_dana" class="form-control" accept=".pdf" onchange="previewFile('komitmen_dana')" value="{{$proposal->adminDocument->funding_commitment_letter}}"> 
                                @if($proposal->adminDocument->funding_commitment_letter)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewFundingCommitmentModal">Preview File</button>
                                        <div class="modal fade" id="previewFundingCommitmentModal" tabindex="-1" aria-labelledby="previewFundingCommitmentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewFundingCommitmentModalLabel">Pernyataan Komitmen Dana Mitra Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->funding_commitment_letter) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 4. Surat Pernyataan Tidak Sedang Studi Lanjut dan Tidak Berafiliasi dengan Mitra (PDF only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="tidak_studi_lanjut">Surat Pernyataan Tidak Sedang Studi Lanjut dan Tidak Berafiliasi dengan Mitra (PDF only)</label>
                                <input type="file" name="study_commitment_letter" id="tidak_studi_lanjut" class="form-control" accept=".pdf" onchange="previewFile('tidak_studi_lanjut')" value="{{$proposal->adminDocument->study_commitment_letter}}">
                                @if($proposal->adminDocument->study_commitment_letter)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewStudyCommitmentModal">Preview File</button>
                                        <div class="modal fade" id="previewStudyCommitmentModal" tabindex="-1" aria-labelledby="previewStudyCommitmentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewStudyCommitmentModalLabel">Surat Pernyataan Tidak Sedang Studi Lanjut Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->study_commitment_letter) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 5. Rencana Studi Pengembangan (PDF only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="rencana_studi_pengembangan">Formulir Biodata Pengusul (Ketua dan Anggota)</label>
                                <input type="file" name="applicant_bio_form" id="rencana_studi_pengembangan" class="form-control" accept=".pdf" onchange="previewFile('rencana_studi_pengembangan')" value="{{$proposal->adminDocument->applicant_bio_form}}">
                                @if($proposal->adminDocument->applicant_bio_form)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewStudyDevelopmentModal">Preview File</button>
                                        <div class="modal fade" id="previewStudyDevelopmentModal" tabindex="-1" aria-labelledby="previewStudyDevelopmentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewStudyDevelopmentModalLabel">Formulir Biodata Pengusul Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->applicant_bio_form) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 6. Surat Pernyataan Tidak Terikat Beasiswa (PDF only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="tidak_terikat_beasiswa">Formulir Profil Mitra</label>
                                <input type="file" name="partner_profile_form" id="tidak_terikat_beasiswa" class="form-control" accept=".pdf" onchange="previewFile('tidak_terikat_beasiswa')" value="{{$proposal->adminDocument->partner_profile_form}}">
                                @if($proposal->adminDocument->partner_profile_form)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewNoScholarshipCommitmentModal">Preview File</button>
                                        <div class="modal fade" id="previewNoScholarshipCommitmentModal" tabindex="-1" aria-labelledby="previewNoScholarshipCommitmentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewNoScholarshipCommitmentModalLabel">Formulir Profil Mitra Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->partner_profile_form) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 7. Rencana Pelaksanaan Penelitian (PDF only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="rencana_pelaksanaan">Surat Pernyataan Kesepakatan Pengusul dan Mitra Melakukan Kerja Sama</label>
                                <input type="file" name="cooperation_agreement" id="rencana_pelaksanaan" class="form-control" accept=".pdf" onchange="previewFile('rencana_pelaksanaan')" value="{{$proposal->adminDocument->cooperation_agreement}}">
                                @if($proposal->adminDocument->cooperation_agreement)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewResearchImplementationModal">Preview File</button>
                                        <div class="modal fade" id="previewResearchImplementationModal" tabindex="-1" aria-labelledby="previewResearchImplementationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewResearchImplementationModalLabel">Surat Pernyataan Kesepakatan Pengusul dan Mitra Melakukan Kerja Sama Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->cooperation_agreement) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 8. Dokumen Pendukung Lainnya (Excel only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="rencana_pelaksanaan">Perjanjian HKI dengan Mitra</label>
                                <input type="file" name="hki_agreement" id="hki_agreement" class="form-control" accept=".pdf" onchange="previewFile('hki_agreement')" value="{{$proposal->adminDocument->hki_agreement}}">
                                @if($proposal->adminDocument->hki_agreement)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewResearchhki_agreement">Preview File</button>
                                        <div class="modal fade" id="previewResearchhki_agreement" tabindex="-1" aria-labelledby="previewResearchhki_agreementLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewResearchhki_agreementLabel">Perjanjian HKI dengan Mitra Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="{{ asset('storage/'.$proposal->adminDocument->hki_agreement) }}" type="application/pdf" width="100%" height="400px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 9. Proposal Inovasi (PDF only) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="rencana_anggaran_biaya">9. Rencana Anggaran Biaya (Excel only)</label>
                                <input type="file" name="budget_plan_file" id="rencana_anggaran_biaya" class="form-control" accept=".xlsx,.xls" onchange="previewFile('rencana_anggaran_biaya')" value="{{$proposal->adminDocument->budget_plan_file}}">
                                
                                @if($proposal->adminDocument->budget_plan_file)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#previewBudgetPlanModal">Preview File</button>
                                        <div class="modal fade" id="previewBudgetPlanModal" tabindex="-1" aria-labelledby="previewBudgetPlanModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewBudgetPlanModalLabel">Rencana Anggaran Biaya Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>File Excel selected. You can download it <a href="{{ asset('storage/'.$proposal->adminDocument->budget_plan_file) }}" download>here</a>.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                        <!-- Additional administrative files -->

                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="submit" class="btn btn-success">Update Proposal</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
<script>
    // JavaScript to handle navigation between steps
    const formSteps = document.querySelectorAll(".form-step");
    let currentStep = 0;
    let teamIndex = document.querySelectorAll('.team-member').length
    let FundingData = 0;
    let fundingDataIndex = {};

    // Function to update step color
    function updateStepState() {
        document.querySelectorAll(".step").forEach((step, index) => {
            const stepId = index + 1; // Step indices are 1-based, so we add 1
            const stepFields = document.querySelectorAll(`#form-step-${stepId} .form-control`);

            // Check if all fields are filled in this step
            let filledCount = 0;
            stepFields.forEach((field) => {
                if (field.value.trim() !== "") {
                    filledCount++;
                }
            });

            // Update the color of the step based on the filled count
            if (filledCount === stepFields.length) {
                step.classList.remove('partial', 'active', 'unfilled');
                step.classList.add('completed');
            } else if (filledCount > 0) {
                step.classList.remove('completed', 'active', 'unfilled');
                step.classList.add('partial');
            } else {
                step.classList.remove('completed', 'partial', 'active');
                step.classList.add('unfilled');
            }

            // Highlight the current active step
            if (stepId === currentStep) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
    }

    // Ensure step 1 is displayed and active when the page loads
    document.addEventListener("DOMContentLoaded", () => {
        goToStep(1); // Load the first step on page load
    });

    // Function to go to a specific step
    function goToStep(step) {
        // Hide all form steps
        document.querySelectorAll('.form-step').forEach((stepElement) => {
            stepElement.style.display = 'none';
        });

        // Show the selected form step
        document.getElementById('form-step-' + step).style.display = 'block';

        // Update the current step indicator
        document.querySelectorAll('.step').forEach((stepElement) => {
            stepElement.classList.remove('active');
        });
        document.getElementById('step' + step).classList.add('active');

        currentStep = step;

        // Update the step colors based on field completion
        updateStepState();
    }

    // Function to handle next step button
    function nextStep() {
        if (currentStep < formSteps.length) {
            goToStep(currentStep + 1);
        }
    }

    // Function to handle previous step button
    function prevStep() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    }

    // Add event listeners to next and previous buttons
    document.querySelectorAll(".next-step").forEach((btn) => {
        btn.addEventListener("click", () => {
            nextStep();
        });
    });

    document.querySelectorAll(".prev-step").forEach((btn) => {
        btn.addEventListener("click", () => {
            prevStep();
        });
    });

    // Initial step display and color update
    goToStep(currentStep);

    // Initial call to update the state of steps
    updateStepState();
    
    // Function to dynamically add team member fields (for Step 6)

    function addTeamMember() {
    const container = document.getElementById("team-members-list");
    const div = document.createElement("div");
    div.className = "team-member";

    div.innerHTML = `
        <hr>
        <h5>Anggota Tim</h5>
        <div class="form-group mb-3 mt-2">
            <label>Peran</label>
            <select name="team_members[${teamIndex}][member_type]" class="form-control role-select" onchange="updateNidnOrNimLabel(this)">
                <option value="">Pilih Status Member</option>
                <option value="Dosen">Dosen</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Staf">Staff Non Dosen</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label class="nidn-nim-label">NIDN/NIM</label>
            <input type="text" name="team_members[${teamIndex}][identifier]" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Nama</label>
            <input type="text" name="team_members[${teamIndex}][name]" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Fakultas/Kamda</label>
            <input type="text" name="team_members[${teamIndex}][faculty_kamda]" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Prodi</label>
            <input type="text" name="team_members[${teamIndex}][program]" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Status Keaktifan</label>
            <input type="text" name="team_members[${teamIndex}][active_status]" class="form-control">
        </div>

        <div class="dosen-history" style="display: none;">
            <label class="form-label">Riwayat Pendanaan Hilirisasi Inovasi</label>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul Proposal</th>
                        <th>Tahun</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="funding-history-body">
                    <tr>
                        <td><input type="text" name="team_members[${teamIndex}][funding_history][${FundingData}][proposal_title]" class="form-control"></td>
                        <td><input type="text" name="team_members[${teamIndex}][funding_history][${FundingData}][year]" class="form-control"></td>
                        <td><input type="text" name="team_members[${teamIndex}][funding_history][${FundingData}][name]" class="form-control"></td>
                        <td>
                            <select name="team_members[${teamIndex}][funding_history][${FundingData}][status]" class="form-control">
                                <option value="">Select First</option>
                                <option value="Ketua">Ketua</option>
                                <option value="Anggota">Anggota</option>
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-danger remove-funding-row">Hapus</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary add-funding-row mt-2">Tambah Riwayat Pendanaan</button>
        </div>
    `;

    container.appendChild(div);
    initializeFundingHistory(div);
    
    // Increment teamIndex after adding a new team member
    teamIndex++;
    FundingData++;

    // Initialize the funding row functionality for the newly added team member
    const addFundingRowButton = div.querySelector('.add-funding-row');
    function initializeFundingHistory(teamMemberDiv) {
        const fundingHistoryBody = teamMemberDiv.querySelector('.funding-history-body');
        teamMemberDiv.querySelector('.add-funding-row').addEventListener('click', () => {
            const newRow = fundingHistoryBody.querySelector('tr').cloneNode(true);
            const teamMemberIndex = teamIndex - 1;
            fundingDataIndex[teamMemberIndex] = (fundingDataIndex[teamMemberIndex] || 0) + 1;

            // Ubah hanya bagian [funding_history][index]
            Array.from(newRow.querySelectorAll('input, select')).forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('[funding_history]')) {
                    input.setAttribute('name', name.replace(/\[funding_history\]\[\d+\]/, `[funding_history][${fundingDataIndex[teamMemberIndex]}]`));
                }
            });

            fundingHistoryBody.appendChild(newRow);
        });

        // Fungsi untuk menghapus baris pendanaan
        fundingHistoryBody.addEventListener('click', e => {
            if (e.target.classList.contains('remove-funding-row')) {
                e.target.closest('tr').remove();
            }
        });
    }
}

    function updateNidnOrNimLabel(selectElement) {
        const label = selectElement.closest('.team-member').querySelector('.nidn-nim-label');
        const dosenHistory = selectElement.closest('.team-member').querySelector('.dosen-history');

        // Show the correct label and display funding history table for Dosen
        if (selectElement.value === 'Dosen') {
            label.textContent = 'NIDN';
            dosenHistory.style.display = 'block';
        } else {
            label.textContent = selectElement.value === 'Mahasiswa' ? 'NIM' : 'NIP';
            dosenHistory.style.display = 'none';
        }
    }
</script>
<style>
    .step-indicator {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .step {
        flex: 1;
        text-align: center;
        padding: 10px;
        font-weight: 400;
        font-size: 14px;
        color: #999;
        border-radius: 10px;
        position: relative;
        transition: color 0.3s;
        border: 1px solid#aaa;
    }

    .step::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 100%;
        width: 100%;
        height: 2px;
        background-color: #ccc;
        transform: translateY(-50%);
        z-index: -1;
    }

    .step:last-child::after {
        display: none;
    }

    .step.completed {
        color: #fff; 
        background : #048b3f;
        border-color: #048b3f;
    }

    .step.active {
        color: #fff; /* Warna ungu */
        background : #5c6bc0;
        border-color: #5c6bc0;
    }

    .step.partial {
        color:#fff!important;
        background : #cc2952;
        border-color: #cc2952;
    }

    .step:not(.completed):not(.active) {
        color: #ccc;
    }
</style>
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
<script>
    function previewFile() {
        var preview = document.createElement('img');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();
        
        reader.onloadend = function () {
            preview.src = reader.result;
            document.querySelector('div.preview-container').appendChild(preview);
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
<script>
    function previewFile(fileId) {
        const fileInput = document.getElementById(fileId);
        const file = fileInput.files[0];
        const fileType = file ? file.type : null;

        // If the file is a PDF, show the preview
        if (fileType === 'application/pdf') {
            const reader = new FileReader();
            reader.onload = function(e) {
                const modal = document.getElementById('preview'+fileId+'Modal');
                modal.querySelector('.modal-body').innerHTML = `<embed src="${e.target.result}" type="application/pdf" width="100%" height="400px">`;
                new bootstrap.Modal(modal).show();
            };
            reader.readAsDataURL(file);
        }
    }

    function previewExcelFile() {
        alert("Excel file preview is not available, but you can download the file.");
    }
</script>
<script>
    document.querySelectorAll('.add-funding-row').forEach(function(button, teamMemberIndex) {
        button.addEventListener('click', function() {
            var tableBody = button.closest('.dosen-history').querySelector('.funding-history-body');
            var rowCount = tableBody.querySelectorAll('tr').length;
            
            // Create a new row for the current team member
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="team_members[${teamMemberIndex}][funding_history][${rowCount}][proposal_title]" class="form-control" value=""></td>
                <td><input type="text" name="team_members[${teamMemberIndex}][funding_history][${rowCount}][year]" class="form-control" value=""></td>
                <td><input type="text" name="team_members[${teamMemberIndex}][funding_history][${rowCount}][name]" class="form-control" value=""></td>
                <td>
                    <select name="team_members[${teamMemberIndex}][funding_history][${rowCount}][status]" class="form-control">
                        <option value="Ketua">Ketua</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </td>
                <td><button type="button" class="btn btn-danger remove-funding-row">Hapus</button></td>
            `;
            
            // Append the new row
            tableBody.appendChild(newRow);
            
            // Add functionality to remove the row
            newRow.querySelector('.remove-funding-row').addEventListener('click', function() {
                tableBody.removeChild(newRow);
            });
        });
    });
</script>
@endpush