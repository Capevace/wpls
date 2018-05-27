export default {
    template: `
        <div class="wpls-page">
            <div class="level">
                <div class="level-left">
                    <div class="level-item is-align-self-fs" style="position: absolute;left: -85px;" v-if="back">
                        <router-link class="button is-small is-rounded" :to="back">
                            <span class="icon"><i class="fas fa-arrow-left"></i></span>
                            <span>Back</span>
                        </router-link>
                    </div>

                    <slot name="level-left"></slot>
                    
                    <div class="level-item">
                        <div>
                            <h1 class="title page-title is-spaced" v-if="title">{{ title }}</h1>
                            <h2 class="subtitle" v-if="subtitle">{{ subtitle }}</h2>
                        </div>
                        
                    </div>
                </div>

                <div class="level-right">
                    <slot name="level-right"></slot>
                </div>
            </div>

            <slot></slot>
        </div>
    `,
    props: ['title', 'subtitle', 'back']
};