import Plugin from './components/plugin';
import AddPackageModal from './components/add-package-modal';
import UpdatePackageModal from './components/update-package-modal';

const PluginsPage = {
    template: `
        <wpls-page title="Packages">
            <template slot="level-right">
                <div class="level-item"><a class="button is-info" @click="toggleAddModal">Add New Package</a></div>
            </template>

            <plugin v-for="plugin in plugins" :plugin="plugin" @updatePackage="updatePackage"></plugin>
            <add-package-modal :visible="addModalVisible" @toggle="toggleAddModal"></add-package-modal>
            <update-package-modal :visible="updateModalVisible" :package="updateModalPackage" @toggle="toggleUpdateModal"></update-package-modal>
        </wpls-page>
    `,
    data() {
        return {
            addModalVisible: false,
            updateModalVisible: false,
            updateModalPackage: null
        };
    },
    computed: {
        plugins() {
            return this.$store.state.plugins;
        }
    },
    components: {
        'plugin': Plugin,
        'add-package-modal': AddPackageModal,
        'update-package-modal': UpdatePackageModal
    },
    methods: {
        toggleAddModal() {
            this.addModalVisible = !this.addModalVisible;
        },
        toggleUpdateModal() {
            this.updateModalVisible = !this.updateModalVisible;
            this.updateModalPackage = null;
        },
        updatePackage(packageSlug) {
            this.updateModalVisible = true;
            this.updateModalPackage = packageSlug;
        }
    }
};

export default PluginsPage;