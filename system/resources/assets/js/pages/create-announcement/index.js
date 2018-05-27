import AnnouncementEditor from '../../components/announcement-editor';

const CreateAnnouncementPage = {
    template: `
        <wpls-page title="Create Announcement" back="/announcements">
            <template slot="level-right">
                <div class="level-item">
                    <button class="button is-info" to="/announcements/create">Post Announcement</button>
                </div>
            </template>

            <announcement-editor new @save="saveNewAnnouncement"></announcement-editor>
        </wpls-page>
    `,
    created() {
        
    },
    data() {
        return {
            
        };
    },
    methods: {
        fetchAnnouncements() {

        },
        forceEditorSave() {
            // This will force the editor to emit a "save" event.
            this.$refs.announcementEditor.save();
        },
        saveAnnouncement(announcement) {
            console.log(announcement);
        }
    },
    components: {
        'announcement-editor': AnnouncementEditor,
    }
};

export default CreateAnnouncementPage;
