<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { onMounted } from 'vue';

defineProps<{
    midtrans_client_key?: string; 
}>();

// Setup Form Inertia
const form = useForm({
    name: '',
    phone: '',
    device_type: '',
    service_type: 'service_ringan',
    description: '',
});

// Load Script Midtrans Snap
onMounted(() => {
    const script = document.createElement('script');
    script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
    // Client key 
    script.setAttribute('data-client-key', 'SB-Mid-client-4W-WgxZvB15RM-aS'); 
    document.head.appendChild(script);
});

// Fungsi Submit Form
const submitBooking = () => {
    form.post('/booking', {
        onSuccess: () => {
            // Logic frontend
            console.log("Data terkirim, menunggu token pembayaran...");
            
            // Panggil: window.snap.pay('TOKEN');
        },
        onError: (errors) => {
            console.error("Ada error pengisian form", errors);
        }
    });
};
</script>

<template>
    <Head title="Booking Servis Baru" />

    <MainLayout>
        <div class="py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300">
            
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Formulir Servis
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Isi detail kerusakan laptopmu, teknisi kami akan segera menangani.
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-900 py-8 px-6 shadow-xl shadow-slate-200/50 dark:shadow-none rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                    
                    <form @submit.prevent="submitBooking" class="space-y-6">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                            <input 
                                v-model="form.name"
                                type="text" 
                                id="name" 
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors"
                                placeholder="Contoh: Budi Santoso"
                                required
                            >
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nomor WhatsApp</label>
                            <input 
                                v-model="form.phone"
                                type="tel" 
                                id="phone" 
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors"
                                placeholder="0812..."
                                required
                            >
                        </div>

                        <div>
                            <label for="device" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tipe / Merk Laptop</label>
                            <input 
                                v-model="form.device_type"
                                type="text" 
                                id="device" 
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors"
                                placeholder="Contoh: Asus ROG / Macbook Air M1"
                                required
                            >
                        </div>

                        <div>
                            <label for="service" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Jenis Layanan</label>
                            <select 
                                v-model="form.service_type"
                                id="service" 
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors"
                            >
                                <option value="service_ringan">Ganti Part / Ringan (Bisa Ditunggu)</option>
                                <option value="install_ulang">Install Ulang Software / OS</option>
                                <option value="mati_total">Cek Mesin / Mati Total</option>
                                <option value="cleaning">Deep Cleaning & Thermal Paste</option>
                            </select>
                        </div>

                        <div>
                            <label for="desc" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Keluhan Detail</label>
                            <textarea 
                                v-model="form.description"
                                id="desc" 
                                rows="3"
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors"
                                placeholder="Ceritakan kronologi kerusakan..."
                            ></textarea>
                        </div>

                        <div class="pt-4">
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-70 disabled:cursor-not-allowed transition transform active:scale-95"
                            >
                                <span v-if="form.processing">Memproses...</span>
                                <span v-else>Lanjut ke Pembayaran</span>
                            </button>
                        </div>

                        <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-4">
                            Data Anda aman. Klik lanjut untuk menyelesaikan booking.
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </MainLayout>
</template>