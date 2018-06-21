import { getActivations } from '../../http';
import debounce from 'lodash.debounce';

import ActivationsTable from './components/activations-table';

const ActivationsPage = {
    template: `
        <wpls-page title="Activations">
            <div class="level">
				<div class="level-left">
					<div class="level-item">
						<div class="field">
							<label class="label">
								From
							</label>
							<input type="date" class="input" v-model="dateFrom" :max="dateUntil" :disabled="loading" @input="fetchActivationsCallback"/>
						</div>
                    </div>
                    <div class="level-item">
						<div class="field">
							<label class="label">
								Until
							</label>
							<input type="date" class="input" v-model="dateUntil" :min="dateFrom" :disabled="loading" @input="fetchActivationsCallback"/>
						</div>
					</div>
				</div>
			</div>
            
            <h3 class="subtitle is-3 has-text-centered" v-if="loading || activations.length === 0">
                {{ loading ? 'Loading Activations...' : 'No Activations found' }}
            </h3>

			<activations-table :activations="activations" v-else></activations-table>
		</wpls-page>
	`,
    data() {
        const then = new Date(Date.now() - 1000 * 60 * 60 * 24 * 30);
        const now = new Date();

        const formatMonth = month => {
            let monthNumber = month + 1;
            return monthNumber < 10
                ? '0' + String(monthNumber)
                : String(monthNumber);
        };

        return {
            dateFrom:
                then.getFullYear() +
                '-' +
                formatMonth(then.getMonth()) +
                '-' +
                then.getDate(),
            dateUntil:
                now.getFullYear() +
                '-' +
                formatMonth(now.getMonth()) +
                '-' +
                now.getDate(),
            loading: false,
            activations: []
        };
    },
    components: {
        'activations-table': ActivationsTable
    },
    created() {
        this.fetchActivations();
    },
    methods: {
        fetchActivations() {
            this.loading = true;

            getActivations(this.dateFrom, this.dateUntil)
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.activations = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message:
                            'Could not fetch activations.',
                        type: 'is-danger',
                        duration: 2000
                    });

                    this.activations = [];
                });
        },
        fetchActivationsCallback: debounce(function() {
            this.fetchActivations();
        }, 1000)
    }
};

export default ActivationsPage;
