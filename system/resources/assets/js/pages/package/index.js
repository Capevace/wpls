import { getPackage } from '../../http';

export default {
    template: `
        <wpls-page :title="pageTitle" :subtitle="package ? package.slug + ' (' + package.version + ')' : ''" back="/packages">
            <template slot="level-right">
                <div class="level-item">
                    <button class="button is-outlisned">Update Package</button>
                </div>
                <div class="level-item">
                    <button class="button is-dangesr is-outlined">Delete Package</button>
                </div>
            </template>

            <div class="columns">
                <div class="column is-3">
                    <div class="tile is-ancestor">
                        <div class="tile is-vertical">
                            <div class="tile">
                                <div class="tile is-parent is-vertical">
                                    <div class="tile is-child notification stat-counter">
                                        <p class="title is-4">
                                            Total Licenses
                                        </p>
                                        
                                        <p class="has-text-right count">
                                            {{ licensesCount }}
                                        </p>
                                    </div>
                                    <div class="tile is-child notification stat-counter">
                                        <p class="title is-4">
                                            Total Activations
                                        </p>
                                        
                                        <p class="has-text-right count">
                                            {{ activationsCount }}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div class="tile is-parent">
                                    <div class="tile is-child notification stat-counter">
                                        <p class="title is-4">
                                            Total Activations
                                        </p>
                                        <p class="has-text-right count">
                                            {{ activationsCount }}
                                        </p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="notification">
                        <form>
                            <div class="level" style="margin-bottom: 0px">
                                <div class="level-left">
                                    <div class="level-item">
                                        <p class="title is-4">Envato ID</p>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <button class="button is-small">Save Envato ID</button>
                                    </div>
                                </div>
                            </div>
                            <p class="subtitle">Change the Envato ID used.</p>

                            <div class="field">
                                <label class="label">Envato ID</label>
                                <input class="input" type="number" placeholder="Envato ID for your package"/>
                            </div>
                        
                        </form>
                    </div>
                </div>
                <div class="column is-5">
                    <div class="notification">
                        <form>
                            <div class="level" style="margin-bottom: 0px">
                                <div class="level-left">
                                    <div class="level-item">
                                        <p class="title is-4">Test License</p>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <button class="button is-small">Check License</button>
                                    </div>
                                </div>
                            </div>
                            <p class="subtitle">Check if a license is valid.</p>

                            <div class="field">
                                <label class="label">License to Verify</label>
                                <input class="input" type="text" placeholder="Purchase code or custom license"/>
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </wpls-page>
    `,
    data() {
        return {
            loading: false,
            package: null,
            licensesCount: 0,
            activationsCount: 0
        };
    },
    async mounted() {
        this.loading = true;

        try {
            const response = await getPackage(this.$route.params.slug);
            this.package = response.data.package;
            this.licensesCount = response.data.licenses_count;
            this.activationsCount = response.data.activations_count;
        } catch (e) {
            this.package = null;
            this.licensesCount = 0;
            this.activationsCount = 0;
            console.log(e);
        }

        this.loading = false;
    },
    computed: {
        pageTitle() {
            return this.loading
                ? 'Loading...'
                : !this.package
                    ? 'Not Found'
                    : this.package.name;
        }
    },
    methods: {
        
    }
};