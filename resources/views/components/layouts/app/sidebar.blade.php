<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="w-full flex items-center gap-2" wire:navigate>
            <img src="{{ asset('images/logo.png') }}" class="size-18 dark:hidden" />
            <img src="{{ asset('images/white.png') }}" class="hidden size-18 dark:block" />
            <span class="text-5xl font-bold text-gray-600 dark:text-gray-200">
                FLMS
            </span>
        </a>

        {{-- <span class="text-muted text-xs font-medium dark:text-gray-400">
            Fishpond Lessee Managment System
        </span> --}}


        <flux:navlist variant="outline">
            <flux:navlist.group heading="Main Menu" class="grid">

                <flux:navlist.item icon="squares-2x2" :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')" wire:navigate>
                    Dashboard
                </flux:navlist.item>

                <flux:navlist.item icon="users" :href="route('lessee.index')" :current="request()->routeIs('lessee.*')"
                    wire:navigate>
                    Lessees
                </flux:navlist.item>

                <flux:navlist.item icon="check-badge" :href="route('status.index')"
                    :current="request()->routeIs('status.*')" wire:navigate>
                    Property Status
                </flux:navlist.item>

                <flux:navlist.item icon="map-pin" :href="route('area.index')" :current="request()->routeIs('area.*')"
                    wire:navigate>
                    Areas
                </flux:navlist.item>

            </flux:navlist.group>
        </flux:navlist>

        <flux:navlist variant="outline">
            <flux:navlist.group heading="Reports" class="grid">

                <flux:navlist.item icon="clipboard-document-check" :href="route('inspection.report')"
                    :current="request()->routeIs('inspection.*')" wire:navigate>
                    Inspection Reports
                </flux:navlist.item>

                <flux:navlist.item icon="document-chart-bar" :href="route('annual.report')"
                    :current="request()->routeIs('annual.*')" wire:navigate>
                    Annual Reports
                </flux:navlist.item>

            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />


        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>



    {{ $slot }}

    @fluxScripts
</body>

</html>