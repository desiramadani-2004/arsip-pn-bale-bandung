<div class="flex items-center gap-4">
    <x-primary-button class="bg-emerald-800 hover:bg-emerald-900 shadow-lg shadow-emerald-200">
        {{ __('Simpan Perubahan') }}
    </x-primary-button>

    @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600 font-bold uppercase tracking-tighter italic">
            {{ __('Berhasil Disimpan.') }}
        </p>
    @endif
</div>