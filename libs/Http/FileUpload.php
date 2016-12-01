<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 *
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace Http;


use Debug\Linda;

class FileUpload
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $size;

    /**
     * @var string
     */
    private $tmpName;

    /**
     * @var string
     */
    private $error;


    public function __construct($value)
    {
        foreach (array('name', 'type', 'size', 'tmp_name', 'error') as $key) {
            if (!isset($value[$key])) {
                $this->error = UPLOAD_ERR_NO_FILE;
                throw new \Exception("Wrong format of uploaded file.");
            }
        }
        $this->name = $value['name'][0];
        $this->size = $value['size'][0];
        $this->tmpName = $value['tmp_name'][0];
        $this->error = $value['error'][0];
    }


    /**
     * Returns the file name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Returns the size of an uploaded file.
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Returns the path to an uploaded file.
     * @return string
     */
    public function getTemporaryFile()
    {
        return $this->tmpName;
    }

    /**
     * Returns the path to an uploaded file.
     * @return string
     */
    public function __toString()
    {
        return $this->tmpName;
    }

    /**
     * Returns the error code. {@link http://php.net/manual/en/features.file-upload.errors.php}
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Is there any error?
     * @return bool
     */
    public function isOk()
    {
        return $this->error === UPLOAD_ERR_OK;
    }


    /**
     * @param string $dest
     * @return $this
     * @throws \Exception
     */
    public function move($dest)
    {
        @mkdir(dirname($dest), 0777, TRUE); // @ - dir may already exist
        if (!call_user_func(is_uploaded_file($this->tmpName) ? 'move_uploaded_file' : 'rename', $this->tmpName, $dest)) {
            throw new \Exception("Unable to move uploaded file '$this->tmpName' to '$dest'. Check the permissions and the path you've passed.");
        }
        chmod($dest, 0666);
        $this->tmpName = $dest;
        return $this;
    }


    /**
     * Get file contents.
     * @return string
     */
    public function getContents()
    {
        // future implementation can try to work around safe_mode and open_basedir limitations
        return $this->isOk() ? file_get_contents($this->tmpName) : NULL;
    }



}