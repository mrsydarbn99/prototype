<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\RefType;
use App\Models\RefLocation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
   public function checkin(Request $request)
    {
        $request->validate([
            'barcode' => 'required',
            'ref_type_id' => 'required|exists:ref_types,id',
            'ref_location_id' => 'required|exists:ref_locations,id',
        ]);

        $cabinet = Cabinet::where('ref_type_id', $request->ref_type_id)
            ->where('ref_location_id', $request->ref_location_id)
            ->where('is_occupied', false)
            ->first();

        if (!$cabinet) {
            return back()->with('error', 'No available cabinet found.');
        }

        $cabinet->update([
            'is_occupied' => true,
            'barcode' => $request->barcode,
        ]);

        Transaction::create([
            'cabinet_id' => $cabinet->id,
            'user_id' => Auth::user()->id,
            'barcode' => $request->barcode,
            'action' => 'check-in',
        ]);

        return back()->with('success', 'Check-in successful.');
    }

    public function checkinOne(Request $request, Cabinet $cabinet)
    {
        $request->validate([
            'barcode' => 'required|string|max:255',
        ]);

        // Example logic: update cabinet with barcode and mark as occupied
        if ($cabinet->is_occupied) {
            return back()->with('error', 'Cabinet not found or already checked out.');
        }

        $cabinet->barcode = $request->input('barcode');
        $cabinet->is_occupied = 1;  // mark as occupied
        $cabinet->save();

        Transaction::create([
            'cabinet_id' => $cabinet->id,
            'user_id' => Auth::user()->id,
            'barcode' => $request->barcode,
            'action' => 'check-out',
        ]);

        return redirect()->route('cabinet.index')->with('success', 'Check-in successful.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'barcode' => 'required',
        ]);

        $cabinet = Cabinet::where('barcode', $request->barcode)
            ->where('is_occupied', true)
            ->first();

        if (!$cabinet) {
            return back()->with('error', 'Cabinet not found or already checked out.');
        }

        $cabinet->update([
            'is_occupied' => false,
            'barcode' => null,
        ]);

        Transaction::create([
            'cabinet_id' => $cabinet->id,
            'user_id' => Auth::user()->id,
            'barcode' => $request->barcode,
            'action' => 'check-out',
        ]);

        return back()->with('success', 'Check-out successful for '. $request->barcode . ' at ' . $cabinet->cabinet_no . ' cabinet.');
    }

    public function checkoutOne($cabinet)
    {
        $oneCabinet = Cabinet::where('id', $cabinet)
            ->where('is_occupied', true)
            ->first();

        if (!$oneCabinet) {
            return back()->with('error', 'Cabinet not found or already checked out.');
        }

        $barcode = $oneCabinet->barcode;

        Transaction::create([
            'cabinet_id' => $oneCabinet->id,
            'user_id' => Auth::user()->id,
            'barcode' => $barcode,
            'action' => 'check-out',
        ]);

        $oneCabinet->update([
            'is_occupied' => false,
            'barcode' => null,
        ]);

        return back()->with('success', 'Check-out successful for '. $barcode . ' at ' . $oneCabinet->cabinet_no . ' cabinet.');
    }


    public function index(Request $request)
    {
        $userId = Auth::user()->id;

        // Cabinets occupied by this user with barcode not null
        $userParcels = Cabinet::where('is_occupied', true)
            ->whereNotNull('barcode')
            ->get();

        // All cabinets, paginated
        $cabinets = Cabinet::paginate(30);

        $refTypes = RefType::all();
        $refLocations = RefLocation::all();

        return view('cabinets.cabinetList', compact('userParcels', 'cabinets', 'refTypes', 'refLocations'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $location = $request->input('location');

        $cabinets = Cabinet::when($search, function ($query, $search) {
                // Group the search terms with OR for cabinet_no or barcode
                $query->where(function ($q) use ($search) {
                    $q->where('cabinet_no', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
                });
            })
            ->when($type, function ($query, $type) {
                // Filter by type if selected
                return $query->where('ref_type_id', $type);
            })
            ->when($location, function ($query, $location) {
                // Filter by location if selected
                return $query->where('ref_location_id', $location);
            })
            ->paginate(30);

        if ($request->ajax()) {
            $view = view('partials.cabinet_cards', compact('cabinets'))->render();
            return response()->json(['html' => $view]);
        }

        return view('cabinets.cabinetList', compact('cabinets'));
    }


}