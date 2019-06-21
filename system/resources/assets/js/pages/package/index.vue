<template>
	<wpls-page :title="pageTitle" :subtitle="package ? package.slug + ' (' + package.version + ')' : 'Package'" back="/packages" :loading="loading">
        <template slot="level-right" v-if="package">
            <div class="level-item">
                <button class="button is-outlisned" @click="toggleUpdateModal">Update Package</button>
            </div>
            <div class="level-item">
                <button class="button is-dangesr is-outlined" @click="deletePackage">Delete Package</button>
            </div>
        </template>

        <template v-if="package">
            <div class="columns">
                <div class="column is-9">
                    <div class="columns">
                        <div class="column is-5">
                            <div class="notification">
                                <envato-item-id-form :item-id="package.envato_item_id" :package-slug="package.slug"></envato-item-id-form>
                            </div>
                        </div>
                        <div class="column is-7">
                            <div class="notification">
                                <license-test-form :package-slug="package.slug"></license-test-form>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-12">
                            <div class="notification">
                                <p class="title is-4">
                                    {{ statTitle }}
                                </p>
                                <data-table :data-url="dataUrl" :columns="dataColumns" :options="dataOptions"></data-table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="tile is-ancestor">
                        <div class="tile is-vertical">
                            <div class="tile">
                                <div class="tile is-parent is-vertical">
                                    <div class="tile is-child notification stat-counter">
                                        <div class="level">
                                            <div class="level-left">
                                                <div class="level-item">
                                                    <p class="title is-4">Sites</p>
                                                </div>
                                            </div>
                                            <div class="level-right">
                                                <div class="level-item">
                                                    <button class="button is-small" @click="showStats('sites')">View Sites</button>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="has-text-right count">
                                            {{ activationsCount }}
                                        </p>
                                    </div>
                                    <div class="tile is-child notification stat-counter">
                                        <div class="level">
                                            <div class="level-left">
                                                <div class="level-item">
                                                    <p class="title is-4">Licenses</p>
                                                </div>
                                            </div>
                                            <div class="level-right">
                                                <div class="level-item">
                                                    <button class="button is-small" @click="showStats('licenses')">View Licenses</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <p class="has-text-right count">
                                            {{ licensesCount }}
                                        </p>
                                    </div>
                                    <div class="tile is-child notification stat-counter">
                                        <div class="level">
                                            <div class="level-left">
                                                <div class="level-item">
                                                    <p class="title is-4">Activations</p>
                                                </div>
                                            </div>
                                            <div class="level-right">
                                                <div class="level-item">
                                                    <button class="button is-small" @click="showStats('activations')">View Activations</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <p class="has-text-right count">
                                            {{ activationsCount }}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div class="tile is-parent">
                                    <div class="tile is-child notification stat-counter">
                                        <p class="title is-4">
                                            Total Activations
                                        </p>
                                        <p class="has-text-right count">
                                            {{ activationsCount }}
                                        </p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <update-package-modal 
                :visible="updateModalVisible"
                :package="package" 
                @toggle="toggleUpdateModal">
            </update-package-modal>
        </template>
    </wpls-page>
</template>
<script type="text/javascript">
import { apiUrl } from '../../config';
import { getPackage, deletePackage } from '../../http';
import EnvatoItemIdForm from './components/envato-item-id-form';
import LicenseTestForm from './components/license-test-form';
import UpdatePackageModal from './components/update-package-modal';

import DataTable from '../../components/data-table';

export default {
    data() {
        return {
            loading: false,
            package: null,
            licensesCount: 0,
            activationsCount: 0,
            updateModalVisible: false,
            currentStat: 'sites'
        };
    },
    async mounted() {
        this.loading = true;

        try {
            const response = await getPackage(this.$route.params.slug);
            this.package = response.data.package;
            this.licensesCount = response.data.licenses_count;
            this.activationsCount = response.data.activations_count;
        } catch (e) {
            this.package = null;
            this.licensesCount = 0;
            this.activationsCount = 0;
            console.log(e);
        }

        this.loading = false;
    },
    computed: {
        pageTitle() {
            return this.loading
                ? 'Loading...'
                : !this.package
                    ? 'Not Found'
                    : this.package.name;
        },
        statTitle() {
            switch(this.currentStat) {
                case 'sites':
                    return 'Activated Sites';
                case 'licenses':
                    return 'Licenses';
                case 'activations':
                    return 'Activations';
            }
        },
        dataUrl() {
            console.log(apiUrl);
            switch (this.currentStat) {
                case 'sites':
                    return `${apiUrl}/packages/${this.package.slug}/sites`;
                case 'licenses':
                    return `${apiUrl}/packages/${this.package.slug}/licenses`;
                case 'activations':
                    return `${apiUrl}/packages/${this.package.slug}/activations`;
            }
        },
        dataColumns() {
            switch (this.currentStat) {
                case 'sites':
                    return [
                        { title: 'ID', path: 'id', columnClass: 'is-size-7' },
                        { title: 'URL', path: 'url' },
                        { title: 'Package Version', path: 'last_package_version' },
                        { title: 'WP Version', path: 'last_wp_version' },
                        { title: 'PHP Version', path: 'last_php_version' },
                        { title: 'Updated At', path: 'updated_at', type: 'datetime' }
                    ];
                case 'licenses':
                    return [
                        { title: 'ID', path: 'id', columnClass: 'is-size-7' },
                        { title: 'License Key', path: 'license_key', component: {
                            template: `<a @click="alert">{{ entry.license_key | limit(10, '...') }}</a>`,
                            methods: { alert: function() {alert(this.entry.license_key);} }
                        }},
                        { title: 'Supported Until', path: 'supported_until', type: 'date' },
                        { title: 'Type', path: 'is_purchase_code', component: {
                            template: `<span>{{ entry.is_purchase_code ? 'Purchase Code' : 'Custom License' }}</span>`
                        }},
                        { title: 'Max Activations', path: 'max_activations' },
                        { title: 'Updated At', path: 'updated_at', type: 'datetime' },
                    ];
                case 'activations':
                    return [
                        { title: 'ID', path: 'id', columnClass: 'is-size-7' },
                        { title: 'Site URL', path: 'url' },
                        { title: 'License Key', path: 'license_key', component: {
                            template: `<a @click="alert">{{ entry.license_key | limit(30, '...') }}</a>`,
                            methods: { alert: function() {alert(this.entry.license_key);} }
                        }},
                        { title: 'Updated At', path: 'updated_at', type: 'datetime' }
                    ];
            }
        },
        dataOptions() {
            const options = { classes: { table: 'table is-fullwidth is-striped' } };

            switch (this.currentStat) {
                case 'sites':
                    return {
                        ...options,
                        searchKey: 'url'
                    };
                case 'licenses':
                    return {
                        ...options,
                        searchKey: 'license_key'
                    };
                case 'activations':
                    return {
                        ...options,
                        searchKey: ''
                    };
            }
        }
    },
    components: {
        'envato-item-id-form': EnvatoItemIdForm,
        'license-test-form': LicenseTestForm,
        'update-package-modal': UpdatePackageModal,
        'data-table': DataTable
    },
    methods: {
        toggleUpdateModal() {
            this.updateModalVisible = !this.updateModalVisible;
        },
        showStats(stat) {
            this.currentStat = stat;
        },
        deletePackage() {
            const shouldDelete = confirm('Do you really want to delete that package? This will delete any licenses and activations linked to that package!');
            
            if (shouldDelete)
                deletePackage(this.package.slug)
                    .then(response => {
                        console.log(response);

                        this.$router.push('/packages');
                        this.$store.dispatch('refreshPackages');
                        this.$store.dispatch('pushNotification', {
                            message: 'Successfully deleted package.',
                            type: 'is-success',
                            duration: 2000
                        });
                    })
                    .catch(error => {
                        console.log(error);
                        let errorMessage = 'An unknown error occurred.';

                        if (error.response.data.error)
                            errorMessage = error.response.data.error.message;

                        this.$store.dispatch('pushNotification', {
                            message: errorMessage,
                            type: 'is-danger',
                            duration: 2000
                        });
                    }); 
            }
        }
};
</script>