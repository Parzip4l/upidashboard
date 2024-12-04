<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Proposal;
use App\Collaboration;
use App\TeamComposition;
use App\IndustryPartner;
use App\AdminDocument;
use App\FundingHistory;
use App\Revisi;
use App\Timeline;
use Carbon\Carbon;
use App\PemenangM;
use App\KontrakPemenang;

use PhpOffice\PhpWord\TemplateProcessor;

class PemenangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proposal = Proposal::where('status','submited')->get();
        return view('proposal.pemenang.index', compact('proposal'));
    }

    public function setWinner(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_proposal' => 'required|exists:proposals,id',
                'ditetapkan_oleh' => 'required|exists:users,id', 
                'tahun' => 'required|integer'
            ]);

            // Buat entri baru di tabel Pemenang
            PemenangM::create([
                'proposal_id' => $validated['id_proposal'],
                'ditetapkan_oleh' => $validated['ditetapkan_oleh'],
                'tahun' => $validated['tahun'],
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function generateWord($id)
    {
        // Ambil data proposal dari database
        $proposal = Proposal::findOrFail($id);

        // Lokasi file template Word
        $templatePath = storage_path('app/templates/PKS_template.docx'); // Simpan template di folder `storage/app/templates`
        $fileName = 'Kontrak_' . $proposal->ketua_inovator . '_' . time() . '.docx'; 
        $outputPath = storage_path('app/public/Kontrak_' . $proposal->ketua_inovator . '.docx');

        // Buat instance TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);
        $currentYear = Carbon::now()->year;
        // Ganti placeholder dengan data dari database
        $templateProcessor->setValue('pihak_kedua', $proposal->ketua_inovator);
        $templateProcessor->setValue('tanggal', Carbon::now()->translatedFormat('l, d F Y'));
        $templateProcessor->setValue('judul_proposal', $proposal->judul_proposal);
        $templateProcessor->setValue('tahun', $currentYear);

        // Simpan dokumen yang telah diubah
        $templateProcessor->saveAs($outputPath);

        // Simpan ke database
        $kontrakUrl = asset('storage/' . $fileName); // URL file kontrak
        KontrakPemenang::updateOrCreate(
            ['proposal_id' => $proposal->id], // Kondisi untuk mengecek entri
            ['kontrak' => $kontrakUrl]       // Data yang akan disimpan atau diperbarui
        );

        // Unduh file ke pengguna
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
