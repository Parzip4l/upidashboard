<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HilirasasiInovasi;
use App\Proposal;
use App\Collaboration;
use App\TeamComposition;
use App\IndustryPartner;
use App\AdminDocument;
use App\FundingHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $hilirisasi = Proposal::count();
        $pending = Proposal::where('status','review')->count();
        $rejected = Proposal::where('status','ditolak')->count();
        $approved = Proposal::where('status','disetujui')->count();

        $dataPending = Proposal::where('status', 'review')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        $dataTerbaru = Proposal::where('status', '!=', 'draft')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        return view('dashboard',compact('hilirisasi','pending','rejected','approved','dataPending','dataTerbaru'));
    }
}
