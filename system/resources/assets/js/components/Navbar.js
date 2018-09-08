const NavLink = {
	template: `
		<router-link :to="to" active-class="has-text-weight-bold" :exact="exact">
			<slot></slot>
		</router-link>
	`,
	props: ['to', 'exact']
};

export default {
	template: `
		<nav class="level main-navigation" role="navigation" aria-label="main navigation"> 
			<!-- Left side -->
			<div class="level-left">
				<div class="level-item">
					<p class="subtitle is-4">
						<strong>WordPress</strong> License Server
						
						<div class="tags has-addons version-tag-container">
							<span class="tag version-tag">{{ version }}</span>
							<span v-if="needsUpdate" class="tag is-danger"><a :href="updateLink">Database update required</a></span>
						</div>
					</p>
				</div>
			</div>
			
			<!-- Right side -->
			<div class="level-right">
				<p class="level-item">
					<nav-link to="/" exact>Activations</nav-link>
				</p>
				<p class="level-item">
					<nav-link to="/licenses" exact>Licenses</nav-link>
				</p>
				<p class="level-item">
					<nav-link to="/packages" exact>Packages</nav-link>
				</p>
				<p class="level-item">
					<nav-link to="/sites" exact>Sites</nav-link>
				</p>
				<!--<p class="level-item">
					<nav-link to="/announcements" exact>Announcements</nav-link>
				</p>-->
				<p class="level-item">
					<a href="logout" style="margin-left: 30px;" class="button is-danger is-inverted is-small has-text-weight-bold">
						<span>Logout</span>
						<span class="icon"><i class="fas fa-sign-out-alt"></i></span>
					</a>
				</p>
			</div>
		</nav>
	`,
	components: {
		'nav-link': NavLink
	},
	computed: {
		needsUpdate() {
			return window.wplsNeedsUpdate;
		},
		updateLink() {
			return window.wplsUpdateLink;
		},
		version() {
			return window.wplsVersion;
		}
	}
};