<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $admins = Admin::when($search, fn ($query) => $query->where(function ($nested) use ($search) {
            $nested->where('nama', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('admins', 'search'));
    }

    public function create(): View
    {
        return view('admin.users.form', ['admin' => new Admin()]);
    }

    public function store(AdminRequest $request): RedirectResponse
    {
        Admin::create($request->validated());

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(Admin $admin): View
    {
        return view('admin.users.form', compact('admin'));
    }

    public function update(AdminRequest $request, Admin $admin): RedirectResponse
    {
        $data = $request->validated();

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Admin $admin): RedirectResponse
    {
        if (auth('admin')->id() === $admin->id) {
            return back()->with('error', 'Pengguna yang sedang digunakan tidak bisa dihapus.');
        }

        $admin->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
