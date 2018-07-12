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
                        <button class="button is-inverted is-small" @click="openPackage">View Package</button>
                    </div>
                </div>
            </div>
        </div>
    `,
    props: ['plugin'],
    methods: {
        openPackage() {
            this.$router.push('/packages/' + this.plugin.slug);
        },
    }
};