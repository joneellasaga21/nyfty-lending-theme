function getSubtitle() {
    //const totalNumber = getData(input.value)[0][1].toFixed(2);
    const totalNumber = '1234'
    return `<span style="font-size: 20px;width: 100px;">Your Payment</span> 
    		<br/>
        <span style="font-size: 22px">
            Total: <b> ${totalNumber}</b> TWh
        </span>`;
}
Highcharts.chart('container', {
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    subtitle: {
        useHTML: true,
        text: getSubtitle(),
        floating: true,
        verticalAlign: 'middle',
        y: 0
    },
    legend: {
        useHTML: true,
        labelFormatter: function() {
            var legendItem = document.createElement('div'),
                symbol = document.createElement('span'),
                label = document.createElement('span');

            symbol.innerText = this.y.toFixed(2);
            symbol.style.borderColor = this.color;
            symbol.classList.add('xLegendSymbol');
            label.innerText = this.name;

            legendItem.appendChild(symbol);
            legendItem.appendChild(label);

            return legendItem.outerHTML;
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        innerSize: '90%',
        data: [
            ['Chrome', 58.9],
            ['Firefox', 33.29],
            ['Internet Explorer', 13]
        ]
    }]
});
