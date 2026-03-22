<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(20);
        return view('backend.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('orders.items.product');
        return view('backend.users.show', compact('user'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $user->update(['status' => $request->status ?? true]);
        return redirect()->back()->with('success', 'User status updated successfully');
    }
}
