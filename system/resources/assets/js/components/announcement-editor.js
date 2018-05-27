import MarkdownEditor from './markdown-editor';
import { announcementTypeToModifierClass } from '../utils';
import PluginSelect from './plugin-select';

const AnnouncementEditor = {
    template: `
        <form>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Title (optional)</label>
                        <div class="control">
                            <input class="input" placeholder="Announcement Title" type="text">
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Plugin</label>
                                <plugin-select v-model="plugin"></plugin-select>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Type</label>
                                <div :class="typeInputClassName">
                                    <select v-model="type">
                                        <option value="default" selected>Default</option>
                                        <option value="info">Info</option>
                                        <option value="success">Success</option>
                                        <option value="warning">Warning</option>
                                        <option value="error">Error</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <markdown-editor v-model="content"></markdown-editor>

            <div class="field">
                <button class="button is-info">Post Announcement</button>
            </div>
        </form>
    `,
    data() {
        return {
            title: '',
            type: 'default',
            plugin: '',
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
        save() {

        }
    },
    components: {
        'markdown-editor': MarkdownEditor,
        'plugin-select': PluginSelect
    }
};

export default AnnouncementEditor;
