<?php

namespace App\Service;

use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class S3Service
{
    private S3Client $s3Client;
    private string $bucket;

    public function __construct(
        string $accessKeyId,
        string $secretAccessKey,
        string $bucket,
        string $region
    ) {
        $this->bucket = $bucket;
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region'  => $region,
            'credentials' => [
                'key'    => $accessKeyId,
                'secret' => $secretAccessKey,
            ],
        ]);
    }

    public function upload(UploadedFile $file, string $prefix = ''): string
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $key = $prefix ? $prefix . '/' . $fileName : $fileName;

        $this->s3Client->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $key,
            'Body'   => fopen($file->getPathname(), 'rb'),
            'ACL'    => 'public-read',
        ]);

        return $this->s3Client->getObjectUrl($this->bucket, $key);
    }

    public function delete(string $key): void
    {
        $this->s3Client->deleteObject([
            'Bucket' => $this->bucket,
            'Key'    => $key,
        ]);
    }
}
