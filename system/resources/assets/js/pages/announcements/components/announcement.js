import { announcementTypeToModifierClass } from '../../../utils';
export default {
    template: `
        <div class="notification">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h5 class="title is-5">
                            <router-link to="">
                                asdasd
                                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                                
                            </router-link>
                        </h5>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <div class="tags has-addons">
                            <span class="tag is-dark">12.01.2018</span>
                        </div>
                    </div>
                    <div class="level-item mr-1">
                        <div class="tags has-addons">
                            <span class="tag is-danger">Danger</span>
                        </div>
                    </div>
                    <div class="level-item">
                        <router-link 
                            to="/announcements/something" 
                            class="button is-small is-info is-outlined"
                        >
                            Open
                        </router-link>
                    </div>
                </div>
            </div>
            <transition name="fade">
                <div class="level" v-if="expanded">
                    <div class="level-left">
                        <div class="level-item">
                            <h6 class="subtitle is-6">asdasdas</h6>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    `,
    props: ['type'],
    data() {
        return {
            expanded: false
        };
    },
    computed: {
        className() {
            return {
                'notification': true,
                [this.typeClassName]: true
            };
        },
        deleteButtonClassName() {
            return {
                'button is-danger is-small': true,
                'is-inverted': this.type === 'error'
            };
        },
        typeClassName() {
            return announcementTypeToModifierClass(this.type);
        }
    }
};