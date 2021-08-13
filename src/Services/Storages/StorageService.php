<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 8/13/21 12:31 PM
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Services\Storages;

use DateTimeInterface;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use RuntimeException;

abstract class StorageService implements Filesystem
{
    /**
     * Override this if you want to use a disk other than the default
     *
     * @var string $diskName
     */
    protected $diskName;

    /** @var Filesystem $fileSystem */
    protected $fileSystem;

    public function __construct()
    {
        // This will not break if $this->diskName is null. It will use the default disk.
        $this->fileSystem = Storage::disk($this->diskName);
    }

    /**
     * @return Filesystem
     */
    public function getFileSystem(): Filesystem
    {
        return $this->fileSystem;
    }

    /**
     * @return string
     */
    public function getDiskName(): string
    {
        return $this->diskName;
    }

    /**
     * Determine if a file exists.
     *
     * @param  string  $path
     * @return bool
     */
    public function exists($path): bool
    {
        return $this->fileSystem->exists($path);
    }

    /**
     * Get the contents of a file.
     *
     * @param  string  $path
     * @return string
     *
     * @throws FileNotFoundException
     */
    public function get($path): string
    {
        return $this->fileSystem->get($path);
    }

    /**
     * Get a resource to read the file.
     *
     * @param  string  $path
     * @return resource|null The path resource or null on failure.
     *
     * @throws FileNotFoundException
     */
    public function readStream($path)
    {
        return $this->fileSystem->readStream($path);
    }

    /**
     * Write the contents of a file.
     *
     * @param  string  $path
     * @param  string|resource  $contents
     * @param  mixed  $options
     * @return bool
     */
    public function put($path, $contents, $options = []): bool
    {
        return $this->fileSystem->put($path, $contents, $options);
    }

    /**
     * Write a new file using a stream.
     *
     * @param  string  $path
     * @param  resource  $resource
     * @param  array  $options
     * @return bool
     *
     * @throws InvalidArgumentException If $resource is not a file handle.
     * @throws FileExistsException
     */
    public function writeStream($path, $resource, array $options = []): bool
    {
        return $this->fileSystem->writeStream($path, $resource, $options);
    }

    /**
     * Get the visibility for the given path.
     *
     * @param  string  $path
     * @return string
     */
    public function getVisibility($path): string
    {
        return $this->fileSystem->getVisibility($path);
    }

    /**
     * Set the visibility for the given path.
     *
     * @param  string  $path
     * @param  string  $visibility
     * @return bool
     */
    public function setVisibility($path, $visibility): bool
    {
        return $this->fileSystem->setVisibility($path, $visibility);
    }

    /**
     * Prepend to a file.
     *
     * @param  string  $path
     * @param  string  $data
     * @return bool
     */
    public function prepend($path, $data): bool
    {
        return $this->fileSystem->prepend($path, $data);
    }

    /**
     * Append to a file.
     *
     * @param  string  $path
     * @param  string  $data
     * @return bool
     */
    public function append($path, $data): bool
    {
        return $this->fileSystem->append($path, $data);
    }

    /**
     * Delete the file at a given path.
     *
     * @param  string|array  $paths
     * @return bool
     */
    public function delete($paths): bool
    {
        return $this->fileSystem->delete($paths);
    }

    /**
     * Copy a file to a new location.
     *
     * @param  string  $from
     * @param  string  $to
     * @return bool
     */
    public function copy($from, $to): bool
    {
        return $this->fileSystem->copy($from, $to);
    }

    /**
     * Move a file to a new location.
     *
     * @param  string  $from
     * @param  string  $to
     * @return bool
     */
    public function move($from, $to): bool
    {
        return $this->fileSystem->move($from, $to);
    }

    /**
     * Get the file size of a given file.
     *
     * @param  string  $path
     * @return int
     */
    public function size($path): int
    {
        return $this->fileSystem->size($path);
    }

    /**
     * Get the file's last modification time.
     *
     * @param  string  $path
     * @return int
     */
    public function lastModified($path): int
    {
        return $this->fileSystem->lastModified($path);
    }

    /**
     * Get an array of all files in a directory.
     *
     * @param  string|null  $directory
     * @param  bool  $recursive
     * @return array
     */
    public function files($directory = null, $recursive = false): array
    {
        return $this->fileSystem->files($directory, $recursive);
    }

    /**
     * Get all the files from the given directory (recursive).
     *
     * @param  string|null  $directory
     * @return array
     */
    public function allFiles($directory = null): array
    {
        return $this->fileSystem->allFiles($directory);
    }

    /**
     * Get all the directories within a given directory.
     *
     * @param  string|null  $directory
     * @param  bool  $recursive
     * @return array
     */
    public function directories($directory = null, $recursive = false): array
    {
        return $this->fileSystem->directories($directory, $recursive);
    }

    /**
     * Get all (recursive) of the directories within a given directory.
     *
     * @param  string|null  $directory
     * @return array
     */
    public function allDirectories($directory = null): array
    {
        return $this->fileSystem->allDirectories($directory);
    }

    /**
     * Create a directory.
     *
     * @param  string  $path
     * @return bool
     */
    public function makeDirectory($path): bool
    {
        return $this->fileSystem->makeDirectory($path);
    }

    /**
     * Recursively delete a directory.
     *
     * @param  string  $directory
     * @return bool
     */
    public function deleteDirectory($directory): bool
    {
        return $this->fileSystem->deleteDirectory($directory);
    }

    /**
     * Get a temporary URL for the file at the given path.
     *
     * @param string $path
     * @param DateTimeInterface $expiration
     * @param array $options
     * @return string
     *
     */
    public function temporaryUrl(string $path, DateTimeInterface $expiration, array $options = []): string
    {
        return $this->fileSystem->temporaryUrl($path, $expiration, $options);
    }

    /**
     * Get the URL for the file at the given path.
     *
     * @param  string  $path
     * @return string
     *
     * @throws RuntimeException
     */
    public function url(string $path): string
    {
        return $this->fileSystem->url($path);
    }
}
