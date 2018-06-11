import { updatePackage } from '../../../http';

export default {
    template: `
        <div v-if="visible && package" :class="{'modal': true, 'is-active': visible}">
            <div class="modal-background" @click="toggleModal"></div>
            <div class="modal-content">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <h2>Update <i>{{ package.name }}</i></h2>
                            <form @submit.prevent="updatePackage">
                                <div class="field">
                                    <label class="label">Package .zip File</label>
                                    <div class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" v-on:change="handlePackageUpload" :disabled="loading" accept=".zip" required>
                                            <span class="file-cta">
                                                <span class="file-icon">
                                                    <i class="fas fa-upload"></i>
                                                </span>
                                                <span class="file-label">
                                                    Choose a .zip file…
                                                </span>
                                            </span>
                                            <span class="file-name">
                                                {{ packageFile.name ? packageFile.name : 'No file selected' }}
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="level">
                                    <div class="level-left"></div>
                                    <div class="level-right">
                                        <div class="level-item">
                                            <button :class="{'button is-info': true, 'is-loading': loading}" type="submit" :disabled="loading">Update Package</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <button aria-label="close" class="modal-close is-large" @click="toggleModal"></button>
        </div>
    `,
    props: ['visible', 'package'],
    data: () => ({
        loading: false,
        packageFile: ''
    }),
    methods: {
        toggleModal() {
            this.$emit('toggle');
        },

        updatePackage() {
            this.loading = true;
            let formData = new FormData();

            formData.append('package', this.packageFile);

            updatePackage(this.package.slug, formData)
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.$store.dispatch('refreshPackages');
                    this.$store.dispatch('pushNotification', {
                        message: 'Successfully updated package.',
                        type: 'is-success',
                        duration: 2000
                    });
                    this.toggleModal();
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
                    this.toggleModal();
                });                
        },
        handlePackageUpload(e) {
            this.packageFile = e.target.files[0];
        }
    }
};