<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where(
                'role',
                $request->role
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'is_active',
                $request->status === 'aktif'
            );
        }

        $users = $query
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view(
            'users.index',
            compact('users')
        );
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'username' => [
                    'required',
                    'string',
                    'max:100',
                    'alpha_dash',
                    'unique:users,username',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'role' => [
                    'required',
                    Rule::in([
                        'UPR',
                        'UMR',
                        'UPI',
                    ]),
                ],

                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],
            ],
            [
                'username.alpha_dash' =>
                    'Username hanya boleh berisi huruf, angka, tanda minus, dan garis bawah.',

                'username.unique' =>
                    'Username sudah digunakan oleh pengguna lain.',

                'email.unique' =>
                    'Email sudah digunakan oleh pengguna lain.',

                'password.confirmed' =>
                    'Konfirmasi password tidak sesuai.',
            ]
        );

        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => $data['password'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna baru berhasil ditambahkan.'
            );
    }

    public function edit(User $user)
    {
        return view(
            'users.edit',
            compact('user')
        );
    }

    public function update(
        Request $request,
        User $user
    ) {
        $data = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'username' => [
                    'required',
                    'string',
                    'max:100',
                    'alpha_dash',
                    Rule::unique(
                        'users',
                        'username'
                    )->ignore($user->id),
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique(
                        'users',
                        'email'
                    )->ignore($user->id),
                ],

                'role' => [
                    'required',
                    Rule::in([
                        'UPR',
                        'UMR',
                        'UPI',
                    ]),
                ],

                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'confirmed',
                ],
            ],
            [
                'username.alpha_dash' =>
                    'Username hanya boleh berisi huruf, angka, tanda minus, dan garis bawah.',

                'username.unique' =>
                    'Username sudah digunakan oleh pengguna lain.',

                'email.unique' =>
                    'Email sudah digunakan oleh pengguna lain.',

                'password.confirmed' =>
                    'Konfirmasi password tidak sesuai.',
            ]
        );

        /*
         * Akun UPI yang sedang digunakan tidak boleh
         * mengubah role-nya sendiri.
         */
        if ($user->id === Auth::id()) {
            $data['role'] = $user->role;
        }

        $updateData = [
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] =
                $data['password'];
        }

        $user->update($updateData);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Data pengguna berhasil diperbarui.'
            );
    }

    public function toggleStatus(User $user)
    {
        /*
         * Pengguna yang sedang login tidak boleh
         * menonaktifkan akunnya sendiri.
         */
        if ($user->id === Auth::id()) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Anda tidak dapat menonaktifkan akun sendiri.'
                );
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $pesan = $user->is_active
            ? 'Akun pengguna berhasil diaktifkan.'
            : 'Akun pengguna berhasil dinonaktifkan.';

        return redirect()
            ->route('users.index')
            ->with('success', $pesan);
    }
}