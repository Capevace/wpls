import { getLicenses } from '../../http';
import debounce from 'lodash.debounce';

import NewLicensePopup from './components/new-license-popup';
import InvalidationPopup from './components/invalidation-popup';
import LicenseTable from './components/license-table';

const LicensesPage = {
    template: `
		<wpls-page title="Licenses">
            <template slot="level-right">
                <div class="level-item">
					<div class="level-item"><a class="button is-outlined" @click="toggleInvalidatePopup">Invalidate Envato Purchase Code</a></div>
				</div>
				<div class="level-item">
					<div class="level-item"><a class="button is-info" @click="togglePopup">Add New License</a></div>
				</div>
            </template>

			<div class="level">
				<div class="level-left">
					<div class="level-item">
						<div class="field">
							<label class="label">
								Limit
							</label>
							<input type="number" class="input" v-model="limit" min="0" :disabled="loading" @input="fetchLicensesCallback"/>
						</div>
					</div>
				</div>
				<div class="level-right">
					<div class="level-item">
						<div class="field">
							<label class="label">
								Search for Key:
							</label>
							<input type="text" class="input" v-model="search" min="0" :disabled="loading" @input="fetchLicensesCallback"/>
						</div>
					</div>
				</div>
			</div>
			<h3 class="subtitle is-3 has-text-centered" v-if="loading">Loading Licenses...</h3>
			<license-table :licenses="licenses" @actionSuccess="fetchLicenses" v-else></license-table>

			<new-license-popup :visible="popupVisible" @toggle="togglePopup" @success="newLicenseCreated"></new-license-popup>
			<invalidation-popup :visible="invalidatePopupVisible" @toggle="toggleInvalidatePopup" @success="purchaseCodeInvalidated"></invalidation-popup>
		</wpls-page>
	`,
    data() {
        return {
            popupVisible: false,
            invalidatePopupVisible: false,
            limit: 100,
            search: '',
            loading: false,
            licenses: []
        };
    },
    components: {
        'license-table': LicenseTable,
        'new-license-popup': NewLicensePopup,
        'invalidation-popup': InvalidationPopup
    },
    created() {
        this.fetchLicenses();
    },
    methods: {
        fetchLicenses() {
            this.loading = true;

            getLicenses(this.limit, this.search)
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.licenses = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message:
                            'Internal Server Error. Check the MySQL Credentials.',
                        type: 'is-danger',
                        duration: 2000
                    });

                    this.licenses = [];
                });
        },
        fetchLicensesCallback: debounce(function() {
            this.fetchLicenses();
        }, 1000),

        togglePopup() {
            this.popupVisible = !this.popupVisible;
        },

        toggleInvalidatePopup() {
            this.invalidatePopupVisible = !this.invalidatePopupVisible;
        },

        newLicenseCreated() {
            this.togglePopup();
            this.fetchLicenses();
        },

        purchaseCodeInvalidated() {
            this.toggleInvalidatePopup();
            this.fetchLicenses();
        }
    }
};

export default LicensesPage;
