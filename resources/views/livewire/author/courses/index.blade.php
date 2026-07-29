<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Мои курсы</h1>
            <p class="text-muted mb-0">
                Здесь отображаются все курсы, созданные вами.
            </p>
        </div>

        <a href="#" class="btn btn-primary">
            + Создать курс
        </a>
    </div>

    @if($courses->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <h5>У вас пока нет курсов</h5>

                <p class="text-muted mb-4">
                    Создайте свой первый курс и начните наполнять его уроками.
                </p>

                <a href="#" class="btn btn-primary">
                    Создать курс
                </a>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Статус</th>
                            <th>Цена</th>
                            <th>Создан</th>
                            <th class="text-end">Действия</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>
                                    <strong>{{ $course->title }}</strong>
                                </td>

                                <td>
                                    @if($course->published_at)
                                        <span class="badge bg-success">
                                            Опубликован
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Черновик
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ number_format($course->price, 2, ',', ' ') }} ₽
                                </td>

                                <td>
                                    {{ $course->created_at->format('d.m.Y') }}
                                </td>

                                <td class="text-end">
                                    <a
                                        href="{{ route('author.courses.edit', $course) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Редактировать
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>