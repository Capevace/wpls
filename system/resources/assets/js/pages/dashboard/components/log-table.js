import LogEntry from './log-entry';

const LogTable = {
    template: `
		<table class="table is-fullwidth is-striped">
			<thead>
				<tr>
					<th>Date</th>
					<th>Slug</th>
					<th>Type</th>
					<th>License</th>
					<th>Error</th>
					<th>Meta</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Date</th>
					<th>Slug</th>
					<th>Type</th>
					<th>License</th>
					<th>Error</th>
					<th>Meta</th>
				</tr>
			</tfoot>
			<tbody>
				<log-entry v-for="log in logs" :log="log"></log-entry>
			</tbody>
		</table>
	`,
    props: ['logs'],
    components: {
        'log-entry': LogEntry
    }
};

export default LogTable;
