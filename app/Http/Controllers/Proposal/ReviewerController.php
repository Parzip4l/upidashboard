<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model
use App\Reviewer;
use App\Proposal;

class ReviewerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_proposal' => 'required|exists:proposals,id',
            'reviewer1' => 'required|exists:users,id',
            'reviewer2' => 'required|exists:users,id'
        ]);

        try {
            // Cek apakah reviewer sudah ada untuk proposal ini
            $reviewer = Reviewer::where('id_proposal', $request->id_proposal)->first();

            if ($reviewer) {
                // Jika sudah ada, lakukan update
                $reviewer->update($validated);
                return redirect()->back()->with('success', 'Reviewer berhasil diperbarui');
            } else {
                // Jika belum ada, lakukan insert
                Reviewer::create($validated);
                return redirect()->back()->with('success', 'Reviewer berhasil ditambahkan');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
