@php
    $days = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];
    $calendarDays = range(1, 31);
@endphp

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button type="button" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-chevron-left"></i>
            </button>

            <h2 class="h5 mb-0 fw-bold">Marzo 2026</h2>

            <button type="button" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <div class="row text-center fw-semibold text-muted mb-2">
            @foreach($days as $day)
                <div class="col">{{ $day }}</div>
            @endforeach
        </div>

        @foreach(array_chunk($calendarDays, 7) as $week)
            <div class="row text-center mb-2">
                @foreach($week as $dayNumber)
                    <div class="col mb-2">
                        <button
                            type="button"
                            class="btn btn-light border w-100"
                            style="min-height: 48px;"
                        >
                            {{ $dayNumber }}
                        </button>
                    </div>
                @endforeach

                @for($i = count($week); $i < 7; $i++)
                    <div class="col mb-2"></div>
                @endfor
            </div>
        @endforeach

        <div class="mt-3">
            <span class="badge text-bg-success me-2">Disponible</span>
            <span class="badge text-bg-secondary">No disponible</span>
        </div>
    </div>
</div>