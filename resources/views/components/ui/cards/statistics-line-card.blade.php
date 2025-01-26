@props([
    'title' => '',
    'value',
    'chartId' => '',
    'icon' => '',
    'solidColor' => 'warning',
    'chartGradientColor' => '',
])
@php($chartGradientColor = $chartGradientColor ?: $solidColor)
<div class="col-lg-4 col-sm-6 col-12 mb-3">
    <div class="card">
        <div class="card-header align-items-start pb-0">
            <div>
                <h2 class="fw-bolder">{{$value}}</h2>
                @if($title !== '')
                    <p class="card-text">{{translate_ui($title)}}</p>
                @endif
            </div>
            @if($icon)
                <div class="avatar bg-light-{{$solidColor}} p-50">
                    <div class="avatar-content">
                        <i data-feather="{{$icon}}" class="font-medium-5"></i>
                    </div>
                </div>
            @endif
        </div>
        <div id="{{$chartId}}"></div>
    </div>
</div>
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var chartItemOptions = {
                chart: {
                    height: 100,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        top: 5,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                    },
                    toolbar: {
                        show: false
                    },
                    sparkline: {
                        enabled: true
                    },
                    grid: {
                        show: false,
                        padding: {
                            left: 0,
                            right: 0
                        }
                    }
                },
                colors: [config.colors['{{$solidColor}}']],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 5
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        gradientToColors: [config.colors['{{$solidColor}}']],
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100]
                    }
                },
                series: [
                    {
                        name: '{{$title}}',
                        data: [365, 390, 365, 400, 375, 400]
                    }
                ],
                xaxis: {
                    labels: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: [
                    {
                        y: 0,
                        offsetX: 0,
                        offsetY: 0,
                        padding: { left: 0, right: 0 }
                    }
                ],
                tooltip: {
                    x: { show: false }
                }
            };

            var chartItem = new ApexCharts(document.querySelector('#{{$chartId}}'), chartItemOptions);
            chartItem.render();
        })
    </script>
@endpush
