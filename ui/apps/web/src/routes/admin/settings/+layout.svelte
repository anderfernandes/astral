<script>
	import { ATabs, ATabItem } from 'ui';
	import {
		application_cog_outline,
		book_cog_outline,
		movie_cog_outline,
		office_building_cog_outline,
		store_cog_outline,
		table_cog
	} from 'ui/icons';
</script>

<h1>Settings</h1>

<ATabs>
	<ATabItem text="General" href="/admin/settings" icon={office_building_cog_outline} />
	<ATabItem text="Tickets" href="/admin/settings/tickets" icon={book_cog_outline} />
	<ATabItem text="Events" href="/admin/settings/events" icon={table_cog} />
	<ATabItem text="Shows" href="/admin/settings/shows" icon={movie_cog_outline} />
	<ATabItem text="Products" href="/admin/settings/products" icon={store_cog_outline} />
	<ATabItem text="System" href="/admin/settings/system" icon={application_cog_outline} />
</ATabs>

<slot />
