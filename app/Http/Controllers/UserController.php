<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     */
    public function index(): Response
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403);
        }

        return Inertia::render('Users/Index', [
            'users' => User::latest()->get(),
        ]);
    }
}
