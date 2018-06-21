import MarkdownEditor from './markdown-editor';
import { announcementTypeToModifierClass } from '../utils';
import PluginSelect from './plugin-select';

const AnnouncementEditor = {
    template: `
        <div>
            <form @submit.prevent="save">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Title</label>
                            <div class="control">
                                <input class="input" v-model="title" placeholder="Announcement Title" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Type</label>
                                    <div :class="typeInputClassName">
                                        <select v-model="type" required>
                                            <option value="default" selected>Default</option>
                                            <option value="info">Info</option>
                                            <option value="success">Success</option>
                                            <option value="warning">Warning</option>
                                            <option value="error">Error</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Packages (multiple)</label>
                                    <plugin-select v-model="packages" multiple></plugin-select>
                                </div>
                            </div>
                            <!--<div class="column">
                                <div class="field">
                                    <label class="label">Activation-Exclusive</label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="checkbox" />
                                        Exclusive
                                    </label>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>

                <markdown-editor v-model="content" required for-announcements :announcement-type="type"></markdown-editor>

                <div class="field">
                    <button class="button is-info" type="submit" ref="submitButton">Post Announcement</button>
                </div>
            </form>
        </div>
    `,
    data() {
        return {
            title: '',
            type: 'default',
            packages: [],
            content: ''
        };
    },
    computed: {
        typeInputClassName() {
            return {
                'select is-fullwidth': true,
                [announcementTypeToModifierClass(this.type)]: true
            };
        }
    },
    methods: {
        forceSubmit() {
            this.$refs.submitButton.click();
        },
        save() {
            this.$emit('save', {
                title: this.title,
                type: this.type,
                packages: this.packages.map(p => this.$store.state.plugins[p].id),
                content: this.content
            });
        }
    },
    components: {
        'markdown-editor': MarkdownEditor,
        'plugin-select': PluginSelect
    }
};

export default AnnouncementEditor;
