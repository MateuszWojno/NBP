<?php

declare(strict_types=1);
error_reporting(E_ALL);

function projectPath(SplFileInfo $file): string
{
    return subStr("$file", strLen(__DIR__ . DIRECTORY_SEPARATOR));
}

function projectFolderNames(SplFileInfo $file): array
{
    return \explode(DIRECTORY_SEPARATOR, projectPath($file));
}

function isFileInFolder(SplFileInfo $file, array $path): bool
{
    return \array_slice(projectFolderNames($file), 0, \count($path)) === $path;
}

/**
 * @param string $folderName
 * @return Generator<SplFileInfo>
 */
function iterateFiles(string $folderName): Generator
{
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . DIRECTORY_SEPARATOR . $folderName)) as $file) {
        yield $file;
    }
}

$deferred = [];

foreach (iterateFiles('NBP') as $file) {
    if ($file->getExtension() === 'php') {
        try {
            require $file;
        } catch (Error $silenced) {
            if (str_ends_with($silenced->getMessage(), 'not found')) {
                $deferred[] = $file;
                continue;
            }
            throw $silenced;
        }
    }
}
foreach ($deferred as $file) {
    require $file;
}