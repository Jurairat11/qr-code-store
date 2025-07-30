<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function getPartsByStore($storeId)
    {
        $parts = Part::where('store_id', $storeId)->get(); // ดึงข้อมูล part ที่เชื่อมกับ store_id
        return response()->json($parts);
    }
}
