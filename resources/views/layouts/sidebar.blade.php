<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200" aria-hidden="true" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" x-cloak></div>
    <!-- Sidebar -->
    <div class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto -translate-x-64 lg:translate-x-0 transform h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out" id="sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false">
        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="flex items-center" href="/">
                <svg width="36" height="32" viewBox="0 0 36 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.857 3.18106L8.31234 28.3732C7.62442 29.5647 5.90463 29.5647 5.21672 28.3732L2.35445 23.4156L0.66535 20.49C0.346088 19.937 0.346088 19.2557 0.66535 18.7027L10.6587 1.39381C10.9779 0.840836 11.5679 0.500187 12.2065 0.500187H15.5847H21.3092C22.685 0.500187 23.5449 1.98956 22.857 3.18106Z" fill="url(#paint0_linear_1_104)" />
                    <path d="M19.3444 19.8497L22.9857 13.5736L24.022 11.7875C24.7133 10.596 23.8536 9.10334 22.4761 9.10334H13.121C11.7434 9.10334 10.8838 10.596 11.5751 11.7875L12.6113 13.5736L16.2526 19.8497C16.9414 21.0368 18.6557 21.0368 19.3444 19.8497Z" fill="#C4C4C4" />
                    <path d="M19.3444 19.8497L22.9857 13.5736L24.022 11.7875C24.7133 10.596 23.8536 9.10334 22.4761 9.10334H13.121C11.7434 9.10334 10.8838 10.596 11.5751 11.7875L12.6113 13.5736L16.2526 19.8497C16.9414 21.0368 18.6557 21.0368 19.3444 19.8497Z" fill="#0072B3" />
                    <path d="M12.7029 3.18053L27.2746 28.4343C27.9624 29.6264 29.6828 29.6264 30.3706 28.4343L33.2392 23.4629L34.9321 20.529C35.2511 19.9762 35.2511 19.2953 34.9321 18.7425L24.9219 1.39406C24.6027 0.84086 24.0125 0.50004 23.3738 0.50004H19.9894H14.2509C12.8753 0.50004 12.0154 1.98903 12.7029 3.18053Z" fill="#C4C4C4" />
                    <path d="M12.7029 3.18053L27.2746 28.4343C27.9624 29.6264 29.6828 29.6264 30.3706 28.4343L33.2392 23.4629L34.9321 20.529C35.2511 19.9762 35.2511 19.2953 34.9321 18.7425L24.9219 1.39406C24.6027 0.84086 24.0125 0.50004 23.3738 0.50004H19.9894H14.2509C12.8753 0.50004 12.0154 1.98903 12.7029 3.18053Z" fill="url(#paint1_linear_1_104)" />
                    <defs>
                        <linearGradient id="paint0_linear_1_104" x1="3.50211" y1="24.7282" x2="3.26488" y2="0.640204" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#0AB9C4" />
                            <stop offset="1" stop-color="#29D7ED" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_1_104" x1="18.3677" y1="0.500029" x2="32.4098" y2="25.762" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#29D7ED" />
                            <stop offset="1" stop-color="#0885CB" />
                        </linearGradient>
                    </defs>
                </svg>
                <span class="ml-4 font-semibold text-white text-lg">HitadsMedia</span>
            </a>
        </div>
        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <ul class="mt-3">
                    <!-- Dashboard -->
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" :class="page === 'Dashboard' && 'bg-slate-900'">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" :class="page === 'Dashboard' && 'hover:text-slate-200'" href="/dashboard">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 h-6 w-6" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#94a3b8" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <rect x="4" y="4" width="16" height="16" rx="1" />
                                    <line x1="4" y1="8" x2="20" y2="8" />
                                    <line x1="8" y1="4" x2="8" y2="8" />
                                </svg>
                                <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Situs</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
