<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->attributes->get('tenant');
        

        // Load tenant-specific data
        //$posts = $tenant->posts()->latest()->get();

        return view('tenant.dashboard', compact('tenant'));
    }
}
