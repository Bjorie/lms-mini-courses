@if(session()->has('success'))

    <div
        class="mb-6 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800"
    >
        {{ session('success') }}
    </div>

@endif

@if(session()->has('error'))

    <div
        class="mb-6 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-800"
    >
        {{ session('error') }}
    </div>

@endif