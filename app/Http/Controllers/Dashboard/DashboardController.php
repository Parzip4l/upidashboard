<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $loggedInUser = Auth::user();
        $hilirisasi = Proposal::count();
        $pending = Proposal::where('status','review')->count();
        $rejected = Proposal::where('status','ditolak')->count();
        $approved = Proposal::where('status','disetujui')->count();

        $queryPending = Proposal::where('status', 'review');

        if ($loggedInUser->role === 'reviewer') {
            $queryPending->whereIn('id', function ($subQuery) use ($loggedInUser) {
                $subQuery->select('id_proposal')
                    ->from('reviewers')
                    ->where(function ($q) use ($loggedInUser) {
                        $q->where('reviewer1', $loggedInUser->id)
                        ->orWhere('reviewer2', $loggedInUser->id);
                    });
            });
        }

        $dataPending = $queryPending->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Query untuk data terbaru (kecuali "draft")
        $queryTerbaru = Proposal::where('status', '!=', 'draft');

        if ($loggedInUser->role === 'reviewer') {
            $queryTerbaru->whereIn('id', function ($subQuery) use ($loggedInUser) {
                $subQuery->select('id_proposal')
                    ->from('reviewers')
                    ->where(function ($q) use ($loggedInUser) {
                        $q->where('reviewer1', $loggedInUser->id)
                        ->orWhere('reviewer2', $loggedInUser->id);
                    });
            });
        }

        $dataTerbaru = $queryTerbaru->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();


        return view('dashboard',compact('hilirisasi','pending','rejected','approved','dataPending','dataTerbaru'));
    }
}
