<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Hospital;

class HospitalController extends Controller
{
    /**
     * Show list of nearby hospitals from the database.
     */
    public function index()
    {
        $hospitals = Hospital::all();
        return view('user.hospitals', compact('hospitals'));
    }
}
