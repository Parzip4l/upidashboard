<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProposalDataController extends Controller
{
    /**
     * Display the form to create a new proposal.
     */
    public function create()
    {
        $user = Auth::user();
        $currentYear = Carbon::now()->year;

        // Check if the user has already submitted a proposal this year
        $existingProposal = Proposal::where('id', $user->id)
            ->whereYear('created_at', $currentYear)
            ->where('status', 'submitted')
            ->first();

        if ($existingProposal) {
            return redirect()->back()->with('error', 'You have already submitted a proposal for this year.');
        }

        // Load existing draft if available
        $draftProposal = Proposal::where('id', $user->id)
            ->where('status', 'draft')
            ->first();

        return view('proposal.form', compact('draftProposal'));
    }

    /**
     * Store the proposal as draft or submit it.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'fakultas_kamda' => 'required',
            'nama_prodi' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Tentukan status, jika sudah cukup data untuk 'review' maka set 'review', jika tidak 'draft'
            $status = ($request->fakultas_kamda &&
                    $request->nama_prodi &&
                    $request->ketua_inovator &&
                    $request->nama_industri &&
                    $request->skema &&
                    $request->tema &&
                    $request->tkt &&
                    $request->judul_proposal &&
                    $request->durasi_pelaksanaan &&
                    $request->dana_hilirisasi &&
                    $request->mitra_tunai &&
                    $request->mitra_natura &&
                    $request->hasFile('bukti_tkt')
                    ) ? 'submited' : 'draft';

            // Simpan proposal
            $proposal = Proposal::create([
                'fakultas_kamda' => $request->fakultas_kamda,
                'prodi' => $request->nama_prodi,
                'ketua_inovator' => $request->ketua_inovator,
                'nama_industri' => $request->nama_industri,
                'skema' => $request->skema,
                'tema' => $request->tema,
                'tkt' => $request->tkt,
                'bukti_tkt' => $request->hasFile('bukti_tkt') ? $request->file('bukti_tkt')->store('bukti_tkt', 'public') : null,
                'judul_proposal' => $request->judul_proposal,
                'durasi_pelaksanaan' => $request->durasi_pelaksanaan,
                'dana_hilirisasi_inovasi' => $request->dana_hilirisasi,
                'mitra_tunai' => $request->mitra_tunai,
                'mitra_natura' => $request->mitra_natura,
                'created_by' => $user->id,
                'status' => $status,
            ]);

            // Simpan data kolaborasi
            $colaborasi = Collaboration::create([
                'proposal_id' => $proposal->id,
                'background' => $request->background,
                'target_users' => $request->target_users,
                'success_metrics' => $request->success_metrics,
                'implementation_needs' => $request->implementation_needs,
                'cooperation_expectation' => $request->cooperation_expectation,
                'industry_problems' => $request->industry_problems,
                'solution_description' => $request->solution_description,
                'proposed_incentives' => $request->proposed_incentives,
            ]);

            // Simpan industri mitra
            $industri = IndustryPartner::create([
                'proposal_id' => $proposal->id,
                'name' => $request->nama_mitra,
                'business_focus' => $request->fokus_bisnis,
                'business_scale' => $request->skala_usaha,
                'address' => $request->alamat_mitra,
                'email' => $request->email_mitra,
                'phone' => $request->telepon_mitra,
            ]);

            // Simpan anggota tim jika ada
            if ($request->has('team_members')) {
                foreach ($request->team_members as $member) {
                    $teamMember = TeamComposition::create([
                        'proposal_id' => $proposal->id,
                        'member_type' => $member['role'],
                        'identifier' => $member['nidn_or_nim'],
                        'name' => $member['name'],
                        'faculty_kamda' => $member['fakultas_kamda'],
                        'program' => $member['prodi'],
                        'active_status' => $member['status_keaktifan'],
                    ]);
                    
                    // Jika ada riwayat pendanaan, simpan juga
                    if (isset($member['funding_history'])) {
                        foreach ($member['funding_history'] as $history) {
                            FundingHistory::create([
                                'team_composition_id' => $teamMember->id,
                                'proposal_title' => $history['proposal_title'],
                                'year' => $history['year'],
                                'name' => $history['name'],
                                'status' => $history['status'],
                            ]);
                        }
                    }
                }
            }

            // simpan data timeline
            $timeline = Timeline::create([
                'proposal_id' => $proposal->id,
                'proposal_upload' => '1',
                'administrasi' => '1',
                'substansi' => '1',
                'revisi' => '0',
                'revisi_upload' => '0',
                'verifikasi_revisi' => '0',
                'penetapan_pemenang' => '0',
                'kontrak' => '0',
                'pelaksanaan' => '0',
            ]);

            // Simpan dokumen tambahan jika ada
            $documentData = AdminDocument::create([
                'proposal_id' => $proposal->id,
                'proposal_file' => $request->hasFile('proposal_file') ? $request->file('proposal_file')->store('admin_documents', 'public') : null,
                'partner_commitment_letter' => $request->hasFile('partner_commitment_letter') ? $request->file('partner_commitment_letter')->store('admin_documents', 'public') : null,
                'funding_commitment_letter' => $request->hasFile('funding_commitment_letter') ? $request->file('funding_commitment_letter')->store('admin_documents', 'public') : null,
                'study_commitment_letter' => $request->hasFile('study_commitment_letter') ? $request->file('study_commitment_letter')->store('admin_documents', 'public') : null,
                'applicant_bio_form' => $request->hasFile('applicant_bio_form') ? $request->file('applicant_bio_form')->store('admin_documents', 'public') : null,
                'partner_profile_form' => $request->hasFile('partner_profile_form') ? $request->file('partner_profile_form')->store('admin_documents', 'public') : null,
                'cooperation_agreement' => $request->hasFile('cooperation_agreement') ? $request->file('cooperation_agreement')->store('admin_documents', 'public') : null,
                'hki_agreement' => $request->hasFile('hki_agreement') ? $request->file('hki_agreement')->store('admin_documents', 'public') : null,
                'budget_plan_file' => $request->hasFile('budget_plan_file') ? $request->file('budget_plan_file')->store('admin_documents', 'public') : null,
            ]);

            DB::commit();

            return redirect()->route('proposals.index')->with('success', 'Proposal berhasil disimpan sebagai ' . $status);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Proposal gagal dibuat: ' . $e->getMessage());
        }
    }

    

    /**
     * Save the proposal as a draft (AJAX).
     */
    public function saveDraft(Request $request)
    {
        // Get the current authenticated user
        $user = Auth::user();

        // Update or create the proposal record
        $proposal = Proposal::updateOrCreate(
            ['id' => $user->id, 'status' => 'draft'],
            $request->only([
                'fakultas_kamda', 'prodi', 'ketua_inovator', 'nama_industri',
                'tkt', 'judul_proposal', 'skema', 'tema', 'rencana_anggaran_biaya',
                'durasi_pelaksanaan', 'dana_hilirisasi_inovasi', 'mitra_tunai', 'mitra_natura'
            ])
        );

        // If there are team compositions, update them
        if ($request->has('team_compositions')) {
            // Delete existing team compositions for this proposal
            TeamComposition::where('proposal_id', $proposal->id)->delete();

            // Create new team compositions
            foreach ($request->input('team_compositions') as $teamData) {
                TeamComposition::create(array_merge($teamData, ['proposal_id' => $proposal->id]));
            }
        }

        // Return a success response
        return response()->json(['status' => 'success', 'message' => 'Draft saved successfully.']);
    }

    /**
     * Display the list of proposals for the user.
     */
    public function index()
    {
        $user = Auth::user();
        $currentYear = now()->year;
        $proposals = Proposal::where('created_by', $user->id)
                ->whereYear('created_at', $currentYear)
                ->first();
        return view('proposal.index', compact('proposals'));
    }

    /**
     * Show the details of a specific proposal.
     */
    public function show($id)
    {
        $proposal = Proposal::with(['collaboration', 'teamCompositions', 'industryPartner', 'adminDocument'])
            ->where('id', $id)
            ->where('id', Auth::id())
            ->firstOrFail();

        return view('proposal.show', compact('proposal'));
    }


    public function edit($id)
    {
        $proposal = Proposal::with([
            'collaboration', 
            'industryPartner', 
            'teamCompositions', 
            'adminDocument', 
            'teamCompositions.fundingHistories' // Eager load funding history for team members
        ])->findOrFail($id);
    
        // Pass the proposal data to the view
        return view('proposal.edit', compact('proposal'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        // Validate the incoming request
        $validatedData = $request->validate([
            'fakultas_kamda' => 'required',
            'nama_prodi' => 'required',
            'ketua_inovator' => 'required',
            'nama_industri' => 'required',
            'skema' => 'required',
            'tema' => 'required',
            'tkt' => 'required',
            'team_members' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Find the proposal by ID
            $proposal = Proposal::findOrFail($id);
            
            // Determine the status based on the presence of required fields
            $status = (
                $request->fakultas_kamda &&
                $request->nama_prodi &&
                $request->ketua_inovator &&
                $request->nama_industri &&
                $request->skema &&
                $request->tema &&
                $request->tkt &&
                $request->judul_proposal &&
                $request->durasi_pelaksanaan &&
                $request->dana_hilirisasi &&
                $request->mitra_tunai &&
                $request->mitra_natura &&
                $request->hasFile('bukti_tkt')
            ) ? 'submited' : 'draft';
            // Update the proposal data
            $proposal->update([
                'fakultas_kamda' => $request->fakultas_kamda,
                'prodi' => $request->nama_prodi,
                'ketua_inovator' => $request->ketua_inovator,
                'nama_industri' => $request->nama_industri,
                'skema' => $request->skema,
                'tema' => $request->tema,
                'tkt' => $request->tkt,
                'bukti_tkt' => $request->hasFile('bukti_tkt') ? $request->file('bukti_tkt')->store('bukti_tkt', 'public') : $proposal->bukti_tkt,
                'judul_proposal' => $request->judul_proposal,
                'durasi_pelaksanaan' => $request->durasi_pelaksanaan,
                'dana_hilirisasi_inovasi' => $request->dana_hilirisasi,
                'mitra_tunai' => $request->mitra_tunai,
                'mitra_natura' => $request->mitra_natura,
                'created_by' => $user->id,
                'status' => $status,
            ]);

            // Update the collaboration record
            $collaboration = $proposal->collaboration;
            $collaboration->update([
                'background' => $request->background,
                'target_users' => $request->target_users,
                'success_metrics' => $request->success_metrics,
                'implementation_needs' => $request->implementation_needs,
                'cooperation_expectation' => $request->cooperation_expectation,
                'industry_problems' => $request->industry_problems,
                'solution_description' => $request->solution_description,
                'proposed_incentives' => $request->proposed_incentives,
            ]);

            // Update the industry partner data
            $industri = $proposal->industryPartner;
            $industri->update([
                'name' => $request->nama_mitra,
                'business_focus' => $request->fokus_bisnis,
                'business_scale' => $request->skala_usaha,
                'address' => $request->alamat_mitra,
                'email' => $request->email_mitra,
                'phone' => $request->telepon_mitra,
            ]);

            // Update the team members in the team_compositions table
            foreach ($validatedData['team_members'] as $member) {
                $teamMember = TeamComposition::where('proposal_id', $proposal->id)
                    ->where('identifier', $member['identifier'])
                    ->first();

                if ($teamMember) {
                    $teamMember->update([
                        'member_type' => $member['member_type'],
                        'identifier' => $member['identifier'],
                        'name' => $member['name'],
                        'faculty_kamda' => $member['faculty_kamda'],
                        'program' => $member['program'],
                        'active_status' => $member['active_status'],
                    ]);
                } else {
                    // If no existing team member found, create a new one
                    $teamMember = TeamComposition::create([
                        'proposal_id' => $proposal->id,
                        'member_type' => $member['member_type'],
                        'identifier' => $member['identifier'],
                        'name' => $member['name'],
                        'faculty_kamda' => $member['faculty_kamda'],
                        'program' => $member['program'],
                        'active_status' => $member['active_status'],
                    ]);
                }

                // Handle funding history if available
                if (isset($member['funding_history'])) {
                    foreach ($member['funding_history'] as $history) {
                        $fundingHistory = FundingHistory::where('team_composition_id', $teamMember->id)
                            ->where('proposal_title', $history['proposal_title'])
                            ->first();

                        if ($fundingHistory) {
                            $fundingHistory->update([
                                'year' => $history['year'],
                                'name' => $history['name'],
                                'status' => $history['status'],
                            ]);
                        } else {
                            FundingHistory::create([
                                'team_composition_id' => $teamMember->id,
                                'proposal_title' => $history['proposal_title'],
                                'year' => $history['year'],
                                'name' => $history['name'],
                                'status' => $history['status'],
                            ]);
                        }
                    }
                }
            }

            // Update or create admin documents
            $documentData = $proposal->adminDocument;
            $documentData->update([
                'proposal_file' => $request->hasFile('proposal_file') ? $request->file('proposal_file')->store('admin_documents', 'public') : $documentData->proposal_file,
                'partner_commitment_letter' => $request->hasFile('partner_commitment_letter') ? $request->file('partner_commitment_letter')->store('admin_documents', 'public') : $documentData->partner_commitment_letter,
                'funding_commitment_letter' => $request->hasFile('funding_commitment_letter') ? $request->file('funding_commitment_letter')->store('admin_documents', 'public') : $documentData->funding_commitment_letter,
                'study_commitment_letter' => $request->hasFile('study_commitment_letter') ? $request->file('study_commitment_letter')->store('admin_documents', 'public') : $documentData->study_commitment_letter,
                'applicant_bio_form' => $request->hasFile('applicant_bio_form') ? $request->file('applicant_bio_form')->store('admin_documents', 'public') : $documentData->applicant_bio_form,
                'partner_profile_form' => $request->hasFile('partner_profile_form') ? $request->file('partner_profile_form')->store('admin_documents', 'public') : $documentData->partner_profile_form,
                'cooperation_agreement' => $request->hasFile('cooperation_agreement') ? $request->file('cooperation_agreement')->store('admin_documents', 'public') : $documentData->cooperation_agreement,
                'hki_agreement' => $request->hasFile('hki_agreement') ? $request->file('hki_agreement')->store('admin_documents', 'public') : $documentData->hki_agreement,
                'budget_plan_file' => $request->hasFile('budget_plan_file') ? $request->file('budget_plan_file')->store('admin_documents', 'public') : $documentData->budget_plan_file,
            ]);

            DB::commit();

            return redirect()->route('proposals.index')->with('success', 'Proposal has been updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Proposal gagal diupdate' . $e->getMessage());
        }
    }

    public function updateStatusReview($id)
    {
        // Find the proposal by ID
        $proposal = Proposal::findOrFail($id);

        // Update the status to "review"
        $proposal->status = 'review';
        $proposal->save();

        // Return a JSON response for AJAX
        return response()->json(['success' => true, 'message' => 'Status updated to review']);
    }

    public function updateStatusRevisi($id, Request $request)
    {
        $user = Auth::user();
        
        // Find the proposal by ID
        $proposal = Proposal::findOrFail($id);
        
        // Check if feedback is provided
        if ($request->has('feedback')) {
            // Log feedback
            \Log::info('Feedback received: ' . $request->input('feedback'));

            // Insert into the Revisi table
            $revisi = new Revisi();
            $revisi->proposal_id = $proposal->id;  
            $revisi->catatan = $request->input('feedback');
            $revisi->created_by = $user->id;
            $revisi->save();
        }

        // Update the proposal's status to 'revisi'
        $proposal->status = 'revisi';
        $proposal->save();

        // Return a JSON response
        return response()->json(['success' => true, 'message' => 'Status updated to revisi and feedback saved']);
    }
}
