<?php get_header(); ?>
<main class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4">
    <div class="mx-auto max-w-6xl">
        <?php get_template_part('template-parts/welcome/header'); ?>
        <?php get_template_part('template-parts/welcome/guide'); ?>
        <?php get_template_part('template-parts/welcome/features'); ?>
        <?php get_template_part('template-parts/welcome/tips'); ?>
        <?php get_template_part('template-parts/welcome/note'); ?>
        <?php get_template_part('template-parts/welcome/footer'); ?>
    </div>
</main>
<?php get_footer(); ?>
