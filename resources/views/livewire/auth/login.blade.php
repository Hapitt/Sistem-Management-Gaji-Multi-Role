<?php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Enums\UserRole;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $user = $this->validateCredentials();

        if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
            Session::put([
                'login.id' => $user->getKey(),
                'login.remember' => $this->remember,
            ]);

            $this->redirect(route('two-factor.login'), navigate: true);

            return;
        }

        Auth::login($user, $this->remember);
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $logged = Auth::user();

        if ($logged && $logged->role === UserRole::Admin) {
             $this->redirect(route('admin.dashboard'), navigate: true);
            return;
        }

        if ($logged && $logged->role === UserRole::Manager) {
            return redirect()->route('manager.dashboard')->with('success','Logged in successfully.');
        }

        if ($logged && $logged->role === UserRole::Karyawan) {
            return redirect()->route('karyawan.dashboard')->with('success','Logged in successfully.');
        }

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $user;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-8 max-w-md mx-auto">
    
    <!-- Header dengan Icon -->
    <div class="text-center space-y-4">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/30 dark:shadow-blue-500/20">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        
        <x-auth-header 
            :title="__('Log in to your account')" 
            :description="__('Enter your email and password below to log in')" 
        />
    </div>

    <!-- Session Status dengan styling lebih baik -->
    @if(session('status'))
        <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
            <x-auth-session-status class="text-center text-green-800 dark:text-green-200" :status="session('status')" />
        </div>
    @endif

    <!-- Form Card -->
    <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 shadow-xl border border-zinc-200 dark:border-zinc-800">
        
        <!-- Gradient Top Border -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>
        
        <div class="p-8">
            <form method="POST" wire:submit="login" class="flex flex-col gap-5">
                
                <!-- Email Address dengan icon -->
                <div class="space-y-2">
                    <flux:input
                        wire:model="email"
                        :label="__('Email address')"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="email@example.com"
                        class="transition-all duration-200 hover:border-blue-400 focus:border-blue-500"
                    />
                </div>

                <!-- Password dengan forgot password link -->
                <div class="relative space-y-2">
                    <flux:input
                        wire:model="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        :placeholder="__('Password')"
                        viewable
                        class="transition-all duration-200 hover:border-blue-400 focus:border-blue-500"
                    />

                    @if (Route::has('password.request'))
                        <flux:link 
                            class="absolute top-0 right-0 text-xs font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200" 
                            :href="route('password.request')" 
                            wire:navigate
                        >
                            {{ __('Forgot your password?') }}
                        </flux:link>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="pt-1">
                    <flux:checkbox 
                        wire:model="remember" 
                        :label="__('Remember me for 30 days')" 
                        class="transition-all duration-200"
                    />
                </div>

                <!-- Submit Button dengan icon -->
                <div class="pt-2">
                    <flux:button 
                        variant="primary" 
                        type="submit" 
                        class="w-full h-12 text-base font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]" 
                        data-test="login-button"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>{{ __('Log in') }}</span>
                        </span>
                    </flux:button>
                </div>
            </form>
        </div>
    </div>

    <!-- Register Link -->
    @if (Route::has('register'))
        <div class="relative">
            <!-- Divider -->
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-zinc-200 dark:border-zinc-800"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="px-3 bg-zinc-50 dark:bg-zinc-950 text-zinc-500 dark:text-zinc-500 font-medium">
                    {{ __('New here?') }}
                </span>
            </div>
        </div>

        <div class="text-center space-y-3">
            <div class="text-sm text-zinc-600 dark:text-zinc-400">
                <span>{{ __("Don't have an account?") }}</span>
            </div>
            <flux:button 
                variant="ghost"
                :href="route('register')" 
                wire:navigate
                class="w-full h-11 border-2 border-zinc-200 dark:border-zinc-800 hover:border-blue-500 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-all duration-200"
            >
                <span class="flex items-center justify-center gap-2 font-semibold text-zinc-700 dark:text-zinc-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>{{ __('Create new account') }}</span>
                </span>
            </flux:button>
        </div>
    @endif

    <!-- Security Badge -->
    <div class="flex items-center justify-center gap-2 py-3 px-4 mx-auto rounded-full bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
        <svg class="w-4 h-4 text-green-600 dark:text-green-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">
            {{ __('Protected by 256-bit SSL encryption') }}
        </span>
    </div>
</div>