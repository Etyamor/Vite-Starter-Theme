const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');
const os = require('os');

const ROOT = path.resolve(__dirname, '..');
const pkg = JSON.parse(fs.readFileSync(path.join(ROOT, 'package.json'), 'utf8'));
const themeName = pkg.name;
const version = pkg.version;
const zipName = `${themeName}-${version}.zip`;
const distDir = path.join(ROOT, 'bundled');
const zipPath = path.join(distDir, zipName);
const skipLint = process.argv.includes('--no-lint');

// Directories to include recursively.
const includeDirs = ['dist', 'inc', 'resources/views', 'vendor'];

// Individual files from the root to include.
const includeFiles = [
  'functions.php',
  'header.php',
  'footer.php',
  'index.php',
  'style.css',
  'screenshot.png',
  'LICENSE',
  'README.md',
];

function run(cmd, label) {
  console.log(`\n> ${label}`);
  execSync(cmd, { cwd: ROOT, stdio: 'inherit' });
}

function copyRecursive(src, dest) {
  if (!fs.existsSync(src)) return;

  const stat = fs.statSync(src);
  if (stat.isDirectory()) {
    fs.mkdirSync(dest, { recursive: true });
    for (const entry of fs.readdirSync(src)) {
      if (entry === '.DS_Store') continue;
      copyRecursive(path.join(src, entry), path.join(dest, entry));
    }
  } else {
    fs.mkdirSync(path.dirname(dest), { recursive: true });
    fs.copyFileSync(src, dest);
  }
}

function clean() {
  if (fs.existsSync(distDir)) {
    fs.rmSync(distDir, { recursive: true, force: true });
  }
  console.log('Cleaned bundled/ directory.');
}

// Handle --clean flag.
if (process.argv.includes('--clean')) {
  clean();
  process.exit(0);
}

// Ensure bundled/ directory exists.
if (!fs.existsSync(distDir)) {
  fs.mkdirSync(distDir);
}

console.log(`Bundling ${themeName} v${version}...\n`);

// 1. Run lints (unless --no-lint).
if (!skipLint) {
  run('npm run lint', 'PHPCS + PHPStan');
  run('npm run typecheck', 'TypeScript type check');
} else {
  console.log('\n> Skipping lint (--no-lint)');
}

// 2. Build assets.
run('npm run build', 'Vite production build');

// 3. Install production-only Composer dependencies for bundling.
run('composer install --no-dev --optimize-autoloader', 'Composer production install');

// 4. Stage files into a temp directory under the theme name.
const tmpDir = fs.mkdtempSync(path.join(os.tmpdir(), 'theme-bundle-'));
const stageDir = path.join(tmpDir, themeName);
fs.mkdirSync(stageDir);

console.log(`\n> Creating ${zipName}`);

for (const dir of includeDirs) {
  copyRecursive(path.join(ROOT, dir), path.join(stageDir, dir));
}

for (const file of includeFiles) {
  const src = path.join(ROOT, file);
  if (fs.existsSync(src)) {
    fs.copyFileSync(src, path.join(stageDir, file));
  }
}

// 5. Create zip.
if (fs.existsSync(zipPath)) {
  fs.unlinkSync(zipPath);
}

execSync(`cd "${tmpDir}" && zip -r "${zipPath}" "${themeName}"`, {
  stdio: 'inherit',
});

fs.rmSync(tmpDir, { recursive: true, force: true });

// 6. Restore dev dependencies.
run('composer install', 'Restore dev dependencies');

const stats = fs.statSync(zipPath);
const sizeMB = (stats.size / 1024 / 1024).toFixed(2);

console.log(`\nDone! ${zipName} (${sizeMB} MB) → bundled/${zipName}`);
