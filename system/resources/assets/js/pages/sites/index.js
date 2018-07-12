import { sitesDataUrl } from '../../http';
import DataTable from '../../components/data-table';

export default {
    template: `
        <wpls-page title="Registered Sites">
            <data-table :data-url="dataUrl" :columns="dataColumns" :options="dataOptions" ref="sitesDataTable"></data-table>
        </wpls-page>
    `,
    components: {
        'data-table': DataTable
    },
    computed: {
        dataUrl() {
            return sitesDataUrl;
        },
        dataColumns() {
            return [
                { title: 'ID', path: 'id', columnClass: 'is-size-7' },
                { title: 'URL', path: 'url' },
                { title: 'Package Version', path: 'last_package_version' },
                { title: 'WP Version', path: 'last_wp_version' },
                { title: 'PHP Version', path: 'last_php_version' },
                { title: 'Updated At', path: 'updated_at', type: 'datetime' }
            ];
        },
        dataOptions() {
            return { 
                classes: { 
                    table: 'table is-fullwidth is-striped'
                },
                searchKey: 'url',
                orderBy: 'url'
            };
        }
    },
};