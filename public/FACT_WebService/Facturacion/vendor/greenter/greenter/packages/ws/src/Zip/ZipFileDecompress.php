<?php
/**
 * Created by PhpStorm.
 * User: LPALQUILER-11
 * Date: 29/08/2018
 * Time: 17:30.
 */

namespace Greenter\Zip;

use ZipArchive;

/**
 * Class ZipFileDecompress.
 * @deprecated deprecated since version v4.1, use ZipFlyDecompress
 */
class ZipFileDecompress implements DecompressInterface
{
    /**
     * Extract files.
     *
     * @param string        $content
     * @param callable|null $filter
     *
     * @return array
     */
    public function decompress(?string $content, callable $filter = null): ?array
    {
        $temp = tempnam(sys_get_temp_dir(), time().'.zip');
        file_put_contents($temp, $content);
        $zip = new ZipArchive();
        $output = [];
        if (true === $zip->open($temp) && $zip->numFiles > 0) {
            $output = iterator_to_array($this->getFiles($zip, $filter));
        }
        $zip->close();
        unlink($temp);

        return $output;
    }

    /**
     * @param callable|null $filter
     */
    private function getFiles(ZipArchive $zip, ?callable $filter)
    {
        $total = $zip->numFiles;
        for ($i = 0; $i < $total; ++$i) {
            $name = $zip->getNameIndex($i);

            if (!$filter || $filter($name)) {
                yield [
                    'filename' => $name,
                    'content' => $zip->getFromIndex($i),
                ];
            }
        }
    }
}
