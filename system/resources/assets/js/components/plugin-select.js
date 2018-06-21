export default {
    template: `
        <div :class="{'select is-fullwidth package-select': true, 'is-multiple': multiple !== undefined}">
            <div class="field is-fullwidth" v-if="multiple !== undefined">
                <p class="control has-icons-right">
                    <input class="input package-select-input" :value="inputValue" required readonly @focus="focusedInput = true" @blur="focusedInput = false">
                    <span class="icon is-small is-right">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </p>
            </div>
            <div :style="dropdownVisible ? '' : 'opacity: 0;height: 0;'">
                <select 
                    v-model="val" 
                    required
                    :disabled="disabled" 
                    :multiple="multiple" 
                    :class="{'package-select-multiple': multiple !== undefined}"
                    @focus="focusedSelect = true" 
                    @blur="focusedSelect = false"
                >
                    <option v-for="plugin in plugins" :value="plugin.slug" >{{ plugin.name }}</option>
                </select>
            </div>
        </div>
    `,
    props: ['disabled', 'value', 'multiple'],
    data() {
        return {
            val: this.value,
            focusedInput: false,
            focusedSelect: false
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
        },
        dropdownVisible() {
            return this.multiple === undefined || (
                this.multiple !== undefined && (
                    this.focusedInput || this.focusedSelect
                )
            );
        },
        inputValue() {
            return this.val.map(p => this.plugins[p].name);
        }
    },
    methods: {
    }
}