<?php

namespace App\Service\Export;

class CompressZip
{
    function compress($files, $zipName, $userId, $format)
    {
        $pathUser = '/tmp/export/' . $format . '/' . $userId . '/';
        $zip = new \ZipArchive();
        $absoluteFilePathZip = $pathUser . 'zip/' . $zipName;
        $zip->open($absoluteFilePathZip, \ZipArchive::CREATE);
        foreach ($files as $file) {
            $zip->addFile($file, $file->getFilename());
        }
        $zip->close();

        return $absoluteFilePathZip;
    }
}
