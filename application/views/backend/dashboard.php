<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            PH AIR</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="ph"></div>
                        <span id="statuspH"></span>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            PPM</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="ppm"></div>
                        <span id="statusTds"></span>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Debit Air</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="debit"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card mt-3">
            <div class="card-body">
                <div id="grafik"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card mt-3">
            <div class="card-body">
                <div id="barometer"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/highcharts/highcharts.js"></script>
<script src="<?php echo base_url() ?>assets/highcharts/highcharts-more.js"></script>
<script src="<?php echo base_url() ?>assets/highcharts/exporting.js"></script>
<script src="<?php echo base_url() ?>assets/highcharts/export-data.js"></script>
<script src="<?php echo base_url() ?>assets/highcharts/accessibility.js"></script>


<script>
    var chart;
    var total = 0,
        date = [];

    var chartBaro;

    function grafik() {
        $.ajax({
            url: '<?php echo base_url('admin/realtime') ?>',
            dataType: 'json',
            success: function(response) {
                if (response.count > total) {

                    total = response.count;

                    var data_akhir = response.data;
                    var pH = Number(data_akhir.pH);
                    var ppm = Number(data_akhir.ppm);
                    var debit = [];

                    debit[0] = Number(data_akhir.debit);

                    chartBaro.series[0].setData(debit);

                    var konfersi = new Date(Date.parse(data_akhir.date));
                    var date2 = konfersi.getHours() + ":" + konfersi.getMinutes() + ":" + konfersi
                        .getSeconds();
                    date.push(date2);

                    chart.series[0].addPoint([data_akhir.date, pH], true, false);
                    chart.series[1].addPoint([data_akhir.date, ppm], true, false);
                    chart.xAxis[0].setCategories(date);
                }

                setTimeout(grafik, 2000);
            }
        });
    }

    function realtime() {
        $.ajax({
            url: "<?= base_url('admin/realtime'); ?>",
            dataType: "json",
            success: function(response) {
                $('#ph').text(response.data.pH);
                $('#ppm').text(response.data.ppm);
                $('#debit').text(response.data.debit);
                $('#statuspH').text(response.data.statuspH);
                $('#statusTds').text(response.data.statusTds);

                setTimeout(realtime, 2000)
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        chart = Highcharts.chart('grafik', {
            chart: {
                events: {
                    load: grafik
                }
            },
            title: {
                text: 'Grafik Monitoring ph Air dan PPM'
            },
            xAxis: {
                title: {
                    text: 'Waktu'
                },
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Nilai'
                }
            },
            series: [{
                name: "pH air",
                data: []
            }, {
                name: "ppm",
                data: []
            }]
        });

        chartBaro = Highcharts.chart('barometer', {
            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false,
                height: '80%',
                events: {
                    load: grafik
                }
            },

            title: {
                text: 'Grafik Montoring Debit Air'
            },

            pane: {
                startAngle: -90,
                endAngle: 89.9,
                background: null,
                center: ['50%', '75%'],
                size: '110%'
            },

            // the value axis
            yAxis: {
                min: 0,
                max: 3000,
                tickPixelInterval: 72,
                tickPosition: 'inside',
                tickColor: Highcharts.defaultOptions.chart.backgroundColor || '#FFFFFF',
                tickLength: 20,
                tickWidth: 2,
                minorTickInterval: null,
                labels: {
                    distance: 20,
                    style: {
                        fontSize: '14px'
                    }
                },
                lineWidth: 0,
                plotBands: [{
                    from: 0,
                    to: 2000,
                    color: '#55BF3B', // green
                    thickness: 20
                }, {
                    from: 2000,
                    to: 7000,
                    color: '#DDDF0D', // yellow
                    thickness: 20
                }, {
                    from: 2700,
                    to: 3000,
                    color: '#DF5353', // red
                    thickness: 20
                }]
            },
            series: [{
                name: 'Debit',
                tooltip: {
                    valueSuffix: ' liter/detik'
                },
                dataLabels: {
                    format: '{y} liter/detik',
                    borderWidth: 0,
                    color: (
                        Highcharts.defaultOptions.title &&
                        Highcharts.defaultOptions.title.style &&
                        Highcharts.defaultOptions.title.style.color
                    ) || '#333333',
                    style: {
                        fontSize: '16px'
                    }
                },
                dial: {
                    radius: '80%',
                    backgroundColor: 'gray',
                    baseWidth: 12,
                    baseLength: '0%',
                    rearLength: '0%'
                },
                pivot: {
                    backgroundColor: 'gray',
                    radius: 6
                }
            }]
        });

        realtime();
    });
</script>