<?php

namespace Webkul\ProductFileAttribute\Model\Product\Attribute\Backend;

use Exception;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\Uploader;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Psr\Log\LoggerInterface;

class File extends AbstractBackend
{
    /**
     * @var Filesystem\Driver\File
     */
    protected $_file;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var Filesystem
     */
    protected $_filesystem;

    /**
     * @var UploaderFactory
     */
    protected $_fileUploaderFactory;


    /**
     * Construct
     *
     * @param LoggerInterface $logger
     * @param Filesystem $filesystem
     * @param UploaderFactory $fileUploaderFactory
     */
    public function __construct(
        LoggerInterface        $logger,
        Filesystem             $filesystem,
        Filesystem\Driver\File $file,
        UploaderFactory        $fileUploaderFactory
    )
    {
        $this->_file = $file;
        $this->_filesystem = $filesystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_logger = $logger;
    }

    public function afterSave($object)
    {
        $path = $this->_filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(
            'catalog/product/file/'
        );
        $delete = $object->getData($this->getAttribute()->getName() . '_delete');

        if ($delete) {
            $fileName = $object->getData($this->getAttribute()->getName());
            $object->setData($this->getAttribute()->getName(), '');
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getName());
            if ($this->_file->isExists($path . $fileName)) {
                $this->_file->deleteFile($path . $fileName);
            }
        }

        if (empty($_FILES)) {
            return $this;// if no image is set then nothing to do
        }

        try {
            /** @var $uploader Uploader */
            $uploader = $this->_fileUploaderFactory->create(['fileId' => 'product[' . $this->getAttribute()->getName() . ']']);
            $uploader->setAllowedExtensions(['png', 'pdf', 'fbx', 'glb', 'gltf']);
            $uploader->setAllowRenameFiles(true);
            $result = $uploader->save($path);
            $object->setData($this->getAttribute()->getName(), $result['file']);
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getName());
        } catch (Exception $e) {
            if ($e->getCode() != Uploader::TMP_NAME_EMPTY) {
                $this->_logger->critical($e);
            }
        }

        return $this;
    }
}
