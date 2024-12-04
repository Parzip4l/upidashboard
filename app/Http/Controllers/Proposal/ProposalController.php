<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proposal;
use App\Collaboration;
use App\TeamComposition;
use App\IndustryPartner;
use App\AdminDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function create()
    {
        // Check if user already has a submitted proposal for the current year
        $user = Auth::user();
        $currentYear = Carbon::now()->year;
        dd($user);
        $existingProposal = Proposal::where('user_id', $user->id)
            ->whereYear('created_at', $currentYear)
            ->where('status', 'submitted')
            ->first();

        if ($existingProposal) {
            return redirect()->back()->with('error', 'You have already submitted a proposal for this year.');
        }

        // Load existing draft if available
        $draftProposal = Proposal::where('user_id', $user->id)
            ->where('status', 'draft')
            ->first();

        return view('proposal.form', compact('draftProposal'));
    }

    /**
     * Store or update the proposal as draft or submitted.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $currentYear = Carbon::now()->year;

        // Check if the user has already submitted a proposal for this year
        $existingProposal = Proposal::where('user_id', $user->id)
            ->whereYear('created_at', $currentYear)
            ->where('status', 'submitted')
            ->first();

        if ($existingProposal) {
            return redirect()->back()->with('error', 'You have already submitted a proposal for this year.');
        }

        // Find or create a new proposal draft
        $proposal = Proposal::updateOrCreate(
            [
                'user_id' => $user->id,
                'status' => 'draft'
            ],
            $request->only([
                'fakultas_kamda',
                'prodi',
                'ketua_inovator',
                'nama_industri',
                'tkt',
                'judul_proposal',
                'skema',
                'tema',
                'rencana_anggaran_biaya',
                'durasi_pelaksanaan',
                'dana_hilirisasi_inovasi',
                'mitra_tunai',
                'mitra_natura'
            ])
        );

        // Update related tables if provided
        if ($request->has('collaboration')) {
            Collaboration::updateOrCreate(
                ['proposal_id' => $proposal->id],
                $request->input('collaboration')
            );
        }

        if ($request->has('team_compositions')) {
            foreach ($request->input('team_compositions') as $teamData) {
                TeamComposition::updateOrCreate(
                    ['proposal_id' => $proposal->id, 'name' => $teamData['name']],
                    $teamData
                );
            }
        }

        if ($request->has('industry_partner')) {
            IndustryPartner::updateOrCreate(
                ['proposal_id' => $proposal->id],
                $request->input('industry_partner')
            );
        }

        if ($request->has('admin_documents')) {
            AdminDocument::updateOrCreate(
                ['proposal_id' => $proposal->id],
                $request->input('admin_documents')
            );
        }

        // Update status if user chooses to submit the proposal
        if ($request->input('submit') === 'submit') {
            $proposal->status = 'submitted';
            $proposal->save();

            return redirect()->route('proposal.index')->with('success', 'Proposal submitted successfully.');
        }

        return redirect()->back()->with('success', 'Draft saved successfully.');
    }

    /**
     * Display the list of proposals for the user.
     */
    public function index()
    {
        $user = Auth::user();
        
        $proposals = Proposal::where('user_id', $user->id)->get();
        return view('proposal.index', compact('proposals'));
    }

    /**
     * Show the details of a specific proposal.
     */
    public function show($id)
    {
        $proposal = Proposal::with(['collaboration', 'teamCompositions', 'industryPartner', 'adminDocument'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('proposal.show', compact('proposal'));
    }
}
