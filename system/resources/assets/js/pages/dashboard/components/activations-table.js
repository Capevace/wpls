import ActivationEntry from './activation-entry';

const ActivationsTable = {
    template: `
		<table class="table is-fullwidth is-striped">
			<thead>
				<tr>
					<th>Date</th>
					<th>Package</th>
					<th>License</th>
					<th>Site</th>
					<th>Metadata</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Date</th>
					<th>Package</th>
					<th>License</th>
					<th>Site</th>
					<th>Metadata</th>
				</tr>
			</tfoot>
			<tbody>
				<activation-entry v-for="activation in activations" :activation="activation"></activation-entry>
			</tbody>
		</table>
	`,
    props: ['activations'],
    components: {
        'activation-entry': ActivationEntry
    }
};

export default ActivationsTable;
