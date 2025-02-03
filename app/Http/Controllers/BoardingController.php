<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class BoardingController extends Controller
{
    public function index()
    {
        $houses = House::with(['cubicles.beds.currentAssignment.student'])
            ->where('school_id', auth()->user()->school_id)
            ->get();

        return view('boarding.index', compact('houses'));
    }
} 