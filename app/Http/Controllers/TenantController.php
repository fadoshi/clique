<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function showRegistrationForm()
    {
        return view('tenants.register');
    }

    public function register(Request $request)
    {

        //dd($request->all());
        // Validate tenant and admin data
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:tenants,slug',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|digits:10',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the tenant
        $tenant = Tenant::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Create the tenant's admin user
        $adminUser = $tenant->users()->create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($request->password),
            'admin' => true,
        ]);
        /* $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tenant_id' => $tenant->id,
        ]); */

        // Log the tenant admin in
        //Auth::login($user);

        // Redirect to the tenant's dashboard
        return redirect()->route('tenants.login', ['tenant' => $tenant->slug])
        ->with('success', 'Registration successful! Please log in.');
    }

    public function showLoginForm($tenant)
    {
        return view('tenants.login', compact('tenant'));
    }

    public function login(Request $request, $tenant)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $tenantModel = Tenant::where('slug', $tenant)->firstOrFail();

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'tenant_id' => $tenantModel->id,
        ])) {
            return redirect()->route('tenants.dashboard', ['tenant' => $tenant]);
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function index(Tenant $tenant)
    {
        dd($tenant);
        //$tenantModel = Tenant::where('slug', $tenant)->firstOrFail();
        $users = $tenant->users;
        //$posts = $tenantModel->posts;

        return view('tenants.dashboard', compact('tenantModel', 'users'));
    }

}
