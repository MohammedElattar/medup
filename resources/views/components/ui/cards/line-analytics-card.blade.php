@props([
    'shouldIncludeScripts' => true,
    'title' => 'Sales',
    'total' => '12.84k',
])
<div class="col-12">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-start">
                    <div>
                        <h4 class="card-title mb-25">{{$title}}</h4>
                        <p class="card-text mb-0">{{$total}}</p>
                    </div>
                    <i data-feather="settings" class="font-medium-3 text-muted cursor-pointer"></i>
                </div>
                <div class="card-body pb-0">
                    <div id="sales-line-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($shouldIncludeScripts)
    @push('custom-scripts')
{{--        <script src="{{ asset(mix('js/scripts/cards/card-analytics.js')) }}"></script>--}}
    @endpush
@endif

@push('custom-scripts')
    <script>

      const revenueGeneratedEl = document.querySelector('#revenueGenerated'),
        revenueGeneratedConfig = {
          chart: {
            height: 90,
            type: 'area',
            parentHeightOffset: 0,
            toolbar: {
              show: false
            },
            sparkline: {
              enabled: true
            }
          },
          markers: {
            colors: 'transparent',
            strokeColors: 'transparent'
          },
          grid: {
            show: false
          },
          colors: [config.colors.success],
          fill: {
            type: 'gradient',
            gradient: {
              shade: shadeColor,
              shadeIntensity: 0.8,
              opacityFrom: 0.6,
              opacityTo: 0.1
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 2,
            curve: 'smooth'
          },
          series: [
            {
              data: [300, 350, 330, 380, 340, 400, 380]
            }
          ],
          xaxis: {
            show: true,
            lines: {
              show: false
            },
            labels: {
              show: false
            },
            stroke: {
              width: 0
            },
            axisBorder: {
              show: false
            }
          },
          yaxis: {
            stroke: {
              width: 0
            },
            show: false
          },
          tooltip: {
            enabled: false
          }
        };
      if (typeof revenueGeneratedEl !== undefined && revenueGeneratedEl !== null) {
        const revenueGenerated = new ApexCharts(revenueGeneratedEl, revenueGeneratedConfig);
        revenueGenerated.render();
      }


      salesLineChartOptions = {
            chart: {
                height: 240,
                toolbar: { show: false },
                zoom: { enabled: false },
                type: 'line',
                dropShadow: {
                    enabled: true,
                    top: 18,
                    left: 2,
                    blur: 5,
                    opacity: 0.2
                },
                offsetX: -10
            },
            stroke: {
                curve: 'smooth',
                width: 4
            },
            grid: {
                borderColor: borderColor,
                padding: {
                    top: -20,
                    bottom: 5,
                    left: 20
                }
            },
            legend: {
                show: false
            },
            colors: [config.colors.info],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    inverseColors: false,
                    gradientToColors: [config.colors.primary],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100, 100, 100]
                }
            },
            markers: {
                size: 0,
                hover: {
                    size: 5
                }
            },
            xaxis: {
                labels: {
                    offsetY: 5,
                    style: {
                        colors: $textMutedColor,
                        fontSize: '0.857rem'
                    }
                },
                axisTicks: {
                    show: false
                },
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: {
                    show: false
                },
                tickPlacement: 'on'
            },
            yaxis: {
                tickAmount: 5,
                labels: {
                    style: {
                        colors: $textMutedColor,
                        fontSize: '0.857rem'
                    },
                    formatter: function (val) {
                        return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
                    }
                }
            },
            tooltip: {
                x: { show: false }
            },
            series: [
                {
                    name: '{{$title}}',
                    data: [140, 180, 150, 205, 160, 295, 125, 255, 205, 305, 240, 295]
                }
            ]
        };
        salesLineChart = new ApexCharts($salesLineChart, salesLineChartOptions);
        salesLineChart.render();
    </script>
@endpush
