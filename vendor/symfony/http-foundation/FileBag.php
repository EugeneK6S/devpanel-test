<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * FileBag is a container for uploaded files.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bulat Shakirzyanov <mallluhuct@gmail.com>
 */
class FileBag extends ParameterBag
{
    private static $fileKeys = array('error', 'name', 'size', 'tmp_name', 'type');

    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
>>>>>>> git-aline/master/master
     * @param array $parameters An array of HTTP files
     */
    public function __construct(array $parameters = array())
    {
        $this->replace($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function replace(array $files = array())
    {
        $this->parameters = array();
        $this->add($files);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
<<<<<<< HEAD
        if (!is_array($value) && !$value instanceof UploadedFile) {
=======
        if (!\is_array($value) && !$value instanceof UploadedFile) {
>>>>>>> git-aline/master/master
            throw new \InvalidArgumentException('An uploaded file must be an array or an instance of UploadedFile.');
        }

        parent::set($key, $this->convertFileInformation($value));
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $files = array())
    {
        foreach ($files as $key => $file) {
            $this->set($key, $file);
        }
    }

    /**
     * Converts uploaded files to UploadedFile instances.
     *
     * @param array|UploadedFile $file A (multi-dimensional) array of uploaded file information
     *
<<<<<<< HEAD
     * @return array A (multi-dimensional) array of UploadedFile instances
=======
     * @return UploadedFile[]|UploadedFile|null A (multi-dimensional) array of UploadedFile instances
>>>>>>> git-aline/master/master
     */
    protected function convertFileInformation($file)
    {
        if ($file instanceof UploadedFile) {
            return $file;
        }

        $file = $this->fixPhpFilesArray($file);
<<<<<<< HEAD
        if (is_array($file)) {
=======
        if (\is_array($file)) {
>>>>>>> git-aline/master/master
            $keys = array_keys($file);
            sort($keys);

            if ($keys == self::$fileKeys) {
                if (UPLOAD_ERR_NO_FILE == $file['error']) {
                    $file = null;
                } else {
                    $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['size'], $file['error']);
                }
            } else {
                $file = array_map(array($this, 'convertFileInformation'), $file);
<<<<<<< HEAD
=======
                if (array_keys($keys) === $keys) {
                    $file = array_filter($file);
                }
>>>>>>> git-aline/master/master
            }
        }

        return $file;
    }

    /**
     * Fixes a malformed PHP $_FILES array.
     *
     * PHP has a bug that the format of the $_FILES array differs, depending on
     * whether the uploaded file fields had normal field names or array-like
     * field names ("normal" vs. "parent[child]").
     *
     * This method fixes the array to look like the "normal" $_FILES array.
     *
     * It's safe to pass an already converted array, in which case this method
     * just returns the original array unmodified.
     *
<<<<<<< HEAD
     * @param array $data
     *
=======
>>>>>>> git-aline/master/master
     * @return array
     */
    protected function fixPhpFilesArray($data)
    {
<<<<<<< HEAD
        if (!is_array($data)) {
=======
        if (!\is_array($data)) {
>>>>>>> git-aline/master/master
            return $data;
        }

        $keys = array_keys($data);
        sort($keys);

<<<<<<< HEAD
        if (self::$fileKeys != $keys || !isset($data['name']) || !is_array($data['name'])) {
=======
        if (self::$fileKeys != $keys || !isset($data['name']) || !\is_array($data['name'])) {
>>>>>>> git-aline/master/master
            return $data;
        }

        $files = $data;
        foreach (self::$fileKeys as $k) {
            unset($files[$k]);
        }

        foreach ($data['name'] as $key => $name) {
            $files[$key] = $this->fixPhpFilesArray(array(
                'error' => $data['error'][$key],
                'name' => $name,
                'type' => $data['type'][$key],
                'tmp_name' => $data['tmp_name'][$key],
                'size' => $data['size'][$key],
            ));
        }

        return $files;
    }
}
