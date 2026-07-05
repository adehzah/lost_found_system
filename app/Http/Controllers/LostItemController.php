<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LostItem;
use App\Models\Student;

class LostItemController extends Controller
{
    public function index()
    {
        $lostItems = LostItem::latest()->get();

        return view('lost-items', compact('lostItems'));
    }

    public function create()
    {
        if (!session('student_id')) {
            return redirect('/login')->with('error', 'Please login before reporting a lost item.');
        }

        return view('lost-item-form');
    }

    public function store(Request $request)
    {
        if (!session('student_id')) {
            return redirect('/login')->with('error', 'Please login before reporting a lost item.');
        }

        $request->validate([
    'item_name' => 'required|string|max:255',
    'category' => 'required|string|max:255',
    'description' => 'required|string',
    'location_lost' => 'required|string|max:255',
    'date_lost' => 'required|date',
    'contact_number' => 'required|string|max:30',
    'image' => 'nullable|image|max:4096'
]);  

        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect('/login')->with('error', 'Student account not found. Please login again.');
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('lost_items', config('filesystems.uploads_disk'));
        }

        LostItem::create([
            'reporter_name' => $student->full_name,
            'matric_number' => $student->matric_number,
            'item_name' => $request->item_name,
            'category' => $request->category,
            'description' => $request->description,
            'location_lost' => $request->location_lost,
            'date_lost' => $request->date_lost,
            'contact_number' => $request->contact_number,
            'image' => $imagePath,
            'status' => 'missing',
        ]);

        return redirect('/lost-items')->with('success', 'Lost item report submitted successfully.');
    }

    public function show($id)
    {
        $item = LostItem::findOrFail($id);

        $reporter = Student::where('matric_number', $item->matric_number)->first();

        $reportedBy = $item->reporter_name ?: ($reporter->full_name ?? ($item->matric_number ?: 'Not provided'));

        return view('lost-item-details', compact('item', 'reportedBy'));
    }

    public function destroy($id)
    {
        if (session('is_admin') !== true) {
            return redirect('/lost-items')->with('error', 'Only admin can delete lost item reports.');
        }

        $item = LostItem::findOrFail($id);
        $item->delete();

        return redirect('/lost-items')->with('success', 'Lost item deleted successfully.');
    }
}
