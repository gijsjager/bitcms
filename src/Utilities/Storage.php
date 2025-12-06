<?php

namespace Bitcms\Utilities;

use Cake\Log\Log;
use CallbackFilterIterator;
use Closure;
use FilesystemIterator;
use Iterator;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;

class Storage
{
    /**
     * Create directory recursively
     * @param string $dir
     * @param int $mode
     */
    public function mkdir(string $dir, int $mode = 0755): void
    {
        if (is_dir($dir)) {
            return;
        }

        $old = umask(0);
        // phpcs:ignore
        umask($old);
        if (@mkdir($dir, $mode, true) === false) {
            Log::error("Unable to create directory $dir");
        }
    }

    public function findRecursive(string $path, Closure|string|null $filter = null, ?int $flags = null): Iterator
    {
        $flags ??= FilesystemIterator::KEY_AS_PATHNAME
            | FilesystemIterator::CURRENT_AS_FILEINFO
            | FilesystemIterator::SKIP_DOTS;
        $directory = new RecursiveDirectoryIterator($path, $flags);

        $dirFilter = new RecursiveCallbackFilterIterator(
            $directory,
            function (SplFileInfo $current) {
                if (str_starts_with($current->getFilename(), '.') && $current->isDir()) {
                    return false;
                }

                return true;
            },
        );

        $flatten = new RecursiveIteratorIterator(
            $dirFilter,
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        if ($filter === null) {
            return $flatten;
        }

        return $this->filterIterator($flatten, $filter);
    }

    protected function filterIterator(Iterator $iterator, Closure|string $filter): RegexIterator|CallbackFilterIterator
    {
        if (is_string($filter)) {
            return new RegexIterator($iterator, $filter);
        }

        return new CallbackFilterIterator($iterator, $filter);
    }
}
