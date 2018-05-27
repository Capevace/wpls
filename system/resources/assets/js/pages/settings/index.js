import AdminSettings from './components/admin-settings';
import LicenseSettings from './components/license-settings';
import MySQLSettings from './components/mysql-settings';

export default {
    template: `
        <wpls-page title="Settings">
            <template slot="level-right">
                <div class="level-item">
                    <button :class="{'button': true, 'is-info': true, 'is-loading': saving }" @click="save" :disabled="saving">Save Changes</button>
                </div>
            </template>

            <div class="tabs is-info is-centered is-toggle-round">
                <ul>
                    <!--<li class="is-active">
                        <a @click="goToTab('general')">General</a>
                    </li>-->
                    <li :class="isActiveTab('license')">
                        <a @click="goToTab('license')">License Verification</a>
                    </li>
                    <li :class="isActiveTab('mysql')">
                        <a @click="goToTab('mysql')">MySQL</a>
                    </li>
                    <li :class="isActiveTab('admin')">
                        <a @click="goToTab('admin')">Admin Login</a>
                    </li>
                </ul>
            </div>
            

            <div style="margin-bottom: 40px;">
                <license-settings v-if="activeTab === 'license'" :config="config"></license-settings>
                <mysql-settings v-else-if="activeTab === 'mysql'" :config="config"></mysql-settings>
                <admin-settings v-else-if="activeTab === 'admin'" :config="config"></admin-settings>
            </div>

            <button :class="{'button': true, 'is-info': true, 'is-loading': saving }" @click="save" :disabled="saving">Save Settings</button>
        </wpls-page>
    `,
    data() {
        return {
            activeTab: 'license',
            config: null
        };
    },
    created() {
        this.config = this.$store.state.config;
    },
    components: {
        'admin-settings': AdminSettings,
        'license-settings': LicenseSettings,
        'mysql-settings': MySQLSettings
    },
    methods: {
        goToTab(tab) {
            this.activeTab = tab;
        },
        isActiveTab(tab) {
            return {
                'is-active': this.activeTab === tab
            };
        },
        save() {
            this.$store.dispatch('updateConfig', this.config);
        }
    },
    computed: {
        saving() {
            return this.$store.state.savingConfig;
        }
    }
};