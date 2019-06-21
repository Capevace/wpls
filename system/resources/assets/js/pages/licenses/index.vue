<template>
	<wpls-page title="Licenses">
		<template slot="level-right">
			<div class="level-item">
				<div class="level-item">
					<a class="button is-outlined" @click="toggleInvalidatePopup">
						Invalidate Envato Purchase Code
					</a>
				</div>
			</div>
			<div class="level-item">
				<div class="level-item">
					<a class="button is-info" @click="togglePopup">
						Add New License
					</a>
				</div>
			</div>
		</template>

		<data-table
			:data-url="dataUrl"
			:columns="dataColumns"
			:options="dataOptions"
			ref="licensesDataTable"
		></data-table>

		<new-license-popup
			:visible="popupVisible"
			@toggle="togglePopup"
			@success="newLicenseCreated"
		></new-license-popup>
		<invalidation-popup
			:visible="invalidatePopupVisible"
			@toggle="toggleInvalidatePopup"
			@success="purchaseCodeInvalidated"
		></invalidation-popup>
	</wpls-page>
</template>
<script type="text/javascript">
import { licensesDataUrl } from '../../http';
import NewLicensePopup from './components/new-license-popup';
import InvalidationPopup from './components/invalidation-popup';
import DataTable from '../../components/data-table';
import LicenseActionButtons from './components/license-action-buttons';

export default {
    data() {
        return {
            popupVisible: false,
            invalidatePopupVisible: false
        };
    },
    components: {
        'new-license-popup': NewLicensePopup,
        'invalidation-popup': InvalidationPopup,
        'data-table': DataTable
    },
    computed: {
        dataUrl() {
            return licensesDataUrl;
        },
        dataColumns() {
            return [
                { title: 'ID', path: 'id', columnClass: 'is-size-7' },
                { title: 'License Key (click to expand)', path: 'license_key', component: {
                    template: `<a @click="alert">{{ entry.license_key | limit(30, '...') }}</a>`,
                    methods: { alert: function() {alert(this.entry.license_key);} }
                }},
                { title: 'Package', path: 'package_slug' },
                { title: 'Supported Until', path: 'supported_until', type: 'date' },
                { title: 'Type', path: 'is_purchase_code', component: {
                    template: `<span>{{ entry.is_purchase_code ? 'Purchase Code' : 'Custom License' }}</span>`
                }},
                { title: 'Max Activations', path: 'max_activations' },
                { title: 'Updated At', path: 'updated_at', type: 'datetime' },
                { title: 'Actions', path: 'actions', component: Object.assign(LicenseActionButtons, {
                    methods: {
                        onActionSuccess: () => this.refreshDataTable()
                    }
                })},
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
    methods: {
        togglePopup() {
            this.popupVisible = !this.popupVisible;
        },

        toggleInvalidatePopup() {
            this.invalidatePopupVisible = !this.invalidatePopupVisible;
        },

        newLicenseCreated() {
            this.togglePopup();
            this.refreshDataTable();
        },

        purchaseCodeInvalidated() {
            this.toggleInvalidatePopup();
            this.refreshDataTable();
        },

        refreshDataTable() {
            this.$refs.licensesDataTable.refresh();
        }
    }
};
</script>
