import Announcement from './components/announcement';

const AnnouncementsPage = {
    template: `
        <wpls-page title="Announcements">
            <template slot="level-right">
                <div class="level-item">
                    <router-link class="button is-info" to="/announcements/create">Create Announcement</router-link>
                </div>
            </template>

            <announcement type="default"></announcement>
            <announcement type="success"></announcement>
            <announcement type="info"></announcement>
            <announcement type="warning"></announcement>
            <announcement type="error"></announcement>
        </wpls-page>
    `,
    created() {
        this.fetchAnnouncements();
    },
    data() {
        return {
            announcements: []
        };
    },
    methods: {
        fetchAnnouncements() {

        }
    },
    components: {
        'announcement': Announcement
    }
};

export default AnnouncementsPage;
