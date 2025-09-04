<nav class="bg-gray-800 fixed top-0 w-full z-50" x-data="{ mobileMenuOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img src="https://iconape.com/wp-content/png_logo_vector/kabupaten-lamongan-logo.png"
                        alt="Your Company" class="size-8" />
                </div>
                <div class="hidden md:block position">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                        @if (auth()->check() && auth()->user()->hasRole('admin'))
                            <x-nav-link href="/kategori" :active="request()->is('kategori')">List Category</x-nav-link>
                            <x-nav-link href="/buku" :active="request()->is('buku')">List Book</x-nav-link>
                            <x-nav-link href="/peminjaman" :active="request()->is('peminjaman')">List Borrowing</x-nav-link>
                            <x-nav-link href="/daftar" :active="request()->is('daftar')">Member List</x-nav-link>
                        @endif
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">

                    @auth
                        <div class="relative ml-3" x-data="{ isOpen: false }">
                            <button @click="isOpen = !isOpen"
                                class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                @if (auth()->user()->image)
                                    <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="User Avatar"
                                        class="size-8 rounded-full outline -outline-offset-1 outline-white/10 object-cover" />
                                @else
                                    <img src="https://d1fu0fj548oqtj.cloudfront.net/media/2023/02/FS_StaffPicCirlcePt2_150223_TempProfilePic.png"
                                        alt="User Avatar"
                                        class="size-8 rounded-full outline -outline-offset-1 outline-white/10" />
                                @endif
                            </button>

                            <div x-show="isOpen" x-transition @click.away="isOpen = false"
                                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    <p class="font-semibold truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </a>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white">Sign
                                in</a>
                            <a href="{{ route('register') }}"
                                class="text-sm font-medium text-gray-300 hover:text-white">Register</a>
                        </div>
                    @endauth

                </div>
            </div>
            <div class="flex md:hidden justify-end">
                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!mobileMenuOpen" x-transition:enter="transition ease-in duration-75"
                        x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-out duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-75"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="block size-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-transition:enter="transition ease-in duration-75"
                        x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-out duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-75"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="block size-6">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-100 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="block md:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                @if (auth()->check() && auth()->user()->hasRole('admin'))
                    <x-nav-link href="/kategori" :active="request()->is('kategori')">List Category</x-nav-link>
                    <x-nav-link href="/buku" :active="request()->is('buku')">List Book</x-nav-link>
                    <x-nav-link href="/peminjaman" :active="request()->is('peminjaman')">List Borrowing</x-nav-link>
                    <x-nav-link href="/daftar" :active="request()->is('daftar')">Member List</x-nav-link>
                @endif
            </div>
            <div class="border-t border-gray-200 pt-4 pb-3">
                <div class="flex items-center px-5">
                    @auth
                        <div class="shrink-0">
                            @if (auth()->user()->image)
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="User Avatar"
                                    class="size-10 rounded-full outline -outline-offset-1 outline-white/10 object-cover" />
                            @else
                                <img src="https://d1fu0fj548oqtj.cloudfront.net/media/2023/02/FS_StaffPicCirlcePt2_150223_TempProfilePic.png"
                                    alt="User Avatar"
                                    class="size-10 rounded-full outline -outline-offset-1 outline-white/10" />
                            @endif
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                        </div>
                    @endauth
                </div>
                <div class="mt-3 space-y-1 px-2">
                    @auth
                        <a href="{{ route('profile.edit') }}"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100">
                                Sign out
                            </a>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100">Sign
                            in</a>
                        <a href="{{ route('register') }}"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100">Register</a>
                    @endauth
                </div>
            </div>
        </div>
</nav>
