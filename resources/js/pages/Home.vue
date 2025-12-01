<script setup lang="ts">
import MainLayout from '../layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineOptions({ layout: MainLayout });
</script>

<template>
  <Head title="Home" />

  <!-- Hero Section -->
  <div class="relative bg-slate-900 overflow-hidden">
    <div class="absolute inset-0">
      <img class="w-full h-full object-cover opacity-30" src="/images/hero-bg.png" alt="Laptop Repair Workshop">
      <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
    </div>
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
      <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
        Expert Laptop Repair <br class="hidden sm:block" />
        <span class="bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">at Your Fingertips</span>
      </h1>
      <p class="mt-6 text-xl text-slate-300 max-w-3xl">
        Professional service, transparent pricing, and real-time tracking. We bring your device back to life with precision and care.
      </p>
      <div class="mt-10 flex space-x-4">
        <Link href="/booking/create" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200 hover:shadow-lg hover:shadow-indigo-500/30">
          Book Service Now
        </Link>
        <Link href="/catalog" class="inline-flex items-center px-6 py-3 border border-slate-600 text-base font-medium rounded-md text-slate-200 bg-slate-800/50 hover:bg-slate-800 backdrop-blur-sm transition-all duration-200">
          View Pricing
        </Link>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div class="py-16 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h2 class="text-base font-semibold text-indigo-400 tracking-wide uppercase">Why Choose Us</h2>
        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-white sm:text-4xl">
          Premium Service Standard
        </p>
      </div>

      <div class="mt-10">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
          <!-- Feature 1 -->
          <div class="flex flex-col items-center text-center p-6 bg-slate-900/50 rounded-2xl border border-slate-800 hover:border-indigo-500/50 transition-colors duration-300">
            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mb-4 shadow-lg shadow-indigo-500/30">
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
              </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-white">Transparent Pricing</h3>
            <p class="mt-2 text-base text-slate-400">
              Know exactly what you pay before we start. No hidden fees, just honest service.
            </p>
          </div>

          <!-- Feature 2 -->
          <div class="flex flex-col items-center text-center p-6 bg-slate-900/50 rounded-2xl border border-slate-800 hover:border-indigo-500/50 transition-colors duration-300">
            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-cyan-500 text-white mb-4 shadow-lg shadow-cyan-500/30">
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-white">Real-time Tracking</h3>
            <p class="mt-2 text-base text-slate-400">
              Monitor your device's repair status from anywhere, anytime.
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="flex flex-col items-center text-center p-6 bg-slate-900/50 rounded-2xl border border-slate-800 hover:border-indigo-500/50 transition-colors duration-300">
            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white mb-4 shadow-lg shadow-purple-500/30">
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-white">Quality Guarantee</h3>
            <p class="mt-2 text-base text-slate-400">
              We stand by our work with a comprehensive warranty on all repairs.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
