import { announcementTypeToModifierClass } from '../../../utils';
export default {
    template: `
        <div class="notification announcement-list-item" @click.prevent="redirectToAnnouncementDetail">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h5 class="title is-5">
                            <a @click="redirectToAnnouncementDetail">
                                {{ announcement.title }}
                            </a>
                        </h5>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <div class="tags has-addons">
                            <span :class="{'tag': true, [typeClassName]: true}">
                                {{ announcement.type | capitalize }}
                            </span>
                        </div>
                    </div>
                    <div class="level-item mr-1">
                        <div class="tags has-addons">
                            <span class="tag is-dark">12.01.2018</span>
                        </div>
                    </div>
                    <!-- <div class="level-item">
                        <router-link 
                            to="/announcements/something" 
                            class="button is-small is-info is-outlined"
                        >
                            Open
                        </router-link>
                    </div> -->
                </div>
            </div>
        </div>
    `,
    props: ['announcement'],
    computed: {
        className() {
            return {
                'notification': true,
                [this.typeClassName]: true
            };
        },
        openLink() {
            return `/announcements/${this.announcement.id}`;
        },
        typeClassName() {
            return announcementTypeToModifierClass(this.announcement.type);
        }
    },
    methods: {
        redirectToAnnouncementDetail() {
            this.$router.push(this.openLink);
        }
    }
};