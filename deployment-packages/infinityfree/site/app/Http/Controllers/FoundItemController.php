<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoundItem;
use App\Models\Student;

class FoundItemController extends Controller
{
    public function index()
    {
        $foundItems = FoundItem::latest()->get();

        return view('found-items', compact('foundItems'));
    }

    public function create()
    {
        if (!session('student_id')) {
            return redirect('/login')->with('error', 'Please login before reporting a found item.');
        }

        return view('found-item-form');
    }

    public function store(Request $request)
    {
        if (!session('student_id')) {
            return redirect('/login')->with('error', 'Please login before reporting a found item.');
        }

        $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'location_found' => 'required|string|max:255',
            'date_found' => 'required|date',
            'contact_number' => 'required|string|max:30',
            'image' => 'nullable|image|max:4096',
        ]);

        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect('/login')->with('error', 'Student account not found. Please login again.');
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('found_items', 'public');
        }

        FoundItem::create([
            'reporter_name' => $student->full_name,
            'matric_number' => $student->matric_number,
            'item_name' => $request->item_name,
            'category' => $request->category,
            'description' => $request->description,
            'location_found' => $request->location_found,
            'date_found' => $request->date_found,
            'contact_number' => $request->contact_number,
            'image' => $imagePath,
            'status' => 'awaiting claim',
        ]);

        return redirect('/found-items')->with('success', 'Found item report submitted successfully. Please take the found item to the admin office for proper verification and safekeeping.');
    }

    public function show($id)
    {
        $item = FoundItem::findOrFail($id);

        $reporter = Student::where('matric_number', $item->matric_number)->first();

        $reportedBy = $item->reporter_name ?: ($reporter->full_name ?? ($item->matric_number ?: 'Not provided'));

        return view('found-item-details', compact('item', 'reportedBy'));
    }

    public function destroy($id)
    {
        if (session('is_admin') !== true) {
            return redirect('/found-items')->with('error', 'Only admin can delete found item reports.');
        }

        $item = FoundItem::findOrFail($id);
        $item->delete();

        return redirect('/found-items')->with('success', 'Found item deleted successfully.');
    }
}