<?php get_header(); ?>
<main class="flex h-screen items-center justify-center bg-green-100">
    <div class="relative rounded-2xl bg-white p-10 shadow-lg w-[500px]">
        <input type="radio" name="carousel" id="card1" class="hidden peer/card1" checked>
        <input type="radio" name="carousel" id="card2" class="hidden peer/card2">
        <input type="radio" name="carousel" id="card3" class="hidden peer/card3">
        <input type="radio" name="carousel" id="card4" class="hidden peer/card4">
        <input type="radio" name="carousel" id="card5" class="hidden peer/card5">

        <div class="peer-checked/card1:block hidden h-full">
            <h1 class="mb-4 text-2xl font-bold">Welcome to Viburnum Theme</h1>
            <p class="mb-4">Viburnum Theme is a modern WordPress theme that leverages Vite for asset bundling and
                optimization, designed to provide a fast and efficient development experience.</p>
            <label for="card2" class="cursor-pointer text-blue-500">Next</label>
        </div>
        <div class="peer-checked/card2:block hidden h-full">
            <h1 class="mb-4 text-2xl font-bold">Features</h1>
            <ul class="mb-4 list-inside list-disc">
                <li>Vite Integration</li>
                <li>Zero Complexity</li>
                <li>Optimized Assets</li>
                <li>Tailwind CSS</li>
            </ul>
            <label for="card3" class="cursor-pointer text-blue-500">Next</label>
        </div>
        <div class="peer-checked/card3:block hidden h-full">
            <h1 class="mb-4 text-2xl font-bold">Installation</h1>
            <ol class="mb-4 list-inside list-decimal">
                <li>Clone the repository into your WordPress `wp-content/themes` directory.</li>
                <li>Navigate to the theme directory and install dependencies:
                    <pre><code>npm install</code></pre>
                </li>
                <li>Build the assets:
                    <pre><code>npm run build</code></pre>
                </li>
                <li>Activate the theme from the WordPress admin panel.</li>
            </ol>
            <label for="card4" class="cursor-pointer text-blue-500">Next</label>
        </div>
        <div class="peer-checked/card4:block hidden h-full">
            <h1 class="mb-4 text-2xl font-bold">Development</h1>
            <p class="mb-4">To start the development server with Vite:</p>
            <pre class="mb-4"><code>npm run dev</code></pre>
            <label for="card5" class="cursor-pointer text-blue-500">Next</label>
        </div>
        <div class="peer-checked/card5:block hidden h-full">
            <h1 class="mb-4 text-2xl font-bold">Notes</h1>
            <p class="mb-4">Vite does not parse PHP files for used assets. If you want to use assets in PHP files, you
                need to add another folder for these kinds of assets.</p>
            <label for="card1" class="cursor-pointer text-blue-500">Back to Start</label>
        </div>
    </div>
</main>
<?php get_footer(); ?>
