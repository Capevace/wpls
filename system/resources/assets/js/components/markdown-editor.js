import marked from 'marked';
import debounce from 'lodash.debounce';

export default {
    template: `
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Content &nbsp;<span class="is-size-7 has-text-grey has-text-weight-normal">Markdown supported</span></label>
                    <div class="control">
                        <textarea class="textarea" v-model="content" :required="required"></textarea>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">{{ forAnnouncements !== undefined ? 'WordPress' : 'Content'  }} Preview</label>
                    <div class="control">
                        
                        <div class="content markdown-editor-preview-announcements" v-if="forAnnouncements !== undefined">
                            <div :class="{'notice': true, ['notice-' + announcementType]: true}">
                                <h3>
                                    Announcement Title
                                    <span style="color: #8d8d8d;font-weight: normal;font-size: 10px;">
                                        by Your Plugin Name on 02/02/2018 at 10:21 AM
                                </h3>

                                <div v-html="markdownHtml"></div>
                            </div>
                        </div>
                        <div class="content markdown-editor-preview" v-html="markdownHtml" v-else></div>
                    </div>
                </div>
            </div>
        </div>
    `,
    props: ['value', 'required', 'forAnnouncements', 'announcementType'],
    data() {
        return {
            content: '',
            markdownHtml: ''
        };
    },
    watch: {
        content: debounce(function() {
            this.markdownHtml = marked(this.content);
            this.$emit('input', this.content);
        }, 10)
    },
    methods: {

    }
};