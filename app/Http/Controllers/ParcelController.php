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
        $parcel = Transaction::with(['user', 'cabinet'])
                    ->select('user_id', 'cabinet_id', 'barcode', 'action', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->get();

        $data = $parcel->map(function ($item) {
            return [
                'user_name' => $item->user->name ?? 'N/A',
                'cabinet_no' => $item->cabinet->cabinet_no ?? 'N/A',
                'location' => $item->cabinet->location->name ?? 'N/A',
                'barcode' => $item->barcode,
                'action' => $item->action,
                'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json(['data' => $data]);
    }

}
