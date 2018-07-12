import { testLicense } from '../../../http';

export default {
    template: `
        <form>
            <div class="level" style="margin-bottom: 0px">
                <div class="level-left">
                    <div class="level-item">
                        <p class="title is-4">Test License</p>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <button class="button is-small" @click="save" :disabled="loading">Check License</button>
                    </div>
                </div>
            </div>
            <p class="subtitle">Check if a license is valid.</p>

            <div class="field">
                <label class="label">License to Verify</label>
                <input class="input" type="text" placeholder="Purchase code or custom license" v-model="license" :disabled="loading"/>
            </div>
        
        </form>
    `,
    props: ['package-slug'],
    data(props) {
        return {
            license: '',
            loading: false
        };
    },
    methods: {
        save() {
            this.loading = true;

            testLicense(this.license, this.packageSlug)
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    if (response.data.valid) {
                        this.$store.dispatch('pushNotification', {
                            message: 'Successfully verified license.',
                            type: 'is-success',
                            duration: 2000
                        });
                    } else {
                        this.$store.dispatch('pushNotification', {
                            message: 'An unknown error occurred.',
                            type: 'is-danger',
                            duration: 2000
                        });
                    }
                })
                .catch(error => {
                    console.log(JSON.stringify(error.response));
                    this.loading = false;

                    let errorMessage = 'An unknown error occurred.';
                    const responseData = error.response.data;

                    if (responseData.message)
                        errorMessage = responseData.message;
                    else if (responseData.error && responseData.error.message)
                        errorMessage = responseData.error.message;

                    this.$store.dispatch('pushNotification', {
                        message: errorMessage,
                        type: 'is-danger',
                        duration: 2000
                    });
                });
        }
    }
};