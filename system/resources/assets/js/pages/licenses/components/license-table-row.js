import FormattedCustomerContainer from '../../../components/formatted-customer-container';
import LicenseActionButton from './license-action-button';

const LicenseTableRow = {
    template: `
		<tr>
			<td style="cursor: pointer;" @click="alertFullLicense(license.license)">{{ limitedLicense }}</td>
			<td>{{ license.slug }}</td>
			<td :class="supportedUntilClass">{{ supportedUntil }}</td>
			<td>
				<customer :customer="customer"></customer>
			</td>
			<td>
				<div :class="{'field is-pulled-right': true, 'has-addons': supported}">
					<p class="control" v-if="supported">
						<action-button :id="license.id" action="invalidate" @success="onActionSuccess">Invalidate</action-button>
					</p>
					<p class="control">
						<action-button :id="license.id" action="delete" @success="onActionSuccess">Delete</action-button>
					</p>
				</div>
			</td>
		</tr>
	`,
    props: ['license'],
    computed: {
        limitedLicense() {
            if (this.license.license.length > 32)
                return this.license.license.substr(0, 32) + '...';
            return this.license.license;
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
        },
        customer() {
            if (!this.license.customer) return null;

            try {
                return JSON.parse(this.license.customer);
            } catch (e) {
                return null;
            }
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
