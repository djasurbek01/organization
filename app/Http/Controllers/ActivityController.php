<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        return response()->json(Activity::all());
    }

    public function show($id)
    {
        return response()->json(Activity::findOrFail($id));
    }
}
