<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login User" />

    <div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 transition-colors duration-300 px-4">
        
        <div class="max-w-md w-full bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    LaptopFix
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Masuk untuk booking servis & cek status.
                </p>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email Address</label>
                    <input 
                        v-model="form.email" 
                        type="email" 
                        id="email"
                        class="w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors outline-none"
                        placeholder="nama@email.com"
                        required 
                        autofocus
                    />
                    <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password</label>
                    <input 
                        v-model="form.password" 
                        type="password" 
                        id="password"
                        class="w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors outline-none"
                        placeholder="••••••••"
                        required 
                    />
                </div>

                <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-70 disabled:cursor-not-allowed transition transform active:scale-95"
                >
                    <span v-if="form.processing">Memproses...</span>
                    <span v-else>Masuk Sekarang</span>
                </button>

                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Belum punya akun? 
                        <a href="/register" class="font-bold text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                            Daftar Disini
                        </a>
                    </p>
                </div>

            </form>
        </div>
    </div>
</template>