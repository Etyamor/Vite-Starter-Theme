<!-- Project Structure -->
<div class="mb-12 rounded-2xl bg-white p-8 shadow-lg">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Project Structure</h2>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500">Theme Root</h3>
            <div class="rounded-xl bg-gray-50 p-4">
                <ul class="space-y-1 font-mono text-sm text-gray-700">
                    <li><span class="text-gray-400">&#9500;&#9472;</span> <span class="text-blue-600">functions.php</span> <span class="text-xs text-gray-400">&mdash; Autoloader + bootstrap</span></li>
                    <li><span class="text-gray-400">&#9500;&#9472;</span> <span class="text-blue-600">index.php</span> <span class="text-xs text-gray-400">&mdash; Delegates to Blade</span></li>
                    <li><span class="text-gray-400">&#9500;&#9472;</span> <span class="text-blue-600">header.php</span> <span class="text-xs text-gray-400">&mdash; WP stub (Blade layout)</span></li>
                    <li><span class="text-gray-400">&#9500;&#9472;</span> <span class="text-blue-600">footer.php</span> <span class="text-xs text-gray-400">&mdash; WP stub (Blade layout)</span></li>
                    <li><span class="text-gray-400">&#9500;&#9472;</span> <span class="text-purple-600">style.css</span> <span class="text-xs text-gray-400">&mdash; Theme metadata</span></li>
                    <li><span class="text-gray-400">&#9500;&#9472;</span> <span class="text-purple-600">vite.config.mjs</span> <span class="text-xs text-gray-400">&mdash; Vite configuration</span></li>
                    <li><span class="text-gray-400">&#9500;&#9472;</span> <span class="text-purple-600">composer.json</span> <span class="text-xs text-gray-400">&mdash; PHP deps + PSR-4 autoload</span></li>
                    <li><span class="text-gray-400">&#9492;&#9472;</span> <span class="text-purple-600">tsconfig.json</span> <span class="text-xs text-gray-400">&mdash; TypeScript configuration</span></li>
                </ul>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500">Directories</h3>
                <div class="space-y-3">
                    <div class="rounded-xl bg-blue-50 p-4">
                        <p class="mb-1 font-mono text-sm font-semibold text-blue-700">inc/</p>
                        <ul class="space-y-0.5 text-sm text-blue-800">
                            <li><span class="font-mono text-blue-600">Blade.php</span> &mdash; Blade service singleton</li>
                            <li><span class="font-mono text-blue-600">Assets.php</span> &mdash; Vite asset loading</li>
                            <li><span class="font-mono text-blue-600">Cleanup.php</span> &mdash; WordPress cleanup hooks</li>
                            <li><span class="font-mono text-blue-600">Directives/</span> &mdash; Custom Blade directives</li>
                        </ul>
                    </div>

                    <div class="rounded-xl bg-purple-50 p-4">
                        <p class="mb-1 font-mono text-sm font-semibold text-purple-700">resources/views/</p>
                        <ul class="space-y-0.5 text-sm text-purple-800">
                            <li><span class="font-mono text-purple-600">layouts/</span> &mdash; Base HTML layout</li>
                            <li><span class="font-mono text-purple-600">partials/</span> &mdash; Reusable template sections</li>
                            <li><span class="font-mono text-purple-600">index.blade.php</span> &mdash; Welcome page view</li>
                        </ul>
                    </div>

                    <div class="rounded-xl bg-green-50 p-4">
                        <p class="mb-1 font-mono text-sm font-semibold text-green-700">resources/</p>
                        <ul class="space-y-0.5 text-sm text-green-800">
                            <li><span class="font-mono text-green-600">scripts/</span> &mdash; TypeScript source files</li>
                            <li><span class="font-mono text-green-600">styles/</span> &mdash; CSS source files</li>
                            <li><span class="font-mono text-green-600">images/</span> &mdash; Image assets</li>
                        </ul>
                    </div>

                    <div class="rounded-xl bg-amber-50 p-4">
                        <p class="mb-1 font-mono text-sm font-semibold text-amber-700">bin/</p>
                        <ul class="space-y-0.5 text-sm text-amber-800">
                            <li><span class="font-mono text-amber-600">setup.js</span> &mdash; Interactive setup script</li>
                            <li><span class="font-mono text-amber-600">bundle.js</span> &mdash; Production zip bundler</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
