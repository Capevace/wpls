import { getActivations } from '../../http';
import debounce from 'lodash.debounce';

import ActivationsTable from './components/activations-table';

const DashboardPage = {
    template: `
		<wpls-page title="Dashboard">
			<h4 class="title is-4">
				Activations from
				<input type="date" class="input is-inline" v-model="dateFrom" :max="dateUntil" :disabled="loading" @input="fetchActivationsCallback"/>
				until
				<input type="date" class="input is-inline" v-model="dateUntil" :min="dateFrom" :disabled="loading" @input="fetchActivationsCallback"/>
			</h4>
			<h3 class="subtitle is-3 has-text-centered" v-if="loading">Loading Activations...</h3>
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
                            'Internal Server Error. Check the MySQL Credentials.',
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

export default DashboardPage;
