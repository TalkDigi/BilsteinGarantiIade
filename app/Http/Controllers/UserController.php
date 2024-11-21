<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Branch;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Roles = Role::all();
        $Users = User::where('status', true)->get();

        $Customers = Customer::all();

        return view('dashboard.pages.user.index', compact('Users', 'Roles', 'Customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function profile()
    {
        // Mevcut kullanıcıyı al
        $user = auth()->user();
        return view('dashboard.pages.user.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        if (!password_verify($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Eski şifre yanlış.']);
        }

        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.required' => 'Yeni şifre alanı boş bırakılamaz.',
            'new_password.min' => 'Yeni şifre en az 6 karakter olmalıdır.',
            'new_password.confirmed' => 'Yeni şifre tekrarı eşleşmiyor.',
        ]);

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Şifreniz başarıyla güncellendi.');
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
        ], [
            'name.required' => 'Ad & Soyad boş bırakılamaz.',
            'email.required' => 'E-Posta adresi boş bırakılamaz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılmakta.',
            'password.required' => 'Şifre boş bırakılamaz',
            'role.required' => 'Rol seçimi yapmalısınız.',
        ]);


        try {

            $values = [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ];



            if (isset($request->customer) && $request->customer != null) {
                $values['CustNo'] = $request->customer;
            }

            if (isset($request->branch) && $request->branch != null) {
                $values['BranchNo'] = $request->branch;
            }

            $user = User::create($values);

            $Role = Role::find($request->role);

            if($request->role == 3) {
                $user->assignRole([$Role, Role::find(2)]);
            } else {
                $user->assignRole($Role);
            }

        } catch (\Exception $e) {

            dd($e);

        }


        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $User = User::where('uuid', $id)->first();

        //check if user's customer has branches
        $branches = Branch::where('CustNo', $User->CustNo)->get();

        $Role = $User->roles;

        return response()->json(['user' => $User, 'role' => $Role, 'branches' => $branches]);
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
    public function update(Request $request)
    {

        //uuid ile kullanıcı var mı kontrol et. yoksa hata dön
        $User = User::where('uuid', $request->uuid)->first();
        if (!$User) {
            return redirect()->route('user.index')->with('error', 'Kullanıcı bulunamadı');
        }

        //eğer kullanıcı varsa
        //şifre var mı kontrol et. varsa güncelle yoksa eski şifre ile aynı kalır. kalan kısımları güncelle
        if (isset($request->password) && $request->password != null) {
            $User->password = bcrypt($request->password);
        }
        $User->name = $request->name;
        $User->email = $request->email;
        if (isset($request->customer) && $request->customer != null) {
            $User->CustNo = $request->customer;
        }

        if (isset($request->branch)) {
            $User->BranchNo = $request->branch;
        }

        if ($request->branch == null) {
            $User->BranchNo = null;
        }

        $User->save();

        //kullanıcının rolünü güncelle
        $Role = Role::find($request->role);
        //remove all roles from user
        $User->roles()->detach();
        
        if($request->role == 3) {
            // Hem 3 hem 2 rolünü ata
            $User->assignRole($Role); // Role 3
            $User->assignRole(Role::find(2)); // Role 2
        } else {
            // Sadece seçilen rolü ata
            // Önce mevcut rolleri temizle
            $User->syncRoles([]);
            // Yeni rolü ata
            $User->assignRole($Role);
        }

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // UUID ile kullanıcıyı bul
        $user = User::where('uuid', $id)->first();

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Kullanıcı bulunamadı');
        }

        // Kullanıcıyı yumuşak sil
        $user->status = false;
        $user->save();

        // Başarı mesajı ile sayfaya yönlendir
        return redirect()->route('user.index')->with('success', 'Kullanıcı başarıyla silindi');
    }


    public function branch_update(Request $request)
    {
        $user = auth()->user();
        $branch = Branch::where('BranchID', $request->branch_id)->first();
        if($branch) {
            $user->BranchNo = $request->branch_id;
            $user->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
        
    }
}
