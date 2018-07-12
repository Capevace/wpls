import { activationsDataUrl } from '../../http';
import DataTable from '../../components/data-table';

export default {
    template: `
        <wpls-page title="Activations">
            <data-table :data-url="dataUrl" :columns="dataColumns" :options="dataOptions" ref="activationsDataTable"></data-table>
		</wpls-page>
	`,
    components: {
        'data-table': DataTable
    },
    computed: {
        dataUrl() {
            return activationsDataUrl;
        },
        dataColumns() {
            return [
                { title: 'ID', path: 'id', columnClass: 'is-size-7' },
                { title: 'Package', path: 'package_slug' },
                { title: 'Site URL', path: 'site_url' },
                { title: 'License Key (click to expand)', path: 'license_key', component: {
                    template: `<a @click="alert">{{ entry.license_key | limit(30, '...') }}</a>`,
                    methods: { alert: function() {alert(this.entry.license_key);} }
                }},
                { title: 'Updated At', path: 'updated_at', type: 'datetime' },
            ];
        },
        dataOptions() {
            return { 
                classes: { 
                    table: 'table is-fullwidth is-striped'
                },
                searchKey: 'license_key',
                orderBy: 'updated_at',
                orderType: 'desc',
            };
        }
    },
};