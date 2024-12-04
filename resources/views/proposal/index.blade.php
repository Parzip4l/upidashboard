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
@if(!$proposals)
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
            <form id="proposalForm" action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="multi-step-form">
                    <!-- Step 1: Detail Proposal -->
                    <div class="form-step" id="form-step-1">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nama_fakultas" class="form-label">Nama Fakultas/Kamda</label>
                                    <input type="text" name="fakultas_kamda" id="fakultas_kamda" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nama_prodi">Nama Prodi</label>
                                    <input type="text" name="nama_prodi" id="nama_prodi" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="ketua_inovator">Ketua Inovator</label>
                                    <input type="text" name="ketua_inovator" id="ketua_inovator" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nama_industri">Nama Industri (Mitra)</label>
                                    <input type="text" name="nama_industri" id="nama_industri" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>

                    <div class="form-step" id="form-step-2">
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Latar Belakang</label>
                            <textarea name="background" id="detail_kolaborasi" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Target Calon Pengguna</label>
                            <textarea name="target_users" id="detail_kolaborasi" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Tolak Ukur Kesuksesan</label>
                            <textarea name="success_metrics" id="detail_kolaborasi" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Kebutuhan Implementasi</label>
                            <textarea name="implementation_needs" id="detail_kolaborasi" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Ekspektasi Kerjasama</label>
                            <textarea name="cooperation_expectation" id="detail_kolaborasi" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Permasalahan Industri</label>
                            <textarea name="industry_problems" id="detail_kolaborasi" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Penjelasan Solusi</label>
                            <textarea name="solution_description" id="detail_kolaborasi" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="detail_kolaborasi">Bentuk Insentif</label>
                            <textarea name="proposed_incentives" id="detail_kolaborasi" class="form-control" rows="5"></textarea>
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
                                    <input type="text" name="judul_proposal" id="judul_proposal" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Skema</label>
                                    <select name="skema" id="skema" class="form-control">
                                        <option value="1">Hilirisasi inovasi hasil riset untuk tujuan komersialisasi</option>
                                        <option value="2">Hilirisasi kepakaran untuk menjawab Kebutuhan DUDI</option>
                                        <option value="3">Pengembangan Produk inovasi bersama DUDI/Mitra Inovasi</option>
                                        <option value="4">Peningkatan TKDN atau Produk Substitusi Impor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tema</label>
                                    <select name="tema" id="tema" class="form-control">
                                        <option value="1">Ekonomi Hijau</option>
                                        <option value="2">Ekonomi Digital</option>
                                        <option value="3">Kemandirian Kesehatan</option>
                                        <option value="4">Ekonomi Biru</option>
                                        <option value="5">Pengembangan Pariwisata</option>
                                        <option value="6">Inovasi Pendidikan</option>
                                        <option value="7">Non Tematik (Umum)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="tkt">Tingkat Kesiapan Teknologi (TKT)</label>
                                    <select name="tkt" id="tkt" class="form-control">
                                        <option value="6">TKT 6</option>
                                        <option value="7">TKT 7</option>
                                        <option value="8">TKT 8</option>
                                        <option value="9">TKT 9</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="bukti_tkt">Upload Bukti Pengukuran TKT</label>
                                    <input type="file" name="bukti_tkt" id="bukti_tkt" class="form-control">
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
                                    <input type="number" name="durasi_pelaksanaan" id="durasi_pelaksanaan" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="dana_hilirisasi">Dana Hilirisasi Inovasi</label>
                                    <input type="number" name="dana_hilirisasi" id="dana_hilirisasi" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="mitra_tunai">Mitra Tunai</label>
                                    <input type="number" name="mitra_tunai" id="mitra_tunai" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="mitra_natura">Mitra Natura</label>
                                    <input type="number" name="mitra_natura" id="mitra_natura" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>

                    <!-- Step 6: Komposisi Tim -->
                    <div class="form-step" id="form-step-5">
                        
                        <div id="team-members-list" class="mb-3">
                            <button type="button" class="btn btn-primary" onclick="addTeamMember()">Add Team Member</button>
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
                                    <input type="text" name="nama_mitra" id="nama_mitra" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fokus_bisnis">Fokus Bisnis/Bidang Usaha</label>
                                    <input type="text" name="fokus_bisnis" id="fokus_bisnis" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="skala_usaha">Skala Usaha</label>
                                    <input type="text" name="skala_usaha" id="skala_usaha" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="skala_usaha">Alamat Mitra</label>
                                    <textarea name="alamat_mitra" class="form-control" id=""></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="skala_usaha">Alamat Email</label>
                                    <input type="email" name="email_mitra" id="email_mitra" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="skala_usaha">Telepon Genggam (Whatsapp)</label>
                                    <input type="text" name="telepon_mitra" id="telepon_mitra" class="form-control">
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
                                    <label class="form-label" for="proposal_usulan">1. Proposal Usulan (PDF only)</label>
                                    <input type="file" name="proposal_file" id="proposal_usulan" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="komitmen_mitra">2. Surat Pernyataan Komitmen Mitra (PDF only)</label>
                                    <input type="file" name="partner_commitment_letter" id="komitmen_mitra" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="komitmen_dana">3. Pernyataan Komitmen Dana Mitra (PDF only)</label>
                                    <input type="file" name="funding_commitment_letter" id="komitmen_dana" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="tidak_studi_lanjut">4. Surat Pernyataan Tidak Sedang Studi Lanjut dan Tidak Berafiliasi dengan Mitra (PDF only)</label>
                                    <input type="file" name="study_commitment_letter" id="tidak_studi_lanjut" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="biodata_pengusul">5. Formulir Biodata Pengusul (PDF only)</label>
                                    <input type="file" name="applicant_bio_form" id="biodata_pengusul" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="profil_mitra">6. Formulir Profil Mitra (PDF only)</label>
                                    <input type="file" name="partner_profile_form" id="profil_mitra" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="kesepakatan_kerja_sama">7. Surat Pernyataan Kesepakatan Pengusul dan Mitra Melakukan Kerja Sama (PDF only)</label>
                                    <input type="file" name="cooperation_agreement" id="kesepakatan_kerja_sama" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="perjanjian_hki">8. Perjanjian HKI dengan Mitra (PDF only)</label>
                                    <input type="file" name="hki_agreement" id="perjanjian_hki" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="rencana_anggaran_biaya">9. Rencana Anggaran Biaya (Excel only)</label>
                                    <input type="file" name="budget_plan_file" id="rencana_anggaran_biaya" class="form-control" accept=".xls,.xlsx">
                                </div>
                            </div>
                        </div>

                        <!-- Additional administrative files -->

                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="submit" class="btn btn-success">Submit Proposal</button>
                        <button type="submit" class="btn btn-warning save-draft text-white" onclick="saveDraft()">Save as Draft</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@elseif($proposals->status === 'draft')
    <div class="draft-status-wrap">
        <div class="draft-content">
            <img src="{{ asset('/proposaldraft.png') }}" alt="" style="max-width : 50%;">
            <h3 class="mt-4">Anda Memiliki Proposal Berstatus Draft</h3>
            <p class="text-muted">Untuk Melanjutkan Proposal Silahkan Klik Tombol Dibawah ini</p>
            <a href="{{route('proposals.edit', $proposals->id)}}" class="btn btn-primary btn-sm mt-4">Lanjutkan Proposal</a>
        </div>
    </div>
@else
    <div class="draft-status-wrap">
        <div class="draft-content">
            <img src="{{ asset('/proposalreview.png') }}" alt="" style="max-width : 50%;">
            <h3 class="mt-4">Anda Sudah Mengajukan Proposal Untuk Tahun Ini</h3>
            <p class="text-muted">Untuk Melihat Status Proposal Silahkan Klik Tombol Dibawah ini</p>
            <a href="{{route('dashboard.index')}}" class="btn btn-success btn-sm mt-4">Lihat Proposal</a>
        </div>
    </div>
@endif 
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
    let teamIndex = 0;
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
            <select name="team_members[${teamIndex}][role]" class="form-control role-select" onchange="updateNidnOrNimLabel(this)">
                <option value="">Pilih Status Member</option>
                <option value="Dosen">Dosen</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Staf">Staff Non Dosen</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label class="nidn-nim-label">NIDN/NIM</label>
            <input type="text" name="team_members[${teamIndex}][nidn_or_nim]" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Nama</label>
            <input type="text" name="team_members[${teamIndex}][name]" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Fakultas/Kamda</label>
            <input type="text" name="team_members[${teamIndex}][fakultas_kamda]" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Prodi</label>
            <input type="text" name="team_members[${teamIndex}][prodi]" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Status Keaktifan</label>
            <input type="text" name="team_members[${teamIndex}][status_keaktifan]" class="form-control">
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

    function saveDraft() {
        const form = document.querySelector('form'); // Ensure this is the form element you're submitting
        const formData = new FormData(form);
        fetch('/proposals/save-draft', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Draft saved successfully!');
            } else {
                alert('Failed to save draft.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
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
        background : #fbc02d;
        border-color: #fbc02d;
    }

    .step:not(.completed):not(.active) {
        color: #ccc;
    }
    .draft-content img {
        width: 200px;
    }

    .draft-content {
        padding: 50px;
        border: 2px dashed #aaa;
        border-radius: 30px;
        text-align: center;
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
@endpushe;
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
        background : #fbc02d;
        border-color: #fbc02d;
    }

    .step:not(.completed):not(.active) {
        color: #ccc;
    }
    .draft-content img {
        width: 200px;
    }

    .draft-content {
        padding: 50px;
        border: 2px dashed #aaa;
        border-radius: 30px;
        text-align: center;
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
@endpush