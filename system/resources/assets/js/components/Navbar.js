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
		<nav class="level" role="navigation" aria-label="main navigation"> 
			<!-- Left side -->
			<div class="level-left">
				<div class="level-item">
					<p class="subtitle is-4"><strong>WordPress</strong> License Manager</p>
				</div>
			</div><!-- Right side -->
			<div class="level-right">
				<p class="level-item">
					<nav-link to="/" exact>Dashboard</nav-link>
				</p>
				<p class="level-item">
					<nav-link to="/licenses" exact>Licenses</nav-link>
				</p>
				<p class="level-item">
					<nav-link to="/plugins" exact>Plugins</nav-link>
				</p>
				<p class="level-item">
					<nav-link to="/announcements" exact>Announcements</nav-link>
				</p>
				<p class="level-item">
					<nav-link to="/settings" exact>Settings</nav-link>
				</p>
				<p class="level-item">
					<a href="logout" class="button is-danger has-text-weight-bold">
						<span>Logout</span>
						<span class="icon"><i class="fas fa-sign-out-alt"></i></span>
					</a>
				</p>
			</div>
		</nav>
	`,
	components: {
		'nav-link': NavLink
	}
};