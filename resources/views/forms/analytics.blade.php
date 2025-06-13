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
                                    <h4 class="text-sm font-medium text-gray-700">{{ $field->label }}</h4>
                                    <div class="mt-2">
                                        @if(in_array($field->type, ['select', 'radio', 'checkbox']))
                                            <div class="h-48">
                                                <canvas id="fieldChart_{{ $field->id }}"></canvas>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">Response type: {{ ucfirst($field->type) }}</p>
                                        @endif
                                    </div>
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
    // Responses Over Time Chart
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

    // Field Response Charts
    @foreach($form->fields as $field)
        @if(in_array($field->type, ['select', 'radio', 'checkbox']))
            const fieldCtx_{{ $field->id }} = document.getElementById('fieldChart_{{ $field->id }}').getContext('2d');
            const responses_{{ $field->id }} = {!! json_encode($form->responses->pluck('responses.' . $field->label)) !!};
            const options_{{ $field->id }} = {!! json_encode($field->options) !!};
            
            // Count responses for each option
            const counts_{{ $field->id }} = options_{{ $field->id }}.map(option => {
                return responses_{{ $field->id }}.filter(response => {
                    if (Array.isArray(response)) {
                        return response.includes(option);
                    }
                    return response === option;
                }).length;
            });

            new Chart(fieldCtx_{{ $field->id }}, {
                type: 'bar',
                data: {
                    labels: options_{{ $field->id }},
                    datasets: [{
                        label: 'Responses',
                        data: counts_{{ $field->id }},
                        backgroundColor: 'rgba(79, 70, 229, 0.5)',
                        borderColor: 'rgb(79, 70, 229)',
                        borderWidth: 1
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
        @endif
    @endforeach
</script>
@endpush
@endsection 