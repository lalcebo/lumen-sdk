<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 8/13/21 12:49 PM
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Services\Storages;

use Lalcebo\Lumen\Support\Str;
use ReflectionObject;

abstract class AbstractS3StorageService extends AbstractStorageService
{
    /** @var string */
    protected $region = 'us-east-1';

    /** @var string */
    protected $bucket;

    /** @var string */
    protected $driver = 's3';

    /** @var string */
    protected $key;

    /** @var string */
    protected $secret;

    /** @var string */
    protected $url;

    /** @var string */
    protected $endpoint;

    /** @var bool */
    protected $usePathStyleEndpoint = false;

    /**
     * Set properties class from config keys values.
     *
     * @return void
     */
    protected function configurator(): void
    {
        $configKey = 'filesystems.disks.' . $this->diskName;
        if (config()->has($configKey)) {
            $reflection = new ReflectionObject($this);
            foreach (config($configKey) as $key => $val) {
                if ($reflection->hasProperty(Str::camel($key))) {
                    $this->{Str::camel($key)} = $val;
                }
            }
        }
    }

    /**
     * @return string|null
     */
    public function getBucket(): ?string
    {
        return $this->bucket;
    }
}
