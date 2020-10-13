Highcharts.chart('graf1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Postotak uhvaćenih riba'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        series: {
            cursor: 'pointer',
            point: {
                events: {
                    click: function() {
                        location.href='/riba/index'; //ovo vodi na stranicu gdje će biti prikazane slike riba i opis riba 
                        //location.href='/riba/promjena?sifra=' + this.options.sifra; -->ovo vodi direktno na promjenu određene vrste ribe
                    }
                }
            }
        },
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f} %)'
            }
        }
    },
    series: [{
        name: 'Ribe',
        colorByPoint: true,
        data: podaci
    }]
});




