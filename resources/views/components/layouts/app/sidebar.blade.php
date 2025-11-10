<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white light:bg-zinc-800">
        <!-- UBAH BARIS INI: ganti zinc dengan blue -->
        <flux:sidebar sticky stashable class="border-e border-blue-200 bg-blue-50 dark:border-blue-700 dark:bg-blue-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('admin.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <!-- Dashboard Group -->
                <flux:navlist.group :heading="__('Dashboard')" class="grid">
                    @if (auth()->user()->role === App\Enums\UserRole::Admin)
                        <flux:navlist.item 
                            icon="home" 
                            :href="route('admin.dashboard')" 
                            :current="request()->routeIs('admin.dashboard')" 
                            wire:navigate>
                            {{ __('Dashboard Admin') }}
                        </flux:navlist.item>
                    @endif

                    @if (auth()->user()->role === App\Enums\UserRole::Manager)
                        <flux:navlist.item 
                            icon="home" 
                            :href="route('manager.dashboard')" 
                            :current="request()->routeIs('manager.dashboard')" 
                            wire:navigate>
                            {{ __('Dashboard Manager') }}
                        </flux:navlist.item>
                    @endif

                    @if (auth()->user()->role === App\Enums\UserRole::Karyawan)
                        <flux:navlist.item 
                            icon="home" 
                            :href="route('karyawan.dashboard')" 
                            :current="request()->routeIs('karyawan.dashboard')" 
                            wire:navigate>
                            {{ __('Dashboard Karyawan') }}
                        </flux:navlist.item>
                    @endif
                </flux:navlist.group>

                <!-- Menu Admin -->
                @if (auth()->user()->role === App\Enums\UserRole::Admin)
                <flux:navlist.group :heading="__('Manajemen Data')" class="grid">
                    <flux:navlist.item 
                        icon="users" 
                        :href="route('admin.karyawan.index')" 
                        :current="request()->routeIs('admin.karyawan.*')" 
                        wire:navigate>
                        {{ __('Data Karyawan') }}
                    </flux:navlist.item>
                    
                    <flux:navlist.item 
                        icon="briefcase" 
                        :href="route('admin.jabatan.index')" 
                        :current="request()->routeIs('admin.jabatan.*')" 
                        wire:navigate>
                        {{ __('Jabatan') }}
                    </flux:navlist.item>
                    
                    <flux:navlist.item 
                        icon="star" 
                        :href="route('admin.rating.index')" 
                        :current="request()->routeIs('admin.rating.*')" 
                        wire:navigate>
                        {{ __('Rating Kinerja') }}
                    </flux:navlist.item>
                    
                    <flux:navlist.item 
                        icon="clock" 
                        :href="route('admin.lembur.index')" 
                        :current="request()->routeIs('admin.lembur.*')" 
                        wire:navigate>
                        {{ __('Tarif Lembur') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Penggajian')" class="grid">
                    <flux:navlist.item 
                        icon="currency-dollar" 
                        :href="route('admin.gaji.index')" 
                        :current="request()->routeIs('admin.gaji.*')" 
                        wire:navigate>
                        {{ __('Data Gaji') }}
                    </flux:navlist.item>
                    
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Manajemen User')" class="grid">
                    <flux:navlist.item 
                        icon="user-group" 
                        :href="route('admin.users.index')" 
                        :current="request()->routeIs('admin.users.*')" 
                        wire:navigate>
                        {{ __('Users') }}
                    </flux:navlist.item>
                </flux:navlist.group>
                @endif

                <!-- Menu MANAGER -->
                @if (auth()->user()->role === App\Enums\UserRole::Manager)
                <flux:navlist.group :heading="__('Data Master')" class="grid">
                    <flux:navlist.item 
                        icon="users" 
                        :href="route('manager.karyawan.index')" 
                        :current="request()->routeIs('manager.karyawan.*')" 
                        wire:navigate>
                        {{ __('Data Karyawan') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="briefcase" 
                        :href="route('manager.jabatan.index')" 
                        :current="request()->routeIs('manager.jabatan.*')" 
                        wire:navigate>
                        {{ __('Jabatan') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="star" 
                        :href="route('manager.rating.index')" 
                        :current="request()->routeIs('manager.rating.*')" 
                        wire:navigate>
                        {{ __('Rating Kinerja') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="clock" 
                        :href="route('manager.lembur.index')" 
                        :current="request()->routeIs('manager.lembur.*')" 
                        wire:navigate>
                        {{ __('Tarif Lembur') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="currency-dollar" 
                        :href="route('manager.gaji.index')" 
                        :current="request()->routeIs('manager.gaji.*')" 
                        wire:navigate>
                        {{ __('Data Gaji Karyawan') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="currency-dollar" 
                        :href="route('manager.gaji-saya.index')" 
                        :current="request()->routeIs('manager.gaji-saya.*')" 
                        wire:navigate>
                        {{ __('Data Gaji Saya') }}
                    </flux:navlist.item>
                    
                </flux:navlist.group>
                @endif

                <!-- Menu Karyawan -->
                @if (auth()->user()->role === App\Enums\UserRole::Karyawan)
                <flux:navlist.group :heading="__('Menu Saya')" class="grid">
                    <flux:navlist.item 
                        icon="user" 
                        :href="route('karyawan.karyawan.index')" 
                        :current="request()->routeIs('karyawan.karyawan.*')" 
                        wire:navigate>
                        {{ __('Daftar Karyawan') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="briefcase" 
                        :href="route('karyawan.jabatan.index')" 
                        :current="request()->routeIs('karyawan.jabatan.*')"
                        wire:navigate>
                        {{ __('Daftar Jabatan') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="star" 
                        :href="route('karyawan.rating.index')" 
                        :current="request()->routeIs('karyawan.rating.*')" 
                        wire:navigate>
                        {{ __('Rating Kinerja') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="currency-dollar" 
                        :href="route('karyawan.gaji.index')" 
                        :current="request()->routeIs('karyawan.gaji.*')" 
                        wire:navigate>
                        {{ __('Daftar Gaji Saya') }}
                    </flux:navlist.item>

                </flux:navlist.group>
                @endif

            </flux:navlist>

            <flux:spacer />

            <!-- User dropdown -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    :description="auth()->user()->role->value"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-blue-200 text-black dark:bg-blue-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    <span class="truncate text-xs text-gray-500 capitalize">{{ auth()->user()->role->value }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Keluar') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Header Mobile -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile 
                    :initials="auth()->user()->initials()" 
                    :description="auth()->user()->role->value"
                    icon-trailing="chevron-down" 
                />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-blue-200 text-black dark:bg-blue-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    <span class="truncate text-xs text-gray-500 capitalize">{{ auth()->user()->role->value }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Pengaturan') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Keluar') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>