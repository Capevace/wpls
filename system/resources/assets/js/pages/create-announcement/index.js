import AnnouncementEditor from '../../components/announcement-editor';
import { postAnnouncement } from '../../http';

const CreateAnnouncementPage = {
    template: `
        <wpls-page title="Create Announcement" back="/announcements">
            <template slot="level-right">
                <div class="level-item">
                    <button class="button is-info" @click="forceEditorSave">Post Announcement</button>
                </div>
            </template>

            <announcement-editor new @save="saveNewAnnouncement" ref="announcementEditor"></announcement-editor>
        </wpls-page>
    `,
    created() {
        
    },
    data() {
        return {
            loading: true
        };
    },
    methods: {
        fetchAnnouncements() {

        },
        forceEditorSave() {
            // This will force the editor to emit a "save" event.
            this.$refs.announcementEditor.forceSubmit();
        },
        saveNewAnnouncement(announcement) {
            this.loading = true;

            postAnnouncement(announcement)
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message: `The announcement "${announcement.title}" was successfully posted!`,
                        type: 'is-success',
                        duration: 2000
                    });

                    this.$router.push('/announcements');
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message:
                            'Could not post announcement for unknown reasons.',
                        type: 'is-danger',
                        duration: 2000
                    });
                });
        }
    },
    components: {
        'announcement-editor': AnnouncementEditor,
    }
};

export default CreateAnnouncementPage;
