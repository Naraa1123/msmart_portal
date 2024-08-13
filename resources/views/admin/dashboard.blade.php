@extends('layouts.admin')

@section('style')
    <style>
        h2{
            margin-left: 20%;
        }

        #usersChart{
            width: 100% !important;
            height: 75% !important;
        }

        #graphics{
            padding-left: 20px;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            @if(Session('message'))
                <h2 class="alert alert-success">{{ Session('message') }}</h2>
            @endif
            <div style="width: 100%; text-align: center">
                <h1 style="font-size: 36px">Dashboard</h1>
            </div>
        </div>
        <div style="width: 100%; display: flex;flex-direction: column; flex-wrap: wrap">
            <div class="d-flex flex-row" style="justify-content: space-evenly; flex-wrap: wrap">
                <div class="card mb-3" style="width: 45%">
                    <div style="text-align: center; padding-top: 10px">
                        <h3 class="card-title" style="font-weight: bold">Хэрэглэгчдийн</h3>
                    </div>
                    <canvas class="card-img-bottom" id="usersChart"></canvas>
                </div>
                <div class="card mb-3" style="width: 45%">
                    <div style="text-align: center; padding-top: 10px">
                        <h3 class="card-title" style="font-weight: bold">Насны</h3>
                    </div>
                    <canvas class="card-img-bottom" id="thirdPieChart"></canvas>
                </div>
            </div>

            <div class="d-flex flex-row" style="justify-content: space-evenly; flex-wrap: wrap">
                <div class="card mb-3" style="width: 30%">
                    <div style="padding: 10px 0 0 30px; ">
                        <h3 class="card-title" style="font-weight: bold">Хүйсийн</h3>
                    </div>
                    <canvas class="card-img-bottom" id="pieChart" style="padding: 7%"></canvas>
                </div>
                <div class="card mb-3" style="width: 30%">
                    <div style="padding: 10px 0 0 30px; ">
                        <h3 class="card-title" style="font-weight: bold">Төлөвийн</h3>
                    </div>
                    <canvas class="card-img-bottom" id="secondPieChart" style="padding: 7%"></canvas>
                </div>
                <div class="card mb-3" style="width: 30%">
                    <div style="padding: 10px 0 0 30px; ">
                        <h3 class="card-title" style="font-weight: bold">Анги ба сурагч</h3>
                    </div>
                    <canvas class="card-img-bottom" id="fourthChart" style="padding: 7%"></canvas>
                </div>
            </div>

            <div class="d-flex flex-row" style="justify-content: space-evenly; flex-wrap: wrap; margin-bottom:80px">
                <div class="card mb-3" style="width: 80%">
                    <div style="text-align: center; padding-top: 10px">
                        <h3 class="card-title" style="font-weight: bold; margin-bottom: 10px; font-size: 36px">9 сарын элсэлт</h3>
                    </div>
                    <canvas class="card-img-bottom" id="ProgrammerChart"></canvas>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('script')
    <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($seconddata['labels']),
                datasets: [{
                    data: @json($seconddata['seconddata']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Hides the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('secondPieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($thirddata['labels']),
                datasets: [{
                    data: @json($thirddata['thirddata']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Hides the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('usersChart').getContext('2d');
        var usersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'сард шинээр нэмэгдсэн хэрэглэгчдийн график',
                    data: @json($data),
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('secondPieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($thirddata['labels']),
                datasets: [{
                    data: @json($thirddata['thirddata']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Hides the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('thirdPieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($fourthdata['labels']),
                datasets: [{
                    data: @json($fourthdata['fourthdata']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(27, 142, 27, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgb(232, 33, 33)',

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(18, 104, 18, 0.7)',
                        'rgba(153, 102, 255, 1)',
                        'rgb(254, 29, 29)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Hides the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                            }
                        }
                    }
                }
            }
        });
    </script>


    <script>
        var ctx = document.getElementById('fourthChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($fifthdata['labels']),
                datasets: [{
                    data: @json($fifthdata['fifthdata']),
                    backgroundColor: [
                        'rgba(54, 162, 235, 25.7)',
                        'rgba(74, 143, 246, 0.7)',
                        'rgba(209, 19, 32, 0.7)',
                        'rgba(244, 98, 108, 0.7)',
                        'rgba(229, 117, 43, 0.7)',
                        'rgba(244, 232, 62, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(222, 47, 204, 0.7)',
                        'rgba(27, 142, 27, 0.7)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(42, 87, 154, 0.7)',
                        'rgba(149, 13, 22, 0.7)',
                        'rgba(169, 68, 68, 0.7)',
                        'rgba(161, 88, 39, 0.7)',
                        'rgba(189, 178, 19, 0.7)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(178, 36, 164, 0.7)',
                        'rgba(18, 104, 18, 0.7)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Hides the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('ProgrammerChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($sixthdata['labels']),
                datasets: [{
                    data: @json($sixthdata['sixthdata']),
                    backgroundColor: [
                        'rgba(54, 162, 235, 25.7)',
                        'rgba(74, 143, 246, 0.7)',
                        'rgba(209, 19, 32, 0.7)',
                        'rgba(244, 98, 108, 0.7)',
                        'rgba(229, 117, 43, 0.7)',
                        'rgba(244, 232, 62, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(222, 47, 204, 0.7)',
                        'rgba(27, 142, 27, 0.7)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(42, 87, 154, 0.7)',
                        'rgba(149, 13, 22, 0.7)',
                        'rgba(169, 68, 68, 0.7)',
                        'rgba(161, 88, 39, 0.7)',
                        'rgba(189, 178, 19, 0.7)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(178, 36, 164, 0.7)',
                        'rgba(18, 104, 18, 0.7)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20 // Set the maximum value for the y-axis
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hides the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                            }
                        }
                    }
                }
            }
        });
    </script>



@endsection
