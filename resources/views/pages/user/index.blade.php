@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
@if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4>Form Pengajuan Hilirisasi Inovasi</h4>
            </div>
            <div class="card-body">
                <form id="hilirisasiForm" action="{{ route('hilirasasi-inovasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-steps">
                        <!-- Step 1: Data Pemohon -->
                        <div class="step" id="step1">
                            <div class="step-title-wrap mb-4">
                                <h5>Data Pemohon</h5>
                            </div>
                            <div class="form-group mb-2">
                                <label for="nidn_nidk_nup">NIDN/NIDK/NUP</label>
                                <input type="text" class="form-control" id="nidn_nidk_nup" name="nidn_nidk_nup" required placeholder="NIDN/NIDK/NUP">
                            </div>
                            <div class="form-group mb-2">
                                <label for="nama_perguruan_tinggi">Nama Perguruan Tinggi</label>
                                <input type="text" class="form-control" id="nama_perguruan_tinggi" name="nama_perguruan_tinggi" required placeholder="Nama Perguruan Tinggi">
                            </div>
                            <div class="form-group mb-2">
                                <label for="program_studi">Program Studi</label>
                                <input type="text" class="form-control" id="program_studi" name="program_studi" required placeholder="Program Studi">
                            </div>
                            <div class="form-group mb-2">
                                <label for="nomor_ktp">Nomor KTP</label>
                                <input type="text" class="form-control" id="nomor_ktp" name="nomor_ktp" required placeholder="Nomor KTP">
                            </div>
                            <div class="form-group mb-2">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="nomor_telepon">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon" required placeholder="Nomor Telepon">
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi_profil">Deskripsi Profil</label>
                                <textarea class="form-control" id="deskripsi_profil" name="deskripsi_profil" required placeholder="Deskripsi Profil"></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="kata_kunci">Kata Kunci</label>
                                <input type="text" class="form-control" id="kata_kunci" name="kata_kunci" required placeholder="Kata Kunci">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                        </div>

                        <!-- Step 2: Profil Produk Inovasi -->
                        <div class="step" id="step2" style="display: none;">
                            <div class="step-title-wrap mb-4">
                                <h5>Profil Produk Inovasi</h5>
                            </div>
                            <div class="form-group mb-2">
                                <label for="judul_inovasi">Judul Inovasi</label>
                                <input type="text" class="form-control" id="judul_inovasi" name="judul_inovasi" required placeholder="Judul Inovasi">
                            </div>
                            <div class="form-group mb-2">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" class="form-control" id="kategoriInovasi" required onchange="updateFormatLinks()">
                                    <option value="">--Pilih Kategori--</option>
                                    <option value="penelitian">Hilirisasi Inovasi Hasil Penelitian</option>
                                    <option value="pkm">Hilirisasi Inovasi Hasil Pengabdian Pada Masyarakat (PKM)</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="inventor_contact_person">Inventor Contact Person</label>
                                <input type="text" class="form-control" id="inventor_contact_person" name="inventor_contact_person" required placeholder="Inventor Contact Person">
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi_keunggulan_inovasi">Deskripsi Keunggulan Inovasi</label>
                                <textarea class="form-control" id="deskripsi_keunggulan_inovasi" name="deskripsi_keunggulan_inovasi" required placeholder="Deskripsi Keunggulan Inovasi"></textarea>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                        </div>

                        <!-- Step 3: Upload Files -->
                        <div class="step" id="step3" style="display: none;">
                            <div class="step-title-wrap mb-4">
                                <h5>Upload Files</h5>
                            </div>
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h5>Instruksi Pengisian</h5>
                                </div>
                                <div class="card-body">
                                    <div id="formatLinks">
                                        <!-- Default links (visible initially or based on default category) -->
                                        <div id="linkPenelitian" class="category-links">
                                            <p><strong>Unduh Format Isian:</strong> Silakan unduh format isian yang telah disediakan melalui tautan berikut:</p>
                                            <a href="https://hilirisasiinovasiupi.id/Format%20LP-RS001.docx" target="_blank">Format LP-RS001</a>
                                        </div>
                                        <div id="linkPkm" class="category-links" style="display: none;">
                                            <p><strong>Unduh Format Isian:</strong> Silakan unduh format isian yang telah disediakan melalui tautan berikut:</p>
                                            <a href="https://hilirisasiinovasiupi.id/Format%20LP-PKM001.docx" target="_blank">Format LP-PKM001</a>
                                        </div>
                                    </div>
                                    <ol>
                                        <li><strong>Isi Format dengan Lengkap:</strong> Setelah diunduh, mohon agar format isian tersebut diisi dengan data dan informasi yang diperlukan secara lengkap dan benar.</li>
                                        <li><strong>Unggah Kembali Format yang Sudah Diisi Beserta Luaran Pelengkapnya:</strong> Setelah semua bagian dari format isian telah diisi, harap unggah kembali dokumen yang sudah diisi melalui form pada langkah ke 3 (file dapat berupa .doc atau .pdf) </li>
                                    </ol>
                                    <h5>Luaran Pelengkap</h5>
                                    <ol>
                                        <li><strong>Foto Produk Inovasi</strong> Berupa file .jpg / .png / .pdf </li>
                                        <li><strong>Design Poster Inovasi</strong><br> Ukuran lebar 60 cm tinggi 160 cm <br> Dikiri atas diletakan logo UPI dan Kemendikbud <br> Berisi deskripsi tentang Gambaran Inovasi, Keunggulan Inovasi, Foto-foto Produk Inovasi, Nama Tim dan HKI yang telah diperoleh</li>
                                        <li><strong>Presentasi Power Point</strong> <br>
                                        5 halaman
                                        <br>
                                            • Halaman 1꞉ Judul
                                            <br>
                                            • Halaman 2꞉ Latar belakang permasalahan dan gambaran sebelum inovasi dihasilkan<br>
                                            • Halaman 3 dan 4꞉ Pelaksanaan dan Hasil Program<br>
                                            • Halaman 5꞉ Rencana Tindak Lanjut
                                        </li>
                                        <li><strong>Video Inovasi</strong> <br> Format mp4 / avi / mov </li>
                                    </ol>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="foto_produk_inovasi">Foto Produk Inovasi</label>
                                <input type="file" class="form-control" id="foto_produk_inovasi" name="foto_produk_inovasi" accept=".jpg,.png,.pdf" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="dokumen_produk_inovasi">Dokumen/Proposal Produk Inovasi</label>
                                <input type="file" class="form-control" id="dokumen_produk_inovasi" name="dokumen_produk_inovasi" accept=".doc,.pdf" required>
                            </div>
                            <!-- <div class="form-group mb-2">
                                <label for="design_poster">Design Poster Inovasi</label>
                                <input type="file" class="form-control" id="design_poster" name="design_poster" accept=".jpg,.png,.pdf" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="presentasi_power_point">Presentasi Power Point</label>
                                <input type="file" class="form-control" id="presentasi_power_point" name="presentasi_power_point" accept=".ppt,.pdf" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="video_inovasi">Video Inovasi</label>
                                <input type="file" class="form-control" id="video_inovasi" name="video_inovasi" accept=".mp4,.avi,.mov" required>
                            </div> -->
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
function showStep(stepNumber) {
    document.querySelectorAll('.step').forEach((step) => {
        step.style.display = 'none';
    });
    document.getElementById('step' + stepNumber).style.display = 'block';
}

function nextStep() {
    saveCurrentStep();
    let currentStep = document.querySelector('.step:not([style*="display: none"])');
    let stepNumber = parseInt(currentStep.id.replace('step', '')) || 0;
    showStep(stepNumber + 1);
}

function prevStep() {
    saveCurrentStep();
    let currentStep = document.querySelector('.step:not([style*="display: none"])');
    let stepNumber = parseInt(currentStep.id.replace('step', '')) || 0;
    showStep(stepNumber - 1);
}

function saveCurrentStep() {
    let currentStep = document.querySelector('.step:not([style*="display: none"])');
    let stepNumber = parseInt(currentStep.id.replace('step', '')) || 0;
    
    if (stepNumber === 1) {
        localStorage.setItem('nidn_nidk_nup', document.getElementById('nidn_nidk_nup').value);
        localStorage.setItem('nama_perguruan_tinggi', document.getElementById('nama_perguruan_tinggi').value);
        localStorage.setItem('program_studi', document.getElementById('program_studi').value);
        localStorage.setItem('nomor_ktp', document.getElementById('nomor_ktp').value);
        localStorage.setItem('tanggal_lahir', document.getElementById('tanggal_lahir').value);
        localStorage.setItem('nomor_telepon', document.getElementById('nomor_telepon').value);
        localStorage.setItem('deskripsi_profil', document.getElementById('deskripsi_profil').value);
        localStorage.setItem('kata_kunci', document.getElementById('kata_kunci').value);
    } else if (stepNumber === 2) {
        localStorage.setItem('judul_inovasi', document.getElementById('judul_inovasi').value);
        localStorage.setItem('kategori', document.getElementById('kategoriInovasi').value);
        localStorage.setItem('inventor_contact_person', document.getElementById('inventor_contact_person').value);
        localStorage.setItem('deskripsi_keunggulan_inovasi', document.getElementById('deskripsi_keunggulan_inovasi').value);
    }
}

function loadFormData() {
    if (localStorage.getItem('nidn_nidk_nup')) {
        document.getElementById('nidn_nidk_nup').value = localStorage.getItem('nidn_nidk_nup');
        document.getElementById('nama_perguruan_tinggi').value = localStorage.getItem('nama_perguruan_tinggi');
        document.getElementById('program_studi').value = localStorage.getItem('program_studi');
        document.getElementById('nomor_ktp').value = localStorage.getItem('nomor_ktp');
        document.getElementById('tanggal_lahir').value = localStorage.getItem('tanggal_lahir');
        document.getElementById('nomor_telepon').value = localStorage.getItem('nomor_telepon');
        document.getElementById('deskripsi_profil').value = localStorage.getItem('deskripsi_profil');
        document.getElementById('kata_kunci').value = localStorage.getItem('kata_kunci');
    }
    
    if (localStorage.getItem('judul_inovasi')) {
        document.getElementById('judul_inovasi').value = localStorage.getItem('judul_inovasi');
        document.getElementById('kategoriInovasi').value = localStorage.getItem('kategori');
        document.getElementById('inventor_contact_person').value = localStorage.getItem('inventor_contact_person');
        document.getElementById('deskripsi_keunggulan_inovasi').value = localStorage.getItem('deskripsi_keunggulan_inovasi');
    }
}

function updateFormatLinks() {
    const selectedCategory = document.getElementById('kategoriInovasi').value;
    document.querySelectorAll('.category-links').forEach((linkDiv) => {
        linkDiv.style.display = 'none';
    });
    if (selectedCategory === 'penelitian') {
        document.getElementById('linkPenelitian').style.display = 'block';
    } else if (selectedCategory === 'pkm') {
        document.getElementById('linkPkm').style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    loadFormData();
    showStep(1); // Show the first step initially
    updateFormatLinks(); // Ensure the correct links are displayed initially
});
</script>
<style>
    .step-title-wrap {
        padding: 15px;
        background: #6571ff;
        border-radius: 10px;
        width: 200px;
        text-align: center;
        color: #fff;
    }
</style>
@endpush
ct links are displayed initially
});
</script>
<style>
    .step-title-wrap {
        padding: 15px;
        background: #6571ff;
        border-radius: 10px;
        width: 200px;
        text-align: center;
        color: #fff;
    }
</style>
@endpush
