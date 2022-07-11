const chart = new Chartisan({
    el: '#HistoryChartContainer',
    url: "@chart('history_chart')",
    hooks: new ChartisanHooks()
    .colors()
    .datasets('scatter'),
});

const chart1 = new Chartisan({
    el: '#HistoryChartContainer1',
    url: "@chart('history_chart1')",
    hooks: new ChartisanHooks()
    .colors()
    .datasets('scatter'),
})