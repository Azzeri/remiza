<template>
    <div>
        <div class="min-h-screen bg-tertiary">
            <nav class="bg-secondary-100 border-b border-tertiary">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Strona główna
                                </BreezeNavLink>
                            </div>
                            <div v-if="$page.props.auth.user.privilege_id == 1 || $page.props.auth.user.privilege_id == 2" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('users.index')" :active="route().current('users.index')">
                                    Użytkownicy
                                </BreezeNavLink>
                            </div>
                            <div v-if="$page.props.auth.user.privilege_id == 1" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('fireBrigadeUnits.index')" :active="route().current('fireBrigadeUnits.index')">
                                    Jednostki
                                </BreezeNavLink>
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ml-10">
                                <!-- Settings Dropdown -->
                                <div class="relative">
                                    <BreezeDropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md ">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-text-100 bg-secondary-100 hover:text-text-200 focus:outline-none transition ease-in-out duration-150">
                                                    Sprzęt

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <BreezeDropdownLink :href="route('cathegories.index')" method="get" as="button">
                                                Kategorie
                                            </BreezeDropdownLink>
                                            <BreezeDropdownLink :href="route('items.index')" method="get" as="button">
                                                Przedmioty
                                            </BreezeDropdownLink>
                                            <BreezeDropdownLink :href="route('set.details',id=1)" method="get" as="button">
                                                Zestawy
                                            </BreezeDropdownLink>
                                        </template>
                                    </BreezeDropdown>
                                </div>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('scanner')" :active="route().current('scanner')">
                                    Skanuj
                                </BreezeNavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown :active="route().current('cathegories.index')">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-text-100 bg-secondary-100 hover:text-text-200 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Wyloguj
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-text-100 hover:text-text-200 hover:bg-tertiary focus:outline-none focus:bg-tertiary focus:text-text-100 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Strona główna
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink v-if="$page.props.auth.user.privilege_id == 1 || $page.props.auth.user.privilege_id == 2" :href="route('users.index')" :active="route().current('users.index')">
                            Użytkownicy
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('cathegories.index')" :active="route().current('cathegories.index')">
                            Kategorie
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('items.index')" :active="route().current('items.index')">
                            Sprzęt
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink v-if="$page.props.auth.user.privilege_id == 1" :href="route('fireBrigadeUnits.index')" :active="route().current('fireBrigadeUnits.index')">
                            Jednostki
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('set.details',id=1)" :active="route().current('set.details')">
                            Zestawy
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('scanner')" :active="route().current('scanner')">
                            Skanuj
                        </BreezeResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-text-100">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-text-200">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Wyloguj
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}
</script>
