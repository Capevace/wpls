import { postLicenseAction } from '../../../http';

const LicenseActionButton = {
    template: `
		<button @click.prevent="doAction" :class="buttonClass" :disabled="loading">
			<slot></slot>
		</button>
	`,
    data: () => ({
        loading: false
    }),
    props: ['id', 'action'],
    methods: {
        doAction() {
            this.loading = true;

            postLicenseAction(this.id, this.action)
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.$emit('success');
                    this.$store.dispatch('pushNotification', {
                        message: 'Successfully invalidated license.',
                        type: 'is-success',
                        duration: 2000
                    });
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message: 'Unknown Error.',
                        type: 'is-danger',
                        duration: 2000
                    });
                });
        }
    },
    computed: {
        buttonClass() {
            return {
                'button is-outlined is-small': true,
                'is-danger': this.action === 'delete',
                'is-warning  is-inverted': this.action === 'invalidate',
                'is-loading': this.loading
            };
        }
    }
};

export default LicenseActionButton;
