<?php

use Aws\S3\S3Client;
use yii\base\Component;

class S3Component extends Component
{
    public string $key;
    public string $secret;
    public string $region;
    public string $bucket;
    public string $version = 'latest';

    private ?S3Client $_client = null;

    public function init(): void
    {
        parent::init();

        $this->_client = new S3Client([
            'version'     => $this->version,
            'region'      => $this->region,
            'credentials' => [
                'key'    => $this->key,
                'secret' => $this->secret,
            ],
        ]);
    }

    public function upload($key, $filePath, $acl = 'public-read'): string
    {
        $result = $this->_client->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $key,
            'SourceFile' => $filePath,
            'ACL'    => $acl,
        ]);

        return $result['ObjectURL'] ?? '';
    }

    public function delete($key): void
    {
        $this->_client->deleteObject([
            'Bucket' => $this->bucket,
            'Key'    => $key,
        ]);
    }

    public function getUrl($key): string
    {
        return $this->_client->getObjectUrl($this->bucket, $key);
    }
}
