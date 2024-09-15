<?php

namespace DigitLimit\Helper;

use Composer\Autoload\AutoloadGenerator as ComposerAutoloadGenerator;
use Composer\Composer;
use Composer\Package\PackageInterface;
use Composer\Util\Filesystem;

class AutoloadGenerator extends ComposerAutoloadGenerator
{
    public function dumpFiles(Composer $composer, array $paths, $targetDir = 'composer', $suffix = '', $staticPhpVersion = 70000)
    {
        $filesystem = new Filesystem();
        $vendorDir = $filesystem->normalizePath($composer->getConfig()->get('vendor-dir'));
        $targetDirPath = $vendorDir . '/' . $targetDir;
        $filesystem->ensureDirectoryExists($targetDirPath);

        $autoloadPaths = array_filter(array_map('realpath', $paths), 'file_exists');
        $includeFilesFilePath = $targetDirPath . '/autoload_files.php';
        $fileContents = "<?php\n\n" . implode("\n", array_map(fn($file) => "require_once '" . addslashes($file) . "';", $autoloadPaths));
        file_put_contents($includeFilesFilePath, $fileContents);

        $staticFilePath = $targetDirPath . '/autoload_static.php';
        file_put_contents($staticFilePath, $this->getStaticFile($suffix, $targetDirPath, $vendorDir, realpath(getcwd()), $staticPhpVersion));
    }

}
