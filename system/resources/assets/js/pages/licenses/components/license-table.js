import LicenseTableRow from './license-table-row';
import LicensePopup from './license-popup';

const LicenseTable = {
    template: `
		<div>
			<table class="table is-fullwidth is-striped">
				<thead>
					<tr>
						<th>License</th>
						<th>Slug</th>
						<th>Supported Until</th>
						<th>Customer Info</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>License</th>
						<th>Slug</th>
						<th>Supported Until</th>
						<th>Customer Info</th>
						<th>Actions</th>
					</tr>
				</tfoot>
				<tbody>
					<license-table-row v-for="license in licenses" :license="license" @actionSuccess="onActionSuccess" @open="openPopup"></license-table-row>
				</tbody>
			</table>

			<license-popup :visible="popupVisible" :license="popupLicense" @toggle="closePopup"></license-popup>
		</div>
	`,
    data() {
        return {
            popupVisible: false,
            popupLicense: ''
        };
    },
    props: ['licenses'],
    components: {
        'license-table-row': LicenseTableRow,
        'license-popup': LicensePopup
    },
    methods: {
        openPopup(license) {
            this.popupLicense = license;
            this.popupVisible = true;
        },
        closePopup() {
            this.popupVisible = false;
        },
        onActionSuccess() {
            this.$emit('actionSuccess');
        }
    }
};

export default LicenseTable;
