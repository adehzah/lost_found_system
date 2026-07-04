<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LostItem;
use App\Models\FoundItem;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->q);

        $lostItems = collect();
        $foundItems = collect();

        if ($query) {
            $lostItems = LostItem::where('item_name', 'like', "%{$query}%")
                ->orWhere('category', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhere('location_lost', 'like', "%{$query}%")
                ->latest()
                ->get();

            $foundItems = FoundItem::where('item_name', 'like', "%{$query}%")
                ->orWhere('category', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhere('location_found', 'like', "%{$query}%")
                ->latest()
                ->get();
        }

        return view('search', compact('query', 'lostItems', 'foundItems'));
    }
}