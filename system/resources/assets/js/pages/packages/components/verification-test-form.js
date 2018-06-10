import { testLicense } from '../../../http';

export default {
    template: `
        <div class="level-right">
            <div class="level-item">
                <input class="input" type="text" placeholder="Test License" v-model="license" :disabled="loading" />
            </div>
            <div class="level-item">
                <button :class="{'button': true, 'is-loading': loading}" :disabled="loading" @click="save">
                    Verify License
                </button>
            </div>
        </div>
    `,
    props: ['slug'],
    data(props) {
        return {
            license: '',
            loading: false
        };
    },
    methods: {
        save() {
            this.loading = true;

            testLicense(this.license, this.slug)
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
                    console.log(error);
                    this.loading = false;

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