<template>
	<div class="wpls-page">
        <div class="level">
            <div class="level-left">
                <div class="level-item is-align-self-fs" style="position: absolute;left: -85px;" v-if="back">
                    <router-link class="button is-small is-rounded" :to="back">
                        <span class="icon"><icon-arrow-left class="fa-icon"></icon-arrow-left></span>
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

        <slot v-if="!loading"></slot>
        <div v-else>
            <h3 class="subtitle is-3 has-text-centered">
                Loading...
            </h3>
        </div>
    </div>
</template>
<script type="text/javascript">
import IconArrowLeft from './icons/icon-arrow-left';

export default {
    props: ['title', 'subtitle', 'back', 'loading'],
    components: {
        IconArrowLeft
    }
};
</script>