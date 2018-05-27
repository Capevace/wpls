import { getAnnouncement } from '../../http';
import marked from 'marked';

export default {
    template: `
        <wpls-page :title="pageTitle" subtitle="Announcement" back="/announcements">
            <template slot="level-right">
                <div class="level-item">
                    <button class="button is-danger is-outlined" to="/announcements/create">Delete Announcement</button>
                </div>
            </template>

            <div class="field">
                <label class="label">Content Preview</label>
                <div class="content" v-html="content"></div>
            </div>
        </wpls-page>
    `,
    data() {
        return {
            loading: false,
            announcement: null
        };
    },
    async mounted() {
        this.loading = true;

        try {
            this.announcement = await getAnnouncement(this.$route.params.id);
        } catch (e) {
            this.announcement = null;
            console.log(e);
        }

        this.loading = false;
    },
    computed: {
        pageTitle() {
            return this.loading
                ? 'Loading...'
                : !this.announcement
                    ? 'Not Found'
                    : this.announcement.title;
        },
        content() {
            return !this.announcement
                ? ''
                : marked(this.announcement.content);
        }
    },
    methods: {
        
    }
};