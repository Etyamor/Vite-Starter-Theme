const readline = require('readline');
const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const ROOT = __dirname;

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

function ask(question, defaultValue = '') {
  const suffix = defaultValue ? ` (${defaultValue})` : '';
  return new Promise((resolve) => {
    rl.question(`${question}${suffix}: `, (answer) => {
      resolve(answer.trim() || defaultValue);
    });
  });
}

function toSlug(name) {
  return name
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '');
}

function toFontFamily(fontSlug) {
  return fontSlug
    .split('-')
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
}

function replaceInFile(filePath, replacements) {
  const absPath = path.join(ROOT, filePath);
  if (!fs.existsSync(absPath)) {
    console.log(`  Skipped ${filePath} (not found)`);
    return;
  }
  let content = fs.readFileSync(absPath, 'utf8');
  for (const [search, replace] of replacements) {
    content = content.split(search).join(replace);
  }
  fs.writeFileSync(absPath, content, 'utf8');
  console.log(`  Updated ${filePath}`);
}

function removeDir(dirPath) {
  const absPath = path.join(ROOT, dirPath);
  if (!fs.existsSync(absPath)) return;
  fs.rmSync(absPath, { recursive: true, force: true });
  console.log(`  Removed ${dirPath}/`);
}

async function main() {
  console.log('\n========================================');
  console.log('  Vite Starter Theme - Setup');
  console.log('========================================\n');

  // Collect inputs
  const themeName = await ask('Theme name', 'Vite Starter Theme');
  const slug = toSlug(themeName);

  const description = await ask(
    'Description',
    'A modern WordPress theme with Vite and Tailwind CSS v4'
  );
  const author = await ask('Author name');
  const authorUri = await ask('Author URL');
  const font = await ask('Main font family (press Enter to keep Roboto)');
  const removeWelcome = await ask('Remove welcome page? (y/n)', 'n');

  // Summary
  console.log('\n--- Summary ---');
  console.log(`  Theme name:      ${themeName}`);
  console.log(`  Slug:            ${slug}`);
  console.log(`  Description:     ${description}`);
  console.log(`  Author:          ${author || '(none)'}`);
  console.log(`  Author URL:      ${authorUri || '(none)'}`);
  console.log(`  Font:            ${font || 'Roboto (default)'}`);
  console.log(`  Remove welcome:  ${removeWelcome.toLowerCase() === 'y' ? 'yes' : 'no'}`);
  console.log('');

  const confirm = await ask('Proceed? (y/n)', 'y');
  if (confirm.toLowerCase() !== 'y') {
    console.log('Setup cancelled.');
    rl.close();
    process.exit(0);
  }

  console.log('\nApplying changes...\n');

  // 1. style.css
  const styleCssPath = path.join(ROOT, 'style.css');
  const styleLines = [
    '/*',
    `Theme Name: ${themeName}`,
    `Text Domain: ${slug}`,
    `Description: ${description}`,
  ];
  if (author) styleLines.push(`Author: ${author}`);
  if (authorUri) styleLines.push(`Author URI: ${authorUri}`);
  styleLines.push('Version: 1.0.0', '*/', '');
  fs.writeFileSync(styleCssPath, styleLines.join('\n'), 'utf8');
  console.log('  Updated style.css');

  // 2. package.json
  replaceInFile('package.json', [
    ['"vite-starter-theme"', `"${slug}"`],
  ]);

  // 3. package-lock.json
  replaceInFile('package-lock.json', [
    ['"vite-starter-theme"', `"${slug}"`],
  ]);

  // 4. README.md
  replaceInFile('README.md', [
    ['# Vite Starter Theme', `# ${themeName}`],
  ]);

  // 5. template-parts/welcome/header.php
  replaceInFile('template-parts/welcome/header.php', [
    ['Vite Starter Theme', themeName],
  ]);

  // 6. inc/assets.php — handle prefixes
  const handleSlug = slug;
  replaceInFile('inc/assets.php', [
    ["'theme-scripts'", `'${handleSlug}-scripts'`],
    ["'theme-styles'", `'${handleSlug}-styles'`],
  ]);

  // 7. Font swap
  if (font) {
    const fontSlug = font
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-|-$/g, '');
    const fontFamily = toFontFamily(fontSlug);

    console.log(`\n  Removing @fontsource/roboto...`);
    try {
      execSync('npm uninstall @fontsource/roboto', {
        cwd: ROOT,
        stdio: 'inherit',
      });
    } catch {
      console.log('  Warning: could not uninstall @fontsource/roboto');
    }

    console.log(`  Installing @fontsource/${fontSlug}...`);
    try {
      execSync(`npm install --save-dev @fontsource/${fontSlug}`, {
        cwd: ROOT,
        stdio: 'inherit',
      });
    } catch {
      console.log(
        `  Warning: could not install @fontsource/${fontSlug}. You may need to install it manually.`
      );
    }

    replaceInFile('resources/styles/fonts.css', [
      ['@fontsource/roboto', `@fontsource/${fontSlug}`],
      ["'Roboto', sans-serif", `'${fontFamily}', sans-serif`],
    ]);
  }

  // 8. Remove welcome page
  if (removeWelcome.toLowerCase() === 'y') {
    removeDir('template-parts/welcome');

    const indexPath = path.join(ROOT, 'template-parts/index.php');
    const indexContent = [
      '<?php get_header(); ?>',
      '<main>',
      '    <h1><?php bloginfo(\'name\'); ?></h1>',
      '    <p><?php bloginfo(\'description\'); ?></p>',
      '</main>',
      '<?php get_footer(); ?>',
      '',
    ].join('\n');
    fs.writeFileSync(indexPath, indexContent, 'utf8');
    console.log('  Reset template-parts/index.php');
  }

  console.log('\nSetup complete!\n');

  // Self-deletion prompt
  const deleteSelf = await ask('Delete setup script? (y/n)', 'y');
  if (deleteSelf.toLowerCase() === 'y') {
    // Remove "setup" script from package.json
    const pkgPath = path.join(ROOT, 'package.json');
    const pkg = JSON.parse(fs.readFileSync(pkgPath, 'utf8'));
    if (pkg.scripts && pkg.scripts.setup) {
      delete pkg.scripts.setup;
      fs.writeFileSync(pkgPath, JSON.stringify(pkg, null, 2) + '\n', 'utf8');
      console.log('  Removed "setup" script from package.json');
    }

    // Delete this file
    fs.unlinkSync(path.join(ROOT, 'setup.js'));
    console.log('  Deleted setup.js');
  }

  console.log('\nAll done! Next steps:');
  console.log('  npm run dev    - Start development server');
  console.log('  npm run build  - Build for production\n');

  rl.close();
}

main().catch((err) => {
  console.error('Setup failed:', err.message);
  rl.close();
  process.exit(1);
});
