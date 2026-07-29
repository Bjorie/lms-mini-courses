<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LMS — Система дистанционного обучения</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
            rel="stylesheet"
        >

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
        @php
            $dashboardRoute = null;

            if (auth()->check()) {
                if (auth()->user()->hasRole('admin') && Route::has('admin.dashboard')) {
                    $dashboardRoute = route('admin.dashboard');
                } elseif (auth()->user()->hasRole('author') && Route::has('author.dashboard')) {
                    $dashboardRoute = route('author.dashboard');
                } elseif (auth()->user()->hasRole('student') && Route::has('student.dashboard')) {
                    $dashboardRoute = route('student.dashboard');
                } elseif (Route::has('dashboard')) {
                    $dashboardRoute = route('dashboard');
                }
            }
        @endphp

        <div class="relative isolate min-h-screen overflow-hidden">
            <div
                class="absolute inset-x-0 top-0 -z-10 h-96 bg-gradient-to-b from-blue-100 via-sky-50 to-transparent"
                aria-hidden="true"
            ></div>

            <div
                class="absolute -right-32 top-24 -z-10 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"
                aria-hidden="true"
            ></div>

            <div
                class="absolute -left-32 top-96 -z-10 h-80 w-80 rounded-full bg-indigo-200/30 blur-3xl"
                aria-hidden="true"
            ></div>

            <header class="mx-auto flex max-w-7xl items-center justify-between px-4 py-6 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-lg font-extrabold text-white shadow-sm">
                        L
                    </span>

                    <span>
                        <span class="block text-lg font-bold leading-tight text-slate-900">
                            LMS
                        </span>
                        <span class="block text-xs font-medium text-slate-500">
                            Мини курсы
                        </span>
                    </span>
                </a>

                <nav class="flex items-center gap-2 sm:gap-3" aria-label="Основная навигация">
                    @auth
                        @if ($dashboardRoute)
                            <a
                                href="{{ $dashboardRoute }}"
                                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                Личный кабинет
                            </a>
                        @endif
                    @else
                        @if (Route::has('login'))
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-white hover:text-slate-950"
                            >
                                Войти
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                Регистрация
                            </a>
                        @endif
                    @endauth
                </nav>
            </header>

            <main>
                <section class="mx-auto grid max-w-7xl gap-12 px-4 pb-20 pt-14 sm:px-6 sm:pt-20 lg:grid-cols-2 lg:items-center lg:px-8 lg:pb-28 lg:pt-24">
                    <div>
                        <div class="inline-flex items-center rounded-full border border-blue-200 bg-white/80 px-3 py-1 text-sm font-semibold text-blue-700 shadow-sm backdrop-blur">
                            Платформа для современного обучения
                        </div>

                        @auth
                            <p class="mt-6 text-base font-semibold text-blue-700">
                                Добро пожаловать, {{ auth()->user()->name }}!
                            </p>
                        @endauth

                        <h1 class="mt-5 max-w-3xl text-4xl font-extrabold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                            Учитесь в удобном темпе и отслеживайте свой прогресс
                        </h1>

                        <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                            Изучайте учебные курсы, проходите уроки и возвращайтесь к обучению в любое удобное время.
                            Все материалы и результаты собраны в одном месте.
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            @auth
                                @if ($dashboardRoute)
                                    <a
                                        href="{{ $dashboardRoute }}"
                                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3.5 text-base font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    >
                                        Перейти в личный кабинет
                                        <svg class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-3.22-3.22a.75.75 0 1 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 1 1-1.06-1.06l3.22-3.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endif
                            @else
                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3.5 text-base font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    >
                                        Начать обучение
                                    </a>
                                @endif

                                @if (Route::has('login'))
                                    <a
                                        href="{{ route('login') }}"
                                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3.5 text-base font-semibold text-slate-700 shadow-sm transition hover:border-slate-400 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2"
                                    >
                                        У меня уже есть аккаунт
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="relative">
                        <div class="rounded-3xl border border-white/80 bg-white/90 p-5 shadow-2xl shadow-slate-900/10 backdrop-blur sm:p-7">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                                <div>
                                    <p class="text-sm font-medium text-slate-500">
                                        Ваше обучение
                                    </p>
                                    <h2 class="mt-1 text-xl font-bold text-slate-900">
                                        Продолжайте с того места, где остановились
                                    </h2>
                                </div>

                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75v10.5m0-10.5c-1.5-1.2-3.5-1.8-6-1.8v10.5c2.5 0 4.5.6 6 1.8m0-10.5c1.5-1.2 3.5-1.8 6-1.8v10.5c-2.5 0-4.5.6-6 1.8" />
                                    </svg>
                                </span>
                            </div>

                            <div class="mt-6 space-y-5">
                                <div class="rounded-2xl bg-slate-50 p-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                                Онлайн-курс
                                            </span>

                                            <h3 class="mt-3 text-lg font-bold text-slate-900">
                                                Осваивайте новые знания шаг за шагом
                                            </h3>

                                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                                Последовательные разделы и уроки помогают не потеряться в материалах.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-2 flex items-center justify-between text-xs font-semibold">
                                            <span class="text-slate-500">Прогресс</span>
                                            <span class="text-blue-700">65%</span>
                                        </div>

                                        <div class="h-2 overflow-hidden rounded-full bg-slate-200">
                                            <div class="h-full w-[65%] rounded-full bg-blue-600"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="rounded-2xl border border-slate-200 p-4">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                                            </svg>
                                        </div>

                                        <p class="mt-3 font-semibold text-slate-900">
                                            Пройденные уроки
                                        </p>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Результаты сохраняются автоматически
                                        </p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-200 p-4">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h4.5l2.25-7.5 4.5 12 2.25-7.5H21" />
                                            </svg>
                                        </div>

                                        <p class="mt-3 font-semibold text-slate-900">
                                            Наглядный прогресс
                                        </p>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Следите за результатами обучения
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="border-y border-slate-200 bg-white/80">
                    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl text-center">
                            <p class="text-sm font-bold uppercase tracking-wider text-blue-600">
                                Возможности платформы
                            </p>

                            <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                                Всё необходимое для комфортного обучения
                            </h2>
                        </div>

                        <div class="mt-10 grid gap-6 md:grid-cols-3">
                            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V6.75A2.75 2.75 0 0 1 6.75 4H20v13.5H6a2 2 0 0 0-2 2Zm0 0A2.5 2.5 0 0 0 6.5 22H20v-4.5" />
                                    </svg>
                                </div>

                                <h3 class="mt-5 text-lg font-bold text-slate-900">
                                    Структурированные курсы
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-600">
                                    Материалы разделены на понятные разделы и уроки, которые удобно проходить последовательно.
                                </p>
                            </article>

                            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 9.5 17 19 7.5" />
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>
                                </div>

                                <h3 class="mt-5 text-lg font-bold text-slate-900">
                                    Сохранение прогресса
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-600">
                                    Отмечайте завершённые уроки и всегда продолжайте обучение с нужного места.
                                </p>
                            </article>

                            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 18V9m4 9V5m4 13v-6" />
                                    </svg>
                                </div>

                                <h3 class="mt-5 text-lg font-bold text-slate-900">
                                    Личный кабинет
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-600">
                                    Курсы, учебные результаты и доступные действия собраны в едином интерфейсе.
                                </p>
                            </article>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>
                    © {{ date('Y') }} LMS. Система дистанционного обучения.
                </p>

                <p>
                    Создано на Laravel и Livewire
                </p>
            </footer>
        </div>
    </body>
</html>