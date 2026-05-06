<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalManageController extends Controller
{
    /**
     * Show all hospitals with add form.
     */
    public function index()
    {
        $hospitals = Hospital::latest()->paginate(10);
        return view('admin.hospitals', compact('hospitals'));
    }

    /**
     * Store a new hospital.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'address'  => 'required|string|max:500',
            'phone'    => 'required|string|max:20',
            'map_link' => 'nullable|url|max:500',
        ]);

        Hospital::create($request->only('name', 'address', 'phone', 'map_link'));

        return redirect()->route('admin.hospitals')
            ->with('success', 'Hospital added successfully!');
    }

    /**
     * Show edit form for a hospital.
     */
    public function edit($id)
    {
        $hospital  = Hospital::findOrFail($id);
        $hospitals = Hospital::latest()->paginate(10);
        return view('admin.hospitals', compact('hospital', 'hospitals'));
    }

    /**
     * Update a hospital record.
     */
    public function update(Request $request, $id)
    {
        $hospital = Hospital::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'address'  => 'required|string|max:500',
            'phone'    => 'required|string|max:20',
            'map_link' => 'nullable|url|max:500',
        ]);

        $hospital->update($request->only('name', 'address', 'phone', 'map_link'));

        return redirect()->route('admin.hospitals')
            ->with('success', 'Hospital updated successfully!');
    }

    /**
     * Delete a hospital.
     */
    public function destroy($id)
    {
        Hospital::findOrFail($id)->delete();
        return redirect()->route('admin.hospitals')
            ->with('success', 'Hospital deleted successfully!');
    }
}
