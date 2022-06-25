<script lang="ts">
	import AbstractPage from "gold-admin/app/abstract-page";


	export let page: AbstractPage;
	let data = {userCount: 0, tileCount: 0, poiCount: 0, mapCount: 0, log:""};
	async function getData() {
		data = await fetch("/api/dashboard")
			.then(res => res.json());
	}
	getData();
$:console.log(data.log)
</script>

<div class="box">
		There are <b>{data.userCount}</b> users.
</div>

<div class="box">
	There are <b>{data.tileCount}</b> tiles.
</div>

<div class="box">
	There are <b>{data.poiCount}</b> POIs.
</div>

<div class="box">
	There are <b>{data.mapCount}</b> maps.
</div>
<div class="box">
	<table >
		{#await getData() then value}
		<thead>
		<tr>
			{#each Object.keys(data.log[0]) as columnHeading}
				{#if columnHeading !== "id"}
					<th>{columnHeading}</th>
				{/if}
			{/each}
		<tr/>
		</thead>
		<tbody>
		{#each Object.values(data.log) as row}
			<tr>
				{#each Object.values(row) as cell}
					{#if cell !== row.id}
						<td>{cell}</td>
					{/if}
				{/each}
			</tr>
		{/each}
		</tbody>
		{/await}
	</table>
</div>