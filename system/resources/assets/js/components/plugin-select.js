export default {
    template: `
        <div class="select is-fullwidth">
            <select v-model="val" required :disabled="disabled">
                <option v-for="plugin in plugins" :value="plugin.slug" >{{ plugin.slug }}</option>
            </select>
        </div>
    `,
    props: ['disabled', 'value'],
    data() {
        return {
            val: this.value
        };
    },
    watch: {
        val(newValue) {
            this.$emit('input', newValue);
        }
    },
    computed: {
        plugins() {
            return this.$store.state.plugins;
        }
    }
}