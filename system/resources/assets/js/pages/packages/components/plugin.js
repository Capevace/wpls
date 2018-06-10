import ItemIDForm from './item-id-form';
import VerificationTestForm from './verification-test-form';

export default {
    template: `
        <div class="notification">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h5 class="title is-5">{{ plugin.name }} ({{ plugin.version }})</h5>
                    </div>
                    <div class="level-item">
                        <h6 class="subtitle is-6">{{ plugin.slug }}</h6>
                    </div>
                </div>
            </div>

            <div class="level">
                <item-id-form :item-id="plugin.envato_item_id" :slug="plugin.slug"></item-id-form>
                <verification-test-form :slug="plugin.slug"></verification-test-form>
            </div>
        </div>
    `,
    props: ['plugin'],
    components: {
        'item-id-form': ItemIDForm,
        'verification-test-form': VerificationTestForm
    }
};