const LicensePopup = {
    template: `
		<div :class="{'modal': true, 'is-active': visible}">
			<div class="modal-background" @click="toggle"></div>
			<div class="modal-content">
				<div class="card">
					<div class="card-content">
						<div class="content">
							<h2>License</h2>
							<p style="word-break: break-all;">
								{{ license }}
							</p>
						</div>
					</div>
				</div>
			</div>
			<button aria-label="close" class="modal-close is-large" @click="toggle"></button>
		</div>
	`,
    props: ['visible', 'license'],
    methods: {
        toggle() {
            this.$emit('toggle');
        }
    }
};

export default LicensePopup;
