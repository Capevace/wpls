import Plugin from './components/plugin';

const PluginsPage = {
    template: `
        <div>
            <br>
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h1 class="title">Plugins</h1>
                    </div>
                </div>

                <div class="level-right">
                    <div class="level-item"><a class="button is-info" @click="toggleAddModal">Add New Plugin</a></div>
                </div>
            </div>
            <br>

            <plugin v-for="plugin in plugins" :plugin="plugin"></plugin>

            <div :class="{'modal': true, 'is-active': addModalVisible}">
                <div class="modal-background" @click="toggleAddModal"></div>
                <div class="modal-content">
                    <div class="card">
                        <div class="card-content">
                            <div class="content">
                                <h2>Adding new Plugins</h2>
                                <p>
                                    To add your plugin to the license server, upload the .zip file 
                                    with the plugin inside into the <strong><i>data/packages</i></strong> folder.<br>
                                    If you reload the plugins now, you should see the plugin showing up.                            
                                </p>
                                <p>
                                    If you only use the internal Database License Verification, then you're good to go.<br>
                                    However, if you want to use the Envato API Verification, you'll need to add the Envato Item ID to it.
                                    Once that is completed and saved, you'll now be able to verify your items purchases.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <button aria-label="close" class="modal-close is-large" @click="toggleAddModal"></button>
            </div>
        </div>
    `,
    data() {
        return {
            addModalVisible: false
        };
    },
    computed: {
        plugins() {
            return this.$store.state.plugins;
        }
    },
    components: {
        'plugin': Plugin
    },
    methods: {
        toggleAddModal() {
            this.addModalVisible = !this.addModalVisible;
        }
    }
};

export default PluginsPage;