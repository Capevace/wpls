import Announcement from './components/announcement';
import { getAnnouncements } from '../../http';

const AnnouncementsPage = {
    template: `
        <wpls-page title="Announcements">
            <template slot="level-right">
                <div class="level-item">
                    <router-link class="button is-info" to="/announcements/create">Create Announcement</router-link>
                </div>
            </template>

            <h3 class="subtitle is-3 has-text-centered" v-if="loading || announcements.length === 0">
                {{ loading ? 'Loading Announcements...' : 'No Announcements found' }}
            </h3>
            <announcement v-for="announcement in announcements" :announcement="announcement"></announcement>
        </wpls-page>
    `,
    created() {
        this.fetchAnnouncements();
    },
    data() {
        return {
            loading: false,
            announcements: []
        };
    },
    methods: {
        fetchAnnouncements() {
            this.loading = true;

            getAnnouncements()
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.announcements = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message: 'Could not fetch announcements.',
                        type: 'is-danger',
                        duration: 2000
                    });

                    this.announcements = [];
                });
        }
    },
    components: {
        'announcement': Announcement
    }
};

export default AnnouncementsPage;
