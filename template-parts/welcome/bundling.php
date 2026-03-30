<!-- Bundling for Distribution -->
<div class="mb-12 rounded-2xl bg-white p-8 shadow-lg">
	<h2 class="mb-2 text-2xl font-bold text-gray-800">Bundling for Distribution</h2>
	<p class="mb-6 text-gray-600">Create a production-ready <code class="rounded bg-gray-100 px-2 py-0.5 text-sm text-gray-700">.zip</code> for WordPress installation:</p>

	<div class="grid gap-4 md:grid-cols-3">
		<div class="rounded-xl border-2 border-gray-200 p-5 transition-all hover:border-blue-300 hover:shadow-md">
			<div class="mb-3 rounded-lg bg-gray-900 px-4 py-3"><code class="text-sm text-green-400">npm run bundle</code></div>
			<p class="text-sm font-semibold text-gray-800">Full Bundle</p>
			<p class="text-sm text-gray-600">Lint + build + zip</p>
		</div>

		<div class="rounded-xl border-2 border-gray-200 p-5 transition-all hover:border-purple-300 hover:shadow-md">
			<div class="mb-3 rounded-lg bg-gray-900 px-4 py-3"><code class="text-sm text-green-400">npm run bundle:quick</code></div>
			<p class="text-sm font-semibold text-gray-800">Quick Bundle</p>
			<p class="text-sm text-gray-600">Build + zip (skip linting)</p>
		</div>

		<div class="rounded-xl border-2 border-gray-200 p-5 transition-all hover:border-rose-300 hover:shadow-md">
			<div class="mb-3 rounded-lg bg-gray-900 px-4 py-3"><code class="text-sm text-green-400">npm run bundle:clean</code></div>
			<p class="text-sm font-semibold text-gray-800">Clean Up</p>
			<p class="text-sm text-gray-600">Remove the bundled/ directory</p>
		</div>
	</div>

	<p class="mt-4 text-sm text-gray-500">The zip contains a <code class="rounded bg-gray-100 px-1 text-xs text-gray-600">&lt;theme-name&gt;/</code> root folder with only the files WordPress needs &mdash; no <code class="rounded bg-gray-100 px-1 text-xs text-gray-600">node_modules</code>, <code class="rounded bg-gray-100 px-1 text-xs text-gray-600">vendor</code>, <code class="rounded bg-gray-100 px-1 text-xs text-gray-600">resources</code>, <code class="rounded bg-gray-100 px-1 text-xs text-gray-600">bin</code>, or config files.</p>
</div>
