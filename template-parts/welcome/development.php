<!-- Development -->
<div class="mb-12 rounded-2xl bg-white p-8 shadow-lg">
	<h2 class="mb-6 text-2xl font-bold text-gray-800">Development</h2>

	<div class="grid gap-6 md:grid-cols-2">
		<div class="rounded-xl border-2 border-blue-200 bg-blue-50 p-6">
			<h3 class="mb-2 text-lg font-bold text-blue-900">Development Server</h3>
			<div class="mb-4 rounded-lg bg-gray-900 px-4 py-3"><code class="text-sm text-green-400">npm run dev</code></div>
			<ul class="space-y-1 text-sm text-blue-800">
				<li>Starts Vite dev server on <code class="rounded bg-blue-200 px-1 text-xs">http://localhost:5173</code></li>
				<li>Enables hot module replacement (HMR)</li>
				<li>Removes the manifest file to activate dev mode</li>
			</ul>
		</div>

		<div class="rounded-xl border-2 border-purple-200 bg-purple-50 p-6">
			<h3 class="mb-2 text-lg font-bold text-purple-900">Production Build</h3>
			<div class="mb-4 rounded-lg bg-gray-900 px-4 py-3"><code class="text-sm text-green-400">npm run build</code></div>
			<ul class="space-y-1 text-sm text-purple-800">
				<li>Creates optimized assets in the <code class="rounded bg-purple-200 px-1 text-xs">dist/</code> directory</li>
				<li>Hashed filenames for cache busting</li>
				<li>Automatic image optimization</li>
			</ul>
		</div>
	</div>

	<p class="mt-4 text-sm text-gray-500">The theme automatically detects dev vs production mode based on manifest file existence &mdash; no manual switching needed.</p>
</div>
