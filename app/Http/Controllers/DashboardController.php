<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
   /* To view dashboard*/ 
    public function showDashboard(Request $request )
    {
        $user = $request->session()->get('user');
        return view('dashboard', compact('user'));
    }
}