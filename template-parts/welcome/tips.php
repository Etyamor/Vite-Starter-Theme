<!-- Quick Tips Section -->
<div class="grid gap-6 md:grid-cols-2">
    <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-lg">
        <h3 class="mb-4 text-2xl font-bold">Adding Fonts</h3>
        <div class="space-y-3">
            <p class="text-blue-50">Install a fontsource package:</p>
            <div class="rounded-lg bg-blue-900/50 p-3">
                <code class="text-sm">npm install --save @fontsource/inter</code>
            </div>
            <p class="text-blue-50">Import in resources/styles/fonts.css:</p>
            <div class="rounded-lg bg-blue-900/50 p-3">
                <code class="text-sm">@import '@fontsource/inter';</code>
            </div>
        </div>
    </div>

    <div class="rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white shadow-lg">
        <h3 class="mb-4 text-2xl font-bold">Adding Images</h3>
        <div class="space-y-3">
            <p class="text-purple-50">Reference images in CSS with relative paths:</p>
            <div class="rounded-lg bg-purple-900/50 p-3">
                <code class="text-sm">.hero {<br>&nbsp;&nbsp;background-image: url('../images/hero.webp');<br>}</code>
            </div>
            <p class="text-sm text-purple-50">Vite will automatically process and optimize them during build.</p>
        </div>
    </div>
</div>