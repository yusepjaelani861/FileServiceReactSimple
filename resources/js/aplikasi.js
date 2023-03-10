require('./bootstrap');

import Alpine from 'alpinejs';
import Clipboard from "@ryangjchandler/alpine-clipboard";
import { Chart } from 'chart.js';
import analyticsCard01 from './components/analytics-card-01';
import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '../../tailwind.config';

window.Alpine = Alpine;
Alpine.start();
Alpine.plugin(Clipboard);

const fullConfig = resolveConfig(tailwindConfig);

Chart.defaults.font.family = '"Inter", sans-serif';
Chart.defaults.font.weight = '500';
Chart.defaults.color = fullConfig.theme.colors.slate[400];
Chart.defaults.scale.grid.color = fullConfig.theme.colors.slate[100];
Chart.defaults.plugins.tooltip.titleColor = fullConfig.theme.colors.slate[800];
Chart.defaults.plugins.tooltip.bodyColor = fullConfig.theme.colors.slate[800];
Chart.defaults.plugins.tooltip.backgroundColor = fullConfig.theme.colors.white;
Chart.defaults.plugins.tooltip.borderWidth = 1;
Chart.defaults.plugins.tooltip.borderColor = fullConfig.theme.colors.slate[200];
Chart.defaults.plugins.tooltip.displayColors = false;
Chart.defaults.plugins.tooltip.mode = 'nearest';
Chart.defaults.plugins.tooltip.intersect = false;
Chart.defaults.plugins.tooltip.position = 'nearest';
Chart.defaults.plugins.tooltip.caretSize = 0;
Chart.defaults.plugins.tooltip.caretPadding = 20;
Chart.defaults.plugins.tooltip.cornerRadius = 4;
Chart.defaults.plugins.tooltip.padding = 8;

Chart.register({
    id: 'chartAreaPlugin',
    beforeDraw: (chart) => {
		if (chart.config.options.chartArea && chart.config.options.chartArea.backgroundColor) {
			const ctx = chart.canvas.getContext('2d');
			const { chartArea } = chart;
			ctx.save();
			ctx.fillStyle = chart.config.options.chartArea.backgroundColor;
			ctx.fillRect(chartArea.left, chartArea.top, chartArea.right - chartArea.left, chartArea.bottom - chartArea.top);
			ctx.restore();
		}
    },
});

window.statsChart = (foo = null) => {
	return analyticsCard01(foo);
}
