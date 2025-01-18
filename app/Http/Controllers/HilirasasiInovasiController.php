<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HilirasasiInovasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\HilirisasiInovasiSubmitted;
use Illuminate\Support\Facades\Mail;
use App\Proposal;
use App\Collaboration;
use App\TeamComposition;
use App\IndustryPartner;
use App\AdminDocument;
use App\FundingHistory;
use App\UserActivityLog;
use App\PenilaianProposal;
use DataTables;

class HilirasasiInovasiController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Proposal::where('status', '!=', 'draft')->get(); // Fetching data
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button type="button" class="details btn btn-primary btn-sm" 
                        data-id="'.$row->id.'"
                        data-nidn="'.$row->nidn_nidk_nup.'"
                        data-nama="'.$row->nama_perguruan_tinggi.'"
                        data-program="'.$row->program_studi.'"
                        data-judul="'.$row->judul_inovasi.'"
                        data-nomor-ktp="'.$row->nomor_ktp.'"
                        data-tanggal-lahir="'.$row->tanggal_lahir.'"
                        data-nomor-telepon="'.$row->nomor_telepon.'"
                        data-deskripsi-profil="'.$row->deskripsi_profil.'"
                        data-kata-kunci="'.$row->kata_kunci.'"
                        data-inventor-contact-person="'.$row->inventor_contact_person.'"
                        data-deskripsi-keunggulan-inovasi="'.$row->deskripsi_keunggulan_inovasi.'"
                        data-foto-produk-inovasi="'.url('storage/'.$row->foto_produk_inovasi).'"
                        data-dokumen-produk-inovasi="'.url('storage/'.$row->dokumen_produk_inovasi).'"
                        data-poster-inovasi="'.url('storage/'.$row->poster_inovasi).'"
                        data-powerpoint="'.url('storage/'.$row->powerpoint).'"
                        data-video-inovasi="'.url('storage/'.$row->video_inovasi).'">Details</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('inovasi');
    }

    public function store(Request $request)
    {
        try {
            // Save the form data in the session if not submitting
            if ($request->ajax()) {
                session()->put('hilirasasi_inovasi', $request->all());
                return response()->json(['status' => 'saved']);
            }
    
            // If the form is submitted normally, also save data in session
            session()->put('hilirasasi_inovasi', $request->all());

            // Validate the request
            $request->validate([
                'nidn_nidk_nup' => 'required|string',
                'nama_perguruan_tinggi' => 'required|string',
                'program_studi' => 'required|string',
                'nomor_ktp' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'nomor_telepon' => 'required|string',
                'deskripsi_profil' => 'required|string',
                'kata_kunci' => 'required|string',
                'judul_inovasi' => 'required|string',
                'inventor_contact_person' => 'required|string',
                'deskripsi_keunggulan_inovasi' => 'required|string',
            ]);

            // Create a new instance of HilirasasiInovasi
            $inovasi = new HilirasasiInovasi();
            $inovasi->user_id = Auth::id();
            $inovasi->nidn_nidk_nup = $request->input('nidn_nidk_nup');
            $inovasi->nama_perguruan_tinggi = $request->input('nama_perguruan_tinggi');
            $inovasi->program_studi = $request->input('program_studi');
            $inovasi->nomor_ktp = $request->input('nomor_ktp');
            $inovasi->tanggal_lahir = $request->input('tanggal_lahir');
            $inovasi->nomor_telepon = $request->input('nomor_telepon');
            $inovasi->deskripsi_profil = $request->input('deskripsi_profil');
            $inovasi->kata_kunci = $request->input('kata_kunci');
            $inovasi->judul_inovasi = $request->input('judul_inovasi');
            $inovasi->inventor_contact_person = $request->input('inventor_contact_person');
            $inovasi->deskripsi_keunggulan_inovasi = $request->input('deskripsi_keunggulan_inovasi');
            $inovasi->kategori = $request->input('kategori');

            // Handle file uploads
            if ($request->hasFile('foto_produk_inovasi')) {
                $fotoPath = $request->file('foto_produk_inovasi')->store('inovasi/foto', 'public');
                $inovasi->foto_produk_inovasi = $fotoPath;
            }

            if ($request->hasFile('dokumen_produk_inovasi')) {
                $dokumenPath = $request->file('dokumen_produk_inovasi')->store('inovasi/dokumen', 'public');
                $inovasi->dokumen_produk_inovasi = $dokumenPath;
            }

            if ($request->hasFile('poster_inovasi')) {
                $posterPath = $request->file('poster_inovasi')->store('inovasi/poster', 'public');
                $inovasi->poster_inovasi = $posterPath;
            }

            if ($request->hasFile('powerpoint')) {
                $pptPath = $request->file('powerpoint')->store('inovasi/ppt', 'public');
                $inovasi->powerpoint = $pptPath;
            }

            if ($request->hasFile('video_inovasi')) {
                $videoPath = $request->file('video_inovasi')->store('inovasi/video', 'public');
                $inovasi->video_inovasi = $videoPath;
            }

            // Save the data
            $inovasi->save();

            Mail::to(Auth::user()->email)->send(new HilirisasiInovasiSubmitted(Auth::user()));

            // Clear the session data after save
            session()->forget('hilirasasi_inovasi');

            return redirect()->route('pengajuan.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error saving Hilirasasi Inovasi: '.$e->getMessage());

            // Return an error response
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }


    public function edit()
    {
        // Check if there's unsaved data in the session
        $sessionData = session('hilirasasi_inovasi', null);

        // Fetch the saved data from the database if exists
        $hilirasasiInovasi = HilirasasiInovasi::where('user_id', Auth::id())->first();

        return view('your.form.view', compact('hilirasasiInovasi', 'sessionData'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'status' => 'required|string',
        ]);

        try {
            $item = HilirasasiInovasi::findOrFail($request->id);
            $item->status = $request->status;
            $item->save();

            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Log the error message
            \Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }

    public function downloadFile($type, $id)
    {
        // Validate the type of file
        if (!in_array($type, ['foto_produk_inovasi', 'dokumen_produk_inovasi','poster_inovasi','powerpoint','video_inovasi'])) {
            return response()->json(['error' => 'Invalid file type'], 400);
        }

        // Find the record by ID
        $hilirasasiInovasi = HilirasasiInovasi::findOrFail($id);

        // Get the file path
        $filePath = $hilirasasiInovasi->$type;

        // Check if the file exists
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Get the file name and extension
        $fileName = basename($filePath);

        // Create a response to download the file
        return response()->download(Storage::disk('public')->path($filePath), $fileName);
    }

    public function show($id)
    {
        $reviewer = Auth::user()->name;
        $data = Proposal::findOrFail($id);

        // Mengambil proposal berikutnya yang bukan berstatus 'draft'
        $nextProposal = Proposal::where('id', '>', $id)
                                ->where('status', '!=', 'draft')
                                ->orderBy('id')
                                ->first();

        // Mengambil proposal sebelumnya yang bukan berstatus 'draft'
        $previousProposal = Proposal::where('id', '<', $id)
                                    ->where('status', '!=', 'draft')
                                    ->orderBy('id', 'desc')
                                    ->first();

        $nilai = PenilaianProposal::where('id_proposal', $id)
                  ->where('reviewer', $reviewer)
                  ->first();
        
        $logs = UserActivityLog::with('user')
            ->where('proposal_id', $id)
            ->latest()
            ->get();

        return view('single.singleinovasi', compact('data', 'nextProposal', 'previousProposal','logs','nilai'));
    }


}

