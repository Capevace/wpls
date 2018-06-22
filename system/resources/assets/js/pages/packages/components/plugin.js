import ItemIDForm from './item-id-form';
import VerificationTestForm from './verification-test-form';

import { deletePackage } from '../../../http';

export default {
    template: `
        <div class="notification" @click="openPackage" style="cursor: pointer;">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h5 class="title is-5">{{ plugin.name }} ({{ plugin.version }})</h5>
                    </div>
                    <div class="level-item">
                        <h6 class="subtitle is-6">{{ plugin.slug }}</h6>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <button class="button is-inverted is-small" @click="$emit('updatePackage', plugin)">Update Package</button>
                    </div>
                    <div class="level-item">
                        <button class="button is-inverted is-small" @click="deletePackage">Delete Package</button>
                    </div>
                </div>
            </div>

            <div class="level">
                <item-id-form :item-id="plugin.envato_item_id" :slug="plugin.slug"></item-id-form>
                <verification-test-form :slug= "plugin.slug"></verification-test-form>
            </div>
        </div>
    `,
    props: ['plugin'],
    components: {
        'item-id-form': ItemIDForm,
        'verification-test-form': VerificationTestForm
    },
    methods: {
        openPackage() {
            this.$router.push('/packages/' + this.plugin.slug);
        },
        deletePackage() {
            const shouldDelete = confirm('Do you really want to delete that package? This will delete any licenses and activations linked to that package!');
            
            if (shouldDelete)
                deletePackage(this.plugin.slug)
                .then(response => {
                    console.log(response);

                    this.$store.dispatch('refreshPackages');
                    this.$store.dispatch('pushNotification', {
                        message: 'Successfully deleted package.',
                        type: 'is-success',
                        duration: 2000
                    });
                })
                .catch(error => {
                    console.log(error);
                    let errorMessage = 'An unknown error occurred.';

                    if (error.response.data.error)
                        errorMessage = error.response.data.error.message;

                    this.$store.dispatch('pushNotification', {
                        message: errorMessage,
                        type: 'is-danger',
                        duration: 2000
                    });
                }); 
        }
    }
};