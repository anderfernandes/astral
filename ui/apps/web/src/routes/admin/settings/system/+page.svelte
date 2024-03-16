<script lang="ts">
	let { data } = $props();

	const { version, timezone, upload_max_filesize } = data;
</script>

<p class="text-sm">Astral Version: {version}</p>
<p class="text-sm">Browser Timezone: {Intl.DateTimeFormat().resolvedOptions().timeZone}</p>
<p class="text-sm">Server Timezone: {timezone}</p>
<p class="text-sm">Upload Max File Size: {upload_max_filesize}</p>
