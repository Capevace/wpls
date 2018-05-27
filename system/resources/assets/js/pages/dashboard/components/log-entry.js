const LogEntry = {
    template: `
		<tr>
			<td>{{ time }}</td>
			<td>{{ log.event_slug }}</td>
			<td>{{ typeLabel }}</td>
			<td :class="licenseClass" style="word-break: break-word;">{{ eventData.license }}</td>
			<td>{{ errorMessage }}</td>
			<td>
				<span class="is-block is-size-7" v-if="eventMeta.url">{{ eventMeta.url }}</span>
				<span class="is-block is-size-7">{{ eventMeta.ip }}</span>
				<span class="is-block is-size-7" v-if="log.event_plugin_version">Version {{ log.event_plugin_version }}</span>
			</td>
		</tr>
	`,
    props: ['log'],
    computed: {
        time() {
            const d = new Date(this.log.time);
            return d.toLocaleString();
        },
        typeLabel() {
            switch (this.log.event_type) {
                case 'verify':
                    return 'Verification';

                case 'verify-legacy':
                    return 'Legacy Verify';

                case 'get_metadata':
                    return 'Metadata';

                case 'download':
                    return 'Download';

                default:
                    return this.log.event_type;
            }
        },
        eventData() {
            try {
                return JSON.parse(this.log.event_data);
            } catch (e) {
                return {
                    license: this.log.event_data
                };
            }
        },
        eventMeta() {
            try {
                return JSON.parse(this.log.event_meta);
            } catch (e) {
                return {
                    ip: this.log.event_meta
                };
            }
        },
        licenseClass() {
            return {
                'has-text-success': this.eventData.valid,
                'has-text-danger': !this.eventData.valid
            };
        },
        errorMessage() {
            if (!this.eventData.error) return '';

            return this.eventData.error.message || '';
        }
    }
};

export default LogEntry;
