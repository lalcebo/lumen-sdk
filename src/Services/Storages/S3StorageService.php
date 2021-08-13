<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 8/13/21 12:49 PM
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Services\Storages;

abstract class S3StorageService extends StorageService
{
    /** @var string $awsRegion */
    protected $awsRegion = 'us-east-1';

    /** @var string|null $bucketName */
    protected $bucketName;

    /** @var string */
    protected $driver = 's3';

    /** @var string */
    protected $awsAccessKeyId;

    /** @var string */
    protected $awsSecretAccessKey;

    /** @var string */
    protected $awsUrl;

    /** @var string */
    protected $awsEndpoint;

    /** @var bool */
    protected $usePathStyleEndpoint = false;

    public function __construct()
    {
        $this->diskName = "s3-$this->bucketName";

        config([
            'filesystems.disks.' . $this->diskName => [
                'driver' => $this->driver,
                'key' => $this->awsAccessKeyId,
                'secret' => $this->awsSecretAccessKey,
                'region' => $this->awsRegion,
                'bucket' => $this->bucketName,
                'url' => $this->awsUrl,
                'endpoint' => $this->awsEndpoint,
                'use_path_style_endpoint' => $this->usePathStyleEndpoint
            ]
        ]);

        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function getBucketName(): ?string
    {
        return $this->bucketName;
    }
}
