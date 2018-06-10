export default {
    template: `
        <div class="level-right">
            <div class="level-item">
                <input class="input" type="text" placeholder="Envato Item ID" v-model="item" :disabled="loading" />
            </div>
            <div class="level-item">
                <button :class="{'button': true, 'is-infso': true, 'is-loading': loading}" :disabled="loading" @click="save">
                    Save Item ID
                </button>
            </div>
        </div>
    `,
    props: ['item-id', 'slug'],
    data(props) {
        return {
            item: (props.itemId || '') + ''
        };
    },
    computed: {
        loading() {
            return this.$store.state.itemIdFormLoading[this.slug];
        }
    },
    methods: {
        save() {
            this.$store.dispatch('updateEnvatoItemID', {
                slug: this.slug,
                itemId: this.item
            });
        }
    }
};;