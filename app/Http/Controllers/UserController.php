<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Roles = Role::all();
        $Users = User::all();
        $Customers = Customer::all();

        return view('dashboard.pages.user.index', compact('Users','Roles','Customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
            'customer' => 'required',
        ],[
            'name.required' => 'Ad & Soyad boş bırakılamaz.',
            'email.required' => 'E-Posta adresi boş bırakılamaz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılmakta.',
            'password.required' => 'Şifre boş bırakılamaz',
            'role.required' => 'Rol seçimi yapmalısınız.',
            'customer.required' => 'Müşteri seçimi yapmalısınız.',
        ]);


        $user = User::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'CustNo' => $request->customer,
        ]);

        $Role = Role::find($request->role);

        $user->assignRole($Role);


        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
