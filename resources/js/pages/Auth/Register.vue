<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Daftar Akun Baru" />

    <div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 px-4">
        <div class="max-w-md w-full bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white">Daftar Akun</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Buat akun biar bisa booking servis.</p>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap</label>
                    <input v-model="form.name" type="text" class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required />
                    <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                    <input v-model="form.email" type="email" class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required />
                    <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password</label>
                    <input v-model="form.password" type="password" class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required />
                    <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ulangi Password</label>
                    <input v-model="form.password_confirmation" type="password" class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required />
                </div>

                <button type="submit" :disabled="form.processing" class="w-full py-3.5 px-4 rounded-xl shadow-lg font-bold text-white bg-blue-600 hover:bg-blue-700 transition disabled:opacity-70">
                    <span v-if="form.processing">Mendaftar...</span>
                    <span v-else>Daftar Sekarang</span>
                </button>

                <div class="mt-4 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Sudah punya akun? 
                        <Link href="/login" class="font-bold text-blue-600 hover:text-blue-500">Login Disini</Link>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>