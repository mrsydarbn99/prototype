<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\CabinetTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    /**
     * Display a listing of the cabinets
     */
    public function index()
    {
        $cabinets = Cabinet::all();
        return view('cabinets.index', compact('cabinets'));
    }

    /**
     * Show cabinet details
     */
    public function show(Cabinet $cabinet)
    {
        $transactions = $cabinet->transactions()->latest()->take(10)->get();
        return view('cabinets.show', compact('cabinet', 'transactions'));
    }

    /**
     * Check in an item to a cabinet
     */
    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|string',
            'cabinet_number' => 'required|integer|min:1|max:30',
            'notes' => 'nullable|string'
        ]);

        $cabinet = Cabinet::where('cabinet_number', $validated['cabinet_number'])->first();
        
        if (!$cabinet) {
            return redirect()->back()->with('error', 'Cabinet not found.');
        }
        
        if ($cabinet->status === 'occupied') {
            return redirect()->back()->with('error', 'Cabinet is already occupied.');
        }

        // Update cabinet status
        $cabinet->update([
            'status' => 'occupied',
            'barcode' => $validated['barcode']
        ]);
        
        // Create transaction record
        CabinetTransaction::create([
            'cabinet_id' => $cabinet->id,
            'user_id' => Auth::id(),
            'barcode' => $validated['barcode'],
            'action' => 'check_in',
            'notes' => $validated['notes'] ?? null
        ]);
        
        return redirect()->route('cabinets.index')->with('success', 'Item successfully checked into cabinet.');
    }

    /**
     * Check out an item from a cabinet
     */
    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $cabinet = Cabinet::where('barcode', $validated['barcode'])->where('status', 'occupied')->first();
        
        if (!$cabinet) {
            return redirect()->back()->with('error', 'No occupied cabinet found with this barcode.');
        }
        
        // Create transaction record
        CabinetTransaction::create([
            'cabinet_id' => $cabinet->id,
            'user_id' => Auth::id(),
            'barcode' => $validated['barcode'],
            'action' => 'check_out',
            'notes' => $validated['notes'] ?? null
        ]);
        
        // Update cabinet status
        $cabinet->update([
            'status' => 'available',
            'barcode' => null
        ]);
        
        return redirect()->route('cabinets.index')->with('success', 'Item successfully checked out from cabinet.');
    }

    /**
     * Display check-in form
     */
    public function showCheckInForm()
    {
        $availableCabinets = Cabinet::available()->get();
        return view('cabinets.check-in', compact('availableCabinets'));
    }

    /**
     * Display check-out form
     */
    public function showCheckOutForm()
    {
        $occupiedCabinets = Cabinet::occupied()->get();
        return view('cabinets.check-out', compact('occupiedCabinets'));
    }

    /**
     * Show transaction history
     */
    public function transactions()
    {
        $transactions = CabinetTransaction::with(['cabinet', 'user'])->latest()->paginate(20);
        return view('cabinets.transactions', compact('transactions'));
    }
}