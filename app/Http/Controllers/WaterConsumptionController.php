<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaterConsumption;

class WaterConsumptionController extends Controller
{
    public function index()
    {
        $latestStatus = WaterConsumption::latest()->first()->status ?? null;
        $waterConsumption = WaterConsumption::all();

        $lastTrueStatus = WaterConsumption::where('status', false)->latest()->first();
        $totalUnits = 0;

        if ($lastTrueStatus) {
            $totalUnits = WaterConsumption::where('id', '>', $lastTrueStatus->id)->sum('units_consumed');
        }

        return view('water.index', compact('waterConsumption', 'latestStatus', 'totalUnits'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $status = $request->input('status');

        $latestRecord = WaterConsumption::latest()->first();
        if ($latestRecord) {
            $latestRecord->update(['status' => $status]);

            if ($status == 0) {
                WaterConsumption::where('status', true)->update(['units_consumed' => 0]); // Reset units of true status records
            }
        }

        return redirect()->back()->with('message', 'Status updated successfully.');
    }

    // public function updateStatus(Request $request, $status)
    // {
    //     $latestRecord = WaterConsumption::latest()->first();
    //     $latestRecord->status = $status;
    //     $latestRecord->save();

    //     return redirect()->route('water.index');
    // }

    public function storeUnits(Request $request)
    {
        $request->validate([
            'units' => 'required|integer|min:0',
        ]);

    
        $latestRecord = WaterConsumption::latest()->first();
        $lastStatus = $latestRecord ? $latestRecord->status : false; // Default to false if no record exists

        if ($lastStatus) {
            $totalUnits = WaterConsumption::where('status', true)
                ->sum('units_consumed');
                
            $totalUnits += $request->input('units');

            
            WaterConsumption::create([
                'units_consumed' => $request->input('units'),
                'status' => $lastStatus,
            ]);
        } else {
            WaterConsumption::create([
                'units_consumed' => 0,
                'status' => $lastStatus,
            ]);
        }


        return response()->json(['message' => 'success', 'status'=> $lastStatus], 200);
    }

    public function getData()
    {
        $latestRecord = WaterConsumption::latest()->first();
        $totalUnits = 0;

        if ($latestRecord && $latestRecord->status) {
            $totalUnits = WaterConsumption::where('status', true)
                ->sum('units_consumed');
        }

        $waterConsumption = WaterConsumption::all();

        return response()->json([
            'latestStatus' => $latestRecord ? $latestRecord->status : false,
            'totalUnits' => $totalUnits,
            'consumptions' => $waterConsumption
        ]);
    }
}
