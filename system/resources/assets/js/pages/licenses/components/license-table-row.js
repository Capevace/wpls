import FormattedCustomerContainer from '../../../components/formatted-customer-container';
import LicenseActionButton from './license-action-button';

const LicenseTableRow = {
    template: `
		<tr>
			<td style="cursor: pointer;" @click="alertFullLicense(license.license_key)">{{ limitedLicense }}</td>
			<td>{{ license.package_slug }}</td>
			<td :class="supportedUntilClass">{{ supportedUntil }}</td>
			<td>
				<customer :customer="license.customer_data"></customer>
			</td>
			<td>
				<div :class="{'field is-pulled-right': true, 'has-addons': supported}">
					<p class="control" v-if="supported">
						<action-button :license-key="license.license_key" action="invalidate" @success="onActionSuccess">Invalidate</action-button>
					</p>
					<p class="control">
						<action-button :license-key="license.license_key" action="delete" @success="onActionSuccess">Delete</action-button>
					</p>
				</div>
			</td>
		</tr>
	`,
    props: ['license'],
    computed: {
        limitedLicense() {
            if (this.license.license_key.length > 32)
                return this.license.license_key.substr(0, 32) + '...';
            return this.license.license_key;
        },
        supported() {
            return (
                new Date(this.license.supported_until).getTime() > Date.now()
            );
        },
        supportedUntil() {
            const date = new Date(this.license.supported_until);
            return date.toLocaleDateString();
        },
        supportedUntilClass() {
            return {
                'has-text-success': this.supported,
                'has-text-danger': !this.supported
            };
        }
    },
    methods: {
        alertFullLicense(license) {
            this.$emit('open', license);
        },

        onActionSuccess() {
            this.$emit('actionSuccess');
        }
    },
    components: {
        customer: FormattedCustomerContainer,
        'action-button': LicenseActionButton
    }
};

export default LicenseTableRow;
