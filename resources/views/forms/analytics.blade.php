@extends('layouts.app')

@section('title', $form->title . ' - Analytics')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $form->title }} - Analytics</h1>
                    <p class="mt-2 text-gray-600">View form response statistics and insights.</p>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Responses</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalResponses }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Responses Over Time Chart -->
                <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Responses Over Time</h3>
                        <div class="h-64">
                            <canvas id="responsesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Field Response Analysis -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Field Response Analysis</h3>
                        <div class="space-y-6">
                            @foreach($form->fields as $field)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">{{ $field->label }}</h4>
                                    @php
                                        $responses = $form->responses->pluck('responses.' . $field->id)->filter(fn($v) => $v !== null && $v !== '');
                                        $total = $responses->count();
                                    @endphp
                                    @if(in_array($field->type, ['select', 'radio', 'checkbox']))
                                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Option</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($field->options as $option)
                                                    @php
                                                        $count = $responses->reduce(function($carry, $response) use ($option) {
                                                            if (is_array($response)) {
                                                                return $carry + (in_array($option, $response) ? 1 : 0);
                                                            }
                                                            if (is_string($response) && str_contains($response, ',')) {
                                                                return $carry + (in_array($option, array_map('trim', explode(',', $response))) ? 1 : 0);
                                                            }
                                                            return $carry + ($response === $option ? 1 : 0);
                                                        }, 0);
                                                        $percent = $total > 0 ? round(($count / $total) * 100, 1) : 0;
                                                    @endphp
                                                    <tr>
                                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $option }}</td>
                                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $count }}</td>
                                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $percent }}%</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <p class="text-xs text-gray-500 mb-4">Total responses: {{ $total }}</p>
                                    @else
                                        @if($total > 0)
                                            <button type="button" class="text-indigo-600 hover:underline text-sm mb-2" onclick="toggleTextResponses('responses-{{ $field->id }}')">View Text Responses</button>
                                            <div id="responses-{{ $field->id }}" class="hidden border rounded p-4 mb-4 bg-gray-50">
                                                <ul class="space-y-2">
                                                    @foreach($form->responses->where('responses.' . $field->id, '!=', null)->sortByDesc('created_at') as $response)
                                                        @php $value = $response->responses[$field->id] ?? null; @endphp
                                                        @if($value !== null && $value !== '')
                                                            <li class="border-b pb-2">
                                                                <span class="block text-gray-800">{{ $value }}</span>
                                                                <span class="block text-xs text-gray-500">{{ $response->created_at->format('Y-m-d H:i:s') }}</span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const responsesCtx = document.getElementById('responsesChart').getContext('2d');
    new Chart(responsesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($responsesByDate->pluck('date')) !!},
            datasets: [{
                label: 'Responses',
                data: {!! json_encode($responsesByDate->pluck('count')) !!},
                borderColor: 'rgb(79, 70, 229)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    function toggleTextResponses(id) {
        var el = document.getElementById(id);
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
        } else {
            el.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection 