<?php

namespace App\Http\Controllers;

use App\Models\Foreigner;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ForeignerController extends Controller
{
    public function index(Request $request)
    {
        $query = Foreigner::query();

        if ($request->filled('nationality')) {
            $query->where('nationality', $request->nationality);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('region')) {
            $query->where('city', 'like', '%' . $request->region . '%');
        }

        $foreigners = $query->select([
            'id', 'first_name', 'last_name', 'nationality', 'passport_number',
            'status', 'city', 'state_province', 'visa_expiry_date', 'photo'
        ])->orderBy('created_at', 'desc')->paginate(20);

        $nationalities = Foreigner::distinct()->pluck('nationality')->sort();
        $regions = Region::pluck('name', 'id');

        return view('foreigners.index', compact('foreigners', 'nationalities', 'regions'));
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        return view('foreigners.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'passport_number' => 'nullable|string|unique:foreigners,passport_number',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'visa_type' => 'required|string|max:255',
            'visa_status' => 'required|string|max:255',
            'visa_expiry' => 'nullable|date',
            'entry_date' => 'nullable|date',
            'current_address' => 'required|string|max:500',
            'city_regency' => 'required|string|max:255',
            'subdistrict' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'emergency_contact' => 'nullable|string'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('foreigners', 'public');
        }

        $foreigner = Foreigner::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'nationality' => $validated['nationality'],
            'passport_number' => $validated['passport_number'],
            'photo' => $photoPath,
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'occupation' => $request->occupation,
            'visa_type' => $validated['visa_type'],
            'visa_expiry_date' => $validated['visa_expiry'],
            'entry_date' => $validated['entry_date'] ?? now(),
            'current_address' => $validated['current_address'],
            'city' => $validated['city_regency'],
            'state_province' => $validated['subdistrict'],
            'country' => $validated['village'],
            'postal_code' => $validated['postal_code'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'phone_number' => $validated['phone'],
            'email' => $validated['email'],
            'emergency_contact_name' => $validated['emergency_contact'],
            'status' => 'active'
        ]);

        return redirect()->route('foreigners.index')
            ->with('success', 'Data WNA berhasil ditambahkan!');
    }

    public function show(Foreigner $foreigner)
    {
        return view('foreigners.show', compact('foreigner'));
    }

    public function edit(Foreigner $foreigner)
    {
        $regions = Region::orderBy('name')->get();
        return view('foreigners.edit', compact('foreigner', 'regions'));
    }

    public function update(Request $request, Foreigner $foreigner)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'passport_number' => [
                'nullable',
                'string',
                Rule::unique('foreigners')->ignore($foreigner->id)
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'visa_type' => 'required|string|max:255',
            'visa_status' => 'required|string|max:255',
            'visa_expiry' => 'nullable|date',
            'entry_date' => 'nullable|date',
            'current_address' => 'required|string|max:500',
            'region_id' => 'nullable|integer',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'emergency_contact' => 'nullable|string'
        ]);

        $photoPath = $foreigner->photo;
        if ($request->hasFile('photo')) {
            if ($foreigner->photo) {
                \Storage::disk('public')->delete($foreigner->photo);
            }
            $photoPath = $request->file('photo')->store('foreigners', 'public');
        }

        $foreigner->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'nationality' => $validated['nationality'],
            'passport_number' => $validated['passport_number'],
            'photo' => $photoPath,
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'occupation' => $request->occupation,
            'visa_type' => $validated['visa_type'],
            'visa_expiry_date' => $validated['visa_expiry'],
            'entry_date' => $validated['entry_date'],
            'current_address' => $validated['current_address'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'phone_number' => $validated['phone'],
            'email' => $validated['email'],
            'emergency_contact_name' => $validated['emergency_contact']
        ]);

        return redirect()->route('foreigners.show', $foreigner)
            ->with('success', 'Data WNA berhasil diperbarui!');
    }

    public function destroy(Foreigner $foreigner)
    {
        if ($foreigner->photo) {
            \Storage::disk('public')->delete($foreigner->photo);
        }

        $foreigner->delete();

        return redirect()->route('foreigners.index')
            ->with('success', 'Data WNA berhasil dihapus!');
    }
}
