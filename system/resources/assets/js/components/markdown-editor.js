import marked from 'marked';
import debounce from 'lodash.debounce';

export default {
    template: `
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Content &nbsp;<span class="is-size-7 has-text-grey has-text-weight-normal">Markdown supported</span></label>
                    <div class="control">
                        <textarea class="textarea" v-model="content"></textarea>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Content Preview</label>
                    <div class="control">
                        <div class="content markdown-editor-preview" v-html="markdownHtml"></div>
                    </div>
                </div>
            </div>
        </div>
    `,
    props: ['value'],
    data() {
        return {
            content: '',
            markdownHtml: ''
        };
    },
    watch: {
        content: debounce(function() {
            this.markdownHtml = marked(this.content);
        }, 10)
    },
    methods: {

    }
};