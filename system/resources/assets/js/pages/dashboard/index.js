import { getLogs } from '../../http';
import debounce from 'lodash.debounce';

import LogsTable from './components/log-table';

const DashboardPage = {
    template: `
		<wpls-page title="Dashboard">
			<h4 class="title is-4">
				Logs from
				<input type="date" class="input is-inline" v-model="dateFrom" :max="dateUntil" :disabled="loading" @input="fetchLogsCallback"/>
				until
				<input type="date" class="input is-inline" v-model="dateUntil" :max="dateFrom" :disabled="loading" @input="fetchLogsCallback"/>
			</h4>
			<h3 class="subtitle is-3 has-text-centered" v-if="loading">Loading Logs...</h3>
			<logs-table :logs="logs" v-else></logs-table>
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
            logs: []
        };
    },
    components: {
        'logs-table': LogsTable
    },
    created() {
        this.fetchLogs();
    },
    methods: {
        fetchLogs() {
            this.loading = true;

            getLogs(this.dateFrom, this.dateUntil)
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.logs = response.data;
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

                    this.logs = [];
                });
        },
        fetchLogsCallback: debounce(function() {
            this.fetchLogs();
        }, 1000)
    }
};

export default DashboardPage;
