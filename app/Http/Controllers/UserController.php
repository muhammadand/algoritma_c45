<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function register()
    {
        $data['title'] = 'Register';
        return view('user/register', $data);
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:tb_user',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            'role' => 'required|in:admin,marketing,supervisor',
        ]);

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration success. Please login!');
    }


    public function login()
    {
        $data['title'] = 'Login';
        return view('user/login', $data);
    }

    
    public function login_action(Request $request)
    {
        // Validasi input username dan password
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        // Ambil kredensial dari form
        $credentials = ['username' => $request->username, 'password' => $request->password];
    
        // Cek jika login berhasil
        if (Auth::attempt($credentials)) {
            $user = Auth::user();  // Ambil pengguna yang sedang login
    
            // Switch-case untuk memeriksa role user
            switch ($user->role) {
                case 'admin':
                    // Jika role admin, redirect ke dashboard admin
                    session()->put('role', 'admin');  // Menyimpan role di session
                    $request->session()->regenerate();
                    return redirect()->route('admin.index');
    
                case 'supervisor':
                    // Jika role owner, redirect ke dashboard owner
                    session()->put('role', 'owner');  // Menyimpan role di session
                    $request->session()->regenerate();
                    return redirect()->route('data_prediksi.laporan');
    
                case 'marketing':
                    // Jika role kasir, redirect ke halaman kasir
                    session()->put('role', 'kasir');  // Menyimpan role di session
                    $request->session()->regenerate();
                    return redirect()->route('konsumen.index');
                    
    
                default:
                    // Jika role tidak dikenali, logout dan beri pesan error
                    Auth::logout();
                    return back()->withErrors([
                        'role' => 'You do not have permission to access this area',
                    ]);
            }
        }
    
        // Jika login gagal, tentukan apakah username atau password yang salah
        $user = User::where('username', $request->username)->first();
    
        if (!$user) {
            // Jika username tidak ditemukan
            return back()->withErrors([
                'username' => 'Username tidak ditemukan',
            ]);
        } else {
            // Jika password salah
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah',
            ]);
        }
    }
    
    
    

    public function password()
    {
        $data['title'] = 'Change Password';
        return view('user/password', $data);
    }

    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return back()->with('success', 'Password changed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


  // Fungsi Menampilkan Daftar Pengguna
  public function index()
  {
      $users = User::all(); // Mengambil semua data pengguna
      return view('user.index', compact('users')); // Menampilkan ke view 'user.index'
  }

  // Fungsi Edit Pengguna
  public function edit($id)
  {
      $user = User::findOrFail($id); // Menemukan pengguna berdasarkan ID
      return view('user.edit', compact('user')); // Menampilkan view 'user.edit' dengan data pengguna
  }

  public function update(Request $request, $id)
  {
      // Validasi input
      $request->validate([
          'name' => 'required|string|max:255',
          'username' => 'required|string|max:255|unique:tb_user,username,' . $id . ',user_id',
          'role' => 'required|in:admin,user',
          'password' => 'nullable|string|min:8|confirmed', // Menambahkan konfirmasi password
      ]);
  
      // Temukan pengguna berdasarkan ID
      $user = User::findOrFail($id);
  
      // Update data pengguna
      $user->name = $request->name;
      $user->username = $request->username;
      $user->role = $request->role;
  
      // Jika password diubah, hash password baru
      if ($request->filled('password')) {
          $user->password = Hash::make($request->password);
      }
  
      // Simpan perubahan
      $user->save();
  
      // Redirect ke halaman pengguna dengan pesan sukses
      return redirect()->route('user.index')->with('success', 'User updated successfully');
  }
  
  // Tampilkan form tambah user
  public function create()
  {
      return view('user.create');
  }
  public function store(Request $request)
  {
      $request->validate([
          'name' => 'required|string|max:255',
          'username' => 'required|string|email|unique:tb_user,username',
          'role' => 'required|string|in:marketing,admin,supervisor',
          'password' => 'required|string|min:6|confirmed'
      ]);
  
      User::create([
          'name' => $request->name,
          'username' => $request->username,
          'role' => $request->role,
          'password' => Hash::make($request->password),
      ]);
  
      return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
  }
  
  

  


  // Fungsi Hapus Pengguna
  public function destroy($id)
  {
      $user = User::findOrFail($id);
      $user->delete(); // Menghapus pengguna berdasarkan ID

      return redirect()->route('user.index')->with('success', 'User deleted successfully');
  }
}
