<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    public function index()
    {
        return view('parcels.parcelList');
    }

    public function getData()
    {
        // Eager load user and cabinet to avoid N+1
        $parcel = Transaction::with(['user', 'cabinet'])
                    ->select('user_id', 'cabinet_id', 'barcode', 'action', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Format data to include user name and cabinet number for DataTable
        $data = $parcel->map(function ($item) {
            return [
                'user_name' => $item->user->name ?? 'N/A',
                'cabinet_no' => $item->cabinet->cabinet_no ?? 'N/A',
                'barcode' => $item->barcode,
                'action' => $item->action,
                'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json(['data' => $data]);
    }

}
