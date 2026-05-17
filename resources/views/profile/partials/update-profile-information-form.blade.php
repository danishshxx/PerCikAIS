<section>
    <form
        method="POST"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
        class="space-y-6"
        x-data="{
            photoPreview: '{{ $user->profile_photo_url }}',
            previewPhoto(event) {
                const file = event.target.files[0];

                if (!file) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        }"
    >
        @csrf
        @method('patch')

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
            <img
                :src="photoPreview"
                alt="{{ $user->name }}"
                class="h-24 w-24 rounded-[28px] object-cover shadow-xl shadow-blue-500/10"
            >

            <div class="flex-1">
                <label for="profile_photo" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Foto Profil
                </label>

                <input
                    id="profile_photo"
                    name="profile_photo"
                    type="file"
                    accept="image/png,image/jpeg,image/jpg,image/webp"
                    x-on:change="previewPhoto"
                    class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-blue-600 hover:file:bg-blue-100 dark:border-slate-800 dark:bg-[#121929] dark:text-slate-200 dark:file:bg-blue-500/10 dark:file:text-blue-300"
                >

                <p class="mt-2 text-xs font-medium text-slate-400">
                    Format JPG, PNG, atau WEBP. Maksimal 2MB.
                </p>

                @error('profile_photo')
                    <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="name" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Nama Lengkap
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                >

                @error('name')
                    <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Email
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="username"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                >

                @error('email')
                    <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="nis" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    NIS / Nomor Induk
                </label>

                <input
                    id="nis"
                    name="nis"
                    type="text"
                    value="{{ old('nis', $user->nis) }}"
                    placeholder="Contoh: 2024001"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                >

                @error('nis')
                    <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Nomor Telepon
                </label>

                <input
                    id="phone"
                    name="phone"
                    type="text"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="Contoh: 081234567890"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                >

                @error('phone')
                    <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <div>
                <label for="gender" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Jenis Kelamin
                </label>

                <select
                    id="gender"
                    name="gender"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                >
                    <option value="">Pilih</option>
                    <option value="Laki-laki" @selected(old('gender', $user->gender) === 'Laki-laki')>Laki-laki</option>
                    <option value="Perempuan" @selected(old('gender', $user->gender) === 'Perempuan')>Perempuan</option>
                </select>

                @error('gender')
                    <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="birth_place" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Tempat Lahir
                </label>

                <input
                    id="birth_place"
                    name="birth_place"
                    type="text"
                    value="{{ old('birth_place', $user->birth_place) }}"
                    placeholder="Contoh: Jakarta"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                >

                @error('birth_place')
                    <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="birth_date" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Tanggal Lahir
                </label>

                <input
                    id="birth_date"
                    name="birth_date"
                    type="date"
                    value="{{ old('birth_date', $user->birth_date ? \Illuminate\Support\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                >

                @error('birth_date')
                    <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="address" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                Alamat
            </label>

            <textarea
                id="address"
                name="address"
                rows="4"
                placeholder="Masukkan alamat lengkap"
                class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
            >{{ old('address', $user->address) }}</textarea>

            @error('address')
                <p class="mt-2 text-sm font-semibold text-red-500">{{ $message }}</p>
            @enderror
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="rounded-2xl border border-yellow-100 bg-yellow-50 px-5 py-4 text-sm font-semibold text-yellow-700 dark:border-yellow-500/20 dark:bg-yellow-500/10 dark:text-yellow-300">
                Email kamu belum diverifikasi.

                <button
                    form="send-verification"
                    class="ml-1 font-extrabold underline"
                >
                    Kirim ulang email verifikasi.
                </button>
            </div>

            @if (session('status') === 'verification-link-sent')
                <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-300">
                    Link verifikasi baru sudah dikirim ke email kamu.
                </p>
            @endif
        @endif

        <div class="flex items-center justify-end gap-4 pt-2">
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-bold text-emerald-600 dark:text-emerald-300"
                >
                    Tersimpan.
                </p>
            @endif

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700"
            >
                Simpan Perubahan
            </button>
        </div>
    </form>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>
</section>