<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Method สำหรับดึงข้อมูล store
    public function index()
    {
        $stores = Store::all();
        return view('frontend.index', compact('stores'));
    }

    // Method สำหรับดึงข้อมูล part ที่เชื่อมกับ store
    public function getPartsByStore($storeId)
    {
        // ดึงข้อมูล part ที่เชื่อมกับ store_id
        $parts = Part::where('store_id', $storeId)->get();

        // ส่งข้อมูล part กลับในรูปแบบ JSON
        return response()->json($parts);
    }
}
