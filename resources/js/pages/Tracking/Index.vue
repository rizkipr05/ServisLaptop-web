<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { ref } from 'vue';

const searchResult = ref<any>(null);
const isSearching = ref(false);

const form = useForm({
    receipt_code: '', // Kode resi atau No WA
});

const handleSearch = () => {
    isSearching.value = true;
    setTimeout(() => {
        searchResult.value = {
            device: 'Asus ROG Zephyrus G14',
            owner: 'Iky Kang Coding Aseliii',
            status: 'Sedang Dikerjakan',
            history: [
                { title: 'Booking Diterima', date: '08 Jan 10:00', done: true },
                { title: 'Laptop Diterima Teknisi', date: '08 Jan 11:30', done: true },
                { title: 'Pengecekan Komponen', date: '08 Jan 13:00', done: true },
                { title: 'Perbaikan / Ganti Part', date: 'Sedang Proses', done: false },
                { title: 'Selesai & Siap Ambil', date: '-', done: false },
            ]
        };
        isSearching.value = false;
    }, 1000);
};
</script>

<template>
    <Head title="Cek Status Servis" />

    <MainLayout>
        <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
            <div class="max-w-3xl mx-auto">
                
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white">Lacak Status Servis</h1>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Masukkan Nomor WhatsApp atau Kode Resi booking Anda.
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 mb-8">
                    <form @submit.prevent="handleSearch" class="flex gap-4">
                        <input 
                            v-model="form.receipt_code"
                            type="text" 
                            placeholder="Contoh: 08123456789" 
                            class="flex-1 block w-full px-4 py-3 rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required
                        >
                        <button 
                            type="submit" 
                            :disabled="isSearching"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg shadow-blue-500/30 disabled:opacity-50"
                        >
                            {{ isSearching ? 'Mencari...' : 'Cari' }}
                        </button>
                    </form>
                </div>

                <div v-if="searchResult" class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 overflow-hidden animation-fade-in">
                    
                    <div class="bg-blue-600 p-6 text-white flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-lg">{{ searchResult.device }}</h3>
                            <p class="text-blue-100 text-sm">{{ searchResult.owner }}</p>
                        </div>
                        <div class="px-3 py-1 bg-white/20 rounded-lg text-sm font-semibold backdrop-blur-sm">
                            {{ searchResult.status }}
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="relative border-l-2 border-slate-200 dark:border-slate-700 space-y-8 pl-8 ml-2">
                            
                            <div v-for="(item, index) in searchResult.history" :key="index" class="relative">
                                <span 
                                    class="absolute -left-[41px] top-1 w-5 h-5 rounded-full border-4 border-white dark:border-slate-900"
                                    :class="item.done ? 'bg-blue-600' : 'bg-slate-300 dark:bg-slate-600'"
                                ></span>
                                
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-base" :class="{'text-slate-400 dark:text-slate-500': !item.done}">
                                        {{ item.title }}
                                    </h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-mono">
                                        {{ item.date }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div v-else-if="!isSearching" class="text-center py-12 opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-slate-400 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">Data belum dimuat</p>
                </div>

            </div>
        </div>
    </MainLayout>
</template>

<style>
/* Animasi halus saat data muncul */
.animation-fade-in {
    animation: fadeIn 0.5s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>