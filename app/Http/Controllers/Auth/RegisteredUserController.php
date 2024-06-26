<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password; 
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Verified;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $this->authorize('create', User::class);

        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_super_admin' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
            'password' => Hash::make(Str::random(16)),
            'is_super_admin' => $request->is_super_admin,
        ]);

        event(new Registered($user));

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return redirect(route('dashboard', absolute: false));
    }
}
