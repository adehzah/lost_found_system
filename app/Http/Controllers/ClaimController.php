<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\Student;

class ClaimController extends Controller
{
    public function store(Request $request, $id)
{
    if (!session('student_id')) {
        return redirect('/login')->with('error', 'Please login before claiming an item.');
    }

    // validation continues here

        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect('/login')->with('error', 'Student account not found. Please login again.');
        }

        $foundItem = FoundItem::findOrFail($id);

        if ($foundItem->status === 'claimed') {
            return back()->with('error', 'This item has already been claimed.');
        }

        if (($foundItem->matric_number ?? '') == session('student_matric')) {
    return back()->with('error', 'You cannot claim an item you reported as found.');
}

        $existingClaim = Claim::where('found_item_id', $foundItem->id)
            ->where('matric_number', $student->matric_number)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingClaim) {
            return back()->with('error', 'You have already submitted a claim request for this item.');
        }

        $request->validate([
            'proof_description' => 'required|string|min:5|max:1000',
            'contact_number' => 'required|string|max:30',
            'proof_image' => 'nullable|image|max:4096',
         ]);

         $proofImagePath = null;

if ($request->hasFile('proof_image')) {
    $proofImagePath = $request->file('proof_image')->store('claim_proofs', config('filesystems.uploads_disk'));
}
        Claim::create([
            'found_item_id' => $foundItem->id,
            'claimant_name' => $student->full_name,
            'matric_number' => $student->matric_number,
            'contact_number' => $request->contact_number,
            'proof_description' => $request->proof_description,
            'proof_image' => $proofImagePath,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your claim request has been submitted successfully. The admin will review it.');
    }
}
