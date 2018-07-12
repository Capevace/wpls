export default {
    template: `
        <form @submit.prevent="save">
            <div class="level" style="margin-bottom: 0px">
                <div class="level-left">
                    <div class="level-item">
                        <p class="title is-4">Envato ID</p>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <button class="button is-small" :disabled="loading">Save Envato ID</button>
                    </div>
                </div>
            </div>
            <p class="subtitle">Change the Envato ID used.</p>

            <div class="field">
                <label class="label">Envato ID</label>
                <input class="input" type="number" placeholder="Envato ID for your package" v-model="envatoItemId" :disabled="loading"/>
            </div>
        
        </form>
    `,
    props: ['item-id', 'package-slug'],
    data(props) {
        return {
            envatoItemId: (props.itemId || '') + ''
        };
    },
    computed: {
        loading() {
            return this.$store.state.itemIdFormLoading[this.packageSlug];
        }
    },
    methods: {
        save() {
            this.$store.dispatch('updateEnvatoItemID', {
                slug: this.packageSlug,
                itemId: this.envatoItemId
            });
        }
    }
};;