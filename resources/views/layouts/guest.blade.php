<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>LMS — Система дистанционного обучения</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
            rel="stylesheet"
        >

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-slate-900 antialiased">
        <div class="relative min-h-screen overflow-hidden bg-slate-50">
            <div
                class="absolute inset-x-0 top-0 -z-10 h-96 bg-gradient-to-b from-blue-100 via-sky-50 to-transparent"
                aria-hidden="true"
            ></div>

            <div
                class="absolute -right-32 top-20 -z-10 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"
                aria-hidden="true"
            ></div>

            <div
                class="absolute -left-32 bottom-10 -z-10 h-80 w-80 rounded-full bg-indigo-200/30 blur-3xl"
                aria-hidden="true"
            ></div>

            <div class="mx-auto flex min-h-screen w-full max-w-7xl flex-col px-4 sm:px-6 lg:px-8">
                <header class="flex items-center justify-between py-6">
                    <a
                        href="{{ url('/') }}"
                        wire:navigate
                        class="flex items-center gap-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-lg font-extrabold text-white shadow-sm">
                            L
                        </span>

                        <span>
                            <span class="block text-lg font-bold leading-tight text-slate-900">
                                LMS
                            </span>

                            <span class="block text-xs font-medium text-slate-500">
                                Онлайн-обучение
                            </span>
                        </span>
                    </a>

                    <a
                        href="{{ url('/') }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-white hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L5.56 9.25h10.69A.75.75 0 0 1 17 10Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        На главную
                    </a>
                </header>

                <main class="flex flex-1 items-center justify-center py-8 sm:py-12">
                    <div class="mx-auto w-full max-w-md">
                        <div class="mb-6 text-center">
                            <p class="text-sm font-bold uppercase tracking-wider text-blue-600">
                                Система дистанционного обучения
                            </p>
                        </div>

                        <div class="mx-auto w-full overflow-hidden rounded-3xl border border-white/80 bg-white/95 px-6 py-8 shadow-2xl shadow-slate-900/10 backdrop-blur sm:px-8 sm:py-10">
                            {{ $slot }}
                        </div>
                    </div>
                </main>

                <footer class="py-6 text-center text-sm text-slate-500">
                    © {{ date('Y') }} LMS. Все права защищены.
                </footer>
            </div>
        </div>
    </body>
</html>