<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isMobileMenuOpen = ref(false);

const navigation = [
  { name: 'Browse Katalog', href: '/catalog' },
  { name: 'Booking Servis', href: '/booking/create' },
  { name: 'Tracking Status', href: '/booking/status' },
  { name: 'Riwayat Transaksi', href: '/transactions' },
];
</script>

<template>
  <div class="min-h-screen bg-slate-950 text-slate-200 font-sans selection:bg-indigo-500 selection:text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-slate-950/80 backdrop-blur-md border-b border-slate-800/50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <Link href="/" class="flex-shrink-0">
              <span class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">
                LaptopFix
              </span>
            </Link>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <Link
                  v-for="item in navigation"
                  :key="item.name"
                  :href="item.href"
                  class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 hover:text-white hover:bg-slate-800"
                  :class="$page.url.startsWith(item.href) ? 'text-white bg-slate-800' : 'text-slate-400'"
                >
                  {{ item.name }}
                </Link>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6 space-x-4">
              <Link href="/login" class="text-slate-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                Login
              </Link>
              <Link href="/register" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors shadow-lg shadow-indigo-500/20">
                Register
              </Link>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <button
              @click="isMobileMenuOpen = !isMobileMenuOpen"
              type="button"
              class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none"
            >
              <span class="sr-only">Open main menu</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div v-show="isMobileMenuOpen" class="md:hidden bg-slate-900 border-b border-slate-800">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <Link
            v-for="item in navigation"
            :key="item.name"
            :href="item.href"
            class="block px-3 py-2 rounded-md text-base font-medium text-slate-400 hover:text-white hover:bg-slate-800"
            @click="isMobileMenuOpen = false"
          >
            {{ item.name }}
          </Link>
          <div class="border-t border-slate-800 mt-4 pt-4 pb-2">
            <Link href="/login" class="block px-3 py-2 rounded-md text-base font-medium text-slate-400 hover:text-white hover:bg-slate-800">
              Login
            </Link>
            <Link href="/register" class="block px-3 py-2 rounded-md text-base font-medium text-indigo-400 hover:text-indigo-300">
              Register
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <main class="pt-16">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 mt-20">
      <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
          <div class="text-slate-500 text-sm">
            &copy; 2024 LaptopFix. All rights reserved.
          </div>
          <div class="flex space-x-6">
            <a href="#" class="text-slate-500 hover:text-slate-400">
              <span class="sr-only">Facebook</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
            </a>
            <a href="#" class="text-slate-500 hover:text-slate-400">
              <span class="sr-only">Instagram</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.047 1.408-.06 3.808-.06zM12 5.352c-3.673 0-6.648 2.975-6.648 6.648 0 3.673 2.975 6.648 6.648 6.648 3.673 0 6.648-2.975 6.648-6.648 0-3.673-2.975-6.648-6.648-6.648zm0 11.004a4.356 4.356 0 110-8.712 4.356 4.356 0 010 8.712zm8.688-9.729a1.592 1.592 0 11-3.184 0 1.592 1.592 0 013.184 0z" clip-rule="evenodd" /></svg>
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
