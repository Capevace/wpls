<template>
	<wpls-page :title="pageTitle" :subtitle="postedOnDateLabel" back="/announcements">
        <template slot="level-right">
            <div class="level-item" v-if="announcement">
                <div class="tags">
                    <span :class="{'tag is-large': true, [typeClassName]: true}">
                        Type: {{ announcement.type | capitalize }}
                    </span>
                </div>
            </div>
            <div class="level-item" v-if="announcement">
                <button class="button is-danger is-outlined" @click="deleteAnnoncement">Delete Announcement</button>
            </div>
        </template>

        <div class="field">
            <label class="label">Content Preview</label>
            <div class="content" v-html="content" v-if="announcement"></div>
            <div class="content" v-else>Loading content...</div>
        </div>
    </wpls-page>
</template>
<script type="text/javascript">
import marked from 'marked';
import { getAnnouncement, deleteAnnouncement } from '../../http';
import { announcementTypeToModifierClass } from '../../utils';

export default {
    data() {
        return {
            loading: false,
            announcement: null
        };
    },
    async mounted() {
        this.loading = true;

        try {
            const response = await getAnnouncement(this.$route.params.id);
            this.announcement = response.data;
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
        },
        postedOnDateLabel() {
            return !this.announcement
                ? ' '
                : `Posted on ${new Date(this.announcement.created_at).toLocaleString()}`;
        },
        typeClassName() {
            const className = announcementTypeToModifierClass(this.announcement.type);
            
            return className === 'is-white'
                ? ''
                : className;
        }
    },
    methods: {
        deleteAnnoncement() {
            this.loading = true;

            deleteAnnouncement(this.announcement.id)
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message: `Announcement "${this.announcement.title}" was successfully deleted.`,
                        type: 'is-success',
                        duration: 2000
                    });
                    this.$router.push('/announcements');
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message: 'Could not delete the announcement.',
                        type: 'is-danger',
                        duration: 2000
                    });
                });;
        }
    }
};
</script>