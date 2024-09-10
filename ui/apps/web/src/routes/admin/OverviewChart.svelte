<script lang="ts">
	let { data }: { data: { month: string; amount: number }[] } = $props();
</script>

<div class="col-span-4 rounded-xl border bg-card text-card-foreground shadow">
	<div class="flex flex-col space-y-1.5 p-6">
		<h3 class="font-semibold leading-none tracking-tight">Overview</h3>
	</div>
	<div class="p-6 pl-2 pt-0">
		<div class="recharts-responsive-container" style="width: 685px; height: 350px; min-width: 0px;">
			<div
				class="recharts-wrapper"
				style="position: relative; cursor: default; width: 685px; height: 350px;"
				role="region"
			>
				<svg class="recharts-surface" width="685" height="350" viewBox="0 0 685 350"
					><title></title><desc></desc><defs
						><clipPath id="recharts10-clip"
							><rect x="65" y="5" height="310" width="615"></rect></clipPath
						></defs
					><g class="recharts-layer recharts-cartesian-axis recharts-xAxis xAxis"
						><g class="recharts-cartesian-axis-ticks"
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="90.625"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="90.625" dy="0.71em">Jan</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="141.875"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="141.875" dy="0.71em">Feb</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="193.125"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="193.125" dy="0.71em">Mar</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="244.375"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="244.375" dy="0.71em">Apr</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="295.625"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="295.625" dy="0.71em">May</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="346.875"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="346.875" dy="0.71em">Jun</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="398.125"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="398.125" dy="0.71em">Jul</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="449.375"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="449.375" dy="0.71em">Aug</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="500.625"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="500.625" dy="0.71em">Sep</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="551.875"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="551.875" dy="0.71em">Oct</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="603.125"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="603.125" dy="0.71em">Nov</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="bottom"
									width="615"
									height="30"
									x="654.375"
									y="323"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="middle"><tspan x="654.375" dy="0.71em">Dec</tspan></text
								></g
							></g
						></g
					><g class="recharts-layer recharts-cartesian-axis recharts-yAxis yAxis"
						><g class="recharts-cartesian-axis-ticks"
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="left"
									width="60"
									height="310"
									x="57"
									y="315"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="end"><tspan x="57" dy="0.355em">$0</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="left"
									width="60"
									height="310"
									x="57"
									y="237.5"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="end"><tspan x="57" dy="0.355em">$1500</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="left"
									width="60"
									height="310"
									x="57"
									y="160"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="end"><tspan x="57" dy="0.355em">$3000</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="left"
									width="60"
									height="310"
									x="57"
									y="82.5"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="end"><tspan x="57" dy="0.355em">$4500</tspan></text
								></g
							><g class="recharts-layer recharts-cartesian-axis-tick"
								><text
									stroke="none"
									font-size="12"
									orientation="left"
									width="60"
									height="310"
									x="57"
									y="9"
									fill="#888888"
									class="recharts-text recharts-cartesian-axis-tick-value"
									text-anchor="end"><tspan x="57" dy="0.355em">$6000</tspan></text
								></g
							></g
						></g
					><g class="recharts-layer recharts-bar fill-primary"
						><g class="recharts-layer recharts-bar-rectangles"
							><g class="recharts-layer"
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="89.745"
										name="Jan"
										x="70.125"
										y="225.255"
										d="M70.125,229.255A 4,4,0,0,1,74.125,225.255L 107.125,225.255A 4,4,0,0,1,
111.125,229.255L 111.125,315L 70.125,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="263.7066666666667"
										name="Feb"
										x="121.375"
										y="51.293333333333294"
										d="M121.375,55.293333333333294A 4,4,0,0,1,125.375,51.293333333333294L 158.375,51.293333333333294A 4,4,0,0,1,
162.375,55.293333333333294L 162.375,315L 121.375,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="74.09"
										name="Mar"
										x="172.625"
										y="240.91"
										d="M172.625,244.91A 4,4,0,0,1,176.625,240.91L 209.625,240.91A 4,4,0,0,1,
213.625,244.91L 213.625,315L 172.625,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="270.2683333333333"
										name="Apr"
										x="223.875"
										y="44.73166666666668"
										d="M223.875,48.73166666666668A 4,4,0,0,1,227.875,44.73166666666668L 260.875,44.73166666666668A 4,4,0,0,1,
264.875,48.73166666666668L 264.875,315L 223.875,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="110.92833333333334"
										name="May"
										x="275.125"
										y="204.07166666666666"
										d="M275.125,208.07166666666666A 4,4,0,0,1,279.125,204.07166666666666L 312.125,204.07166666666666A 4,4,0,0,1,
316.125,208.07166666666666L 316.125,315L 275.125,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="86.69666666666669"
										name="Jun"
										x="326.375"
										y="228.3033333333333"
										d="M326.375,232.3033333333333A 4,4,0,0,1,330.375,228.3033333333333L 363.375,228.3033333333333A 4,4,0,0,1,
367.375,232.3033333333333L 367.375,315L 326.375,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="299.09833333333336"
										name="Jul"
										x="377.625"
										y="15.901666666666642"
										d="M377.625,19.901666666666642A 4,4,0,0,1,381.625,15.901666666666642L 414.625,15.901666666666642A 4,4,0,0,1,
418.625,19.901666666666642L 418.625,315L 377.625,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="255.285"
										name="Aug"
										x="428.875"
										y="59.715"
										d="M428.875,63.715A 4,4,0,0,1,432.875,59.715L 465.875,59.715A 4,4,0,0,1,
469.875,63.715L 469.875,315L 428.875,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="107.4666666666667"
										name="Sep"
										x="480.125"
										y="207.5333333333333"
										d="M480.125,211.5333333333333A 4,4,0,0,1,484.125,207.5333333333333L 517.125,207.5333333333333A 4,4,0,0,1,
521.125,211.5333333333333L 521.125,315L 480.125,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="189.25500000000002"
										name="Oct"
										x="531.375"
										y="125.74499999999998"
										d="M531.375,129.74499999999998A 4,4,0,0,1,535.375,125.74499999999998L 568.375,125.74499999999998A 4,4,0,0,1,
572.375,129.74499999999998L 572.375,315L 531.375,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="272.18"
										name="Nov"
										x="582.625"
										y="42.81999999999999"
										d="M582.625,46.81999999999999A 4,4,0,0,1,586.625,42.81999999999999L 619.625,42.81999999999999A 4,4,0,0,1,
623.625,46.81999999999999L 623.625,315L 582.625,315Z"
									></path></g
								><g class="recharts-layer recharts-bar-rectangle" role="img"
									><path
										fill="currentColor"
										radius="4,4,0,0"
										class="recharts-rectangle fill-primary"
										width="41"
										height="215.3983333333333"
										name="Dec"
										x="633.875"
										y="99.60166666666669"
										d="M633.875,103.60166666666669A 4,4,0,0,1,637.875,99.60166666666669L 670.875,99.60166666666669A 4,4,0,0,1,
674.875,103.60166666666669L 674.875,315L 633.875,315Z"
									></path></g
								></g
							></g
						><g class="recharts-layer"></g></g
					></svg
				>
			</div>
		</div>
	</div>
</div>
