<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,operator',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.'
        ]);

        $data = $request->except(['password', 'password_confirmation', 'avatar']);
        $data['password'] = Hash::make($request->password);
        $data['email_verified_at'] = now();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->uploadAvatar($request->file('avatar'));
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function show(User $user)
    {
        $user->load('posts');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,operator',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $data = $request->except(['password', 'password_confirmation', 'avatar']);

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $this->uploadAvatar($request->file('avatar'));
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting current user
        if ($user->id === (auth()->user()?->id)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Prevent deleting if user has posts
        if ($user->posts()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User tidak dapat dihapus karena masih memiliki berita.');
        }

        // Delete avatar
        if (!empty($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === (auth()->user()?->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat mengubah status akun sendiri.'
            ], 422);
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => "Status user berhasil diubah menjadi {$newStatus}.",
            'status' => $newStatus
        ]);
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'password123';
        $user->update(['password' => Hash::make($newPassword)]);

        return response()->json([
            'success' => true,
            'message' => "Password berhasil direset menjadi: {$newPassword}"
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:users,id'
        ]);

        try {
            // Prevent action on current user
            $currentUserId = auth()->user()?->id;
            $ids = array_filter($request->ids, function($id) use ($currentUserId) {
                return $id != $currentUserId;
            });

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat melakukan aksi pada akun sendiri.'
                ], 422);
            }

            $users = User::whereIn('id', $ids);
            $count = $users->count();

            switch ($request->action) {
                case 'delete':
                    // Check if any user has posts
                    $usersWithPosts = $users->withCount('posts')->having('posts_count', '>', 0)->get();
                    if ($usersWithPosts->count() > 0) {
                        $names = $usersWithPosts->pluck('name')->join(', ');
                        return response()->json([
                            'success' => false,
                            'message' => "User berikut tidak dapat dihapus karena masih memiliki berita: {$names}"
                        ], 422);
                    }

                    foreach ($users->get() as $user) {
                        if (!empty($user->avatar)) {
                            Storage::disk('public')->delete($user->avatar);
                        }
                    }
                    $users->delete();
                    $message = "{$count} user berhasil dihapus.";
                    break;
                case 'activate':
                    $users->update(['status' => 'active']);
                    $message = "{$count} user berhasil diaktifkan.";
                    break;
                case 'deactivate':
                    $users->update(['status' => 'inactive']);
                    $message = "{$count} user berhasil dinonaktifkan.";
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan aksi bulk.'
            ], 500);
        }
    }

    private function uploadAvatar($file)
    {
        $filename = 'avatar_' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'avatars/' . $filename;

        // Resize and save avatar
        $image = Image::make($file)->fit(200, 200);
        Storage::disk('public')->put($path, $image->encode());

        return $path;
    }
}