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

abstract class S3StorageService extends StorageService
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
     * @param string|null $diskName
     */
    public function __construct(string $diskName = null)
    {
        $configPrefix = 'filesystems.disks.';

        if (is_null($diskName)) {
            $configKey = $configPrefix . $this->bucket;
            $this->diskName = $this->bucket;
            config([
                $configPrefix . $this->diskName => [
                    'driver' => $this->driver,
                    'key' => $this->key,
                    'secret' => $this->secret,
                    'region' => $this->region,
                    'bucket' => $this->bucket,
                    'url' => $this->url,
                    'endpoint' => $this->endpoint,
                    'use_path_style_endpoint' => $this->usePathStyleEndpoint
                ]
            ]);
        } else {
            $configKey = $configPrefix . $diskName;
        }

        if (config()->has($configKey)) {
            $reflection = new ReflectionObject($this);
            $this->diskName = $diskName;
            foreach (config($configKey) as $key => $val) {
                if ($reflection->hasProperty(Str::camel($key))) {
                    $this->{Str::camel($key)} = $val;
                }
            }
        }

        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function getBucket(): ?string
    {
        return $this->bucket;
    }
}
