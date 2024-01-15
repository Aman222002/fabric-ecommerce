<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = company::where(' skills', 'like', "%$query%")
            ->orWhere('experience', 'like', "%$query%")
            ->orWhere('location', 'like', "%$query%")
            ->get();
        return response()->json($results);
    }
}
