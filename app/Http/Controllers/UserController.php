<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $users = User::with('role')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%")
                        ->orWhere('nama_lengkap', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('users.form', ['user' => new User, 'roles' => Role::orderBy('nama_role')->get()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['password'] = Hash::make($data['password']);
        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $this->storeProfilePhoto($request);
        } else {
            unset($data['foto_profil']);
        }
        User::create($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load('role');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.form', ['user' => $user, 'roles' => Role::orderBy('nama_role')->get()]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validatedData($request, $user);
        if (filled($data['password'] ?? null)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $newRole = Role::findOrFail($data['role_id']);
        $remainsActiveAdmin = $newRole->nama_role === 'Admin' && $request->boolean('is_active');
        if ($user->is_active && $user->role?->nama_role === 'Admin' && ! $remainsActiveAdmin) {
            $this->ensureAnotherActiveAdminExists($user);
        }

        if ($user->is(auth()->user()) && ! $remainsActiveAdmin) {
            throw ValidationException::withMessages([
                'role_id' => 'Anda tidak dapat menonaktifkan atau mengubah level akun sendiri.',
            ]);
        }

        $user->update($data);
        if ($user->mahasiswa) {
            $user->mahasiswa->update(['nama' => $user->nama_lengkap, 'nim' => $user->username]);
        }

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            throw ValidationException::withMessages([
                'user' => 'Anda tidak dapat menghapus akun yang sedang digunakan.',
            ]);
        }

        if ($user->is_active && $user->role?->nama_role === 'Admin') {
            $this->ensureAnotherActiveAdminExists($user);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    private function validatedData(Request $request, ?User $user = null): array
    {
        $rules = [
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('t003_users', 'username')->ignore($user?->id)],
            'role_id' => ['required', 'integer', 'exists:t003_roles,id'],
            'is_active' => ['required', 'boolean'],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
            'foto_profil' => ['nullable', 'image', 'max:2048'],
        ];

        $data = $request->validate($rules);
        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $this->storeProfilePhoto($request);
        } else {
            unset($data['foto_profil']);
        }

        return $data;
    }

    private function ensureAnotherActiveAdminExists(User $user): void
    {
        $activeAdmins = User::where('is_active', true)
            ->whereHas('role', fn ($query) => $query->where('nama_role', 'Admin'))
            ->where('id', '!=', $user->id)
            ->count();

        if ($activeAdmins === 0) {
            throw ValidationException::withMessages([
                'role_id' => 'Sistem harus memiliki setidaknya satu admin aktif.',
            ]);
        }
    }

    private function storeProfilePhoto(Request $request): string
    {
        $directory = public_path('uploads/profil');
        File::ensureDirectoryExists($directory);
        $filename = 'user-'.bin2hex(random_bytes(10)).'.'.$request->file('foto_profil')->extension();
        $request->file('foto_profil')->move($directory, $filename);

        return 'uploads/profil/'.$filename;
    }
}
