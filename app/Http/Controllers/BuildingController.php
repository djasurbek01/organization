<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
    public function index()
    {
        return response()->json(Building::all());
    }
    
    public function show($id)
    {
        return response()->json(Building::findOrFail($id));
    }
}
