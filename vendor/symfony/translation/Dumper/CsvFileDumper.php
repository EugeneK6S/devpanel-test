<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Dumper;

use Symfony\Component\Translation\MessageCatalogue;

/**
 * CsvFileDumper generates a csv formatted string representation of a message catalogue.
 *
 * @author Stealth35
 */
class CsvFileDumper extends FileDumper
{
    private $delimiter = ';';
    private $enclosure = '"';

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function format(MessageCatalogue $messages, $domain = 'messages')
=======
    public function formatCatalogue(MessageCatalogue $messages, $domain, array $options = array())
>>>>>>> git-aline/master/master
    {
        $handle = fopen('php://memory', 'rb+');

        foreach ($messages->all($domain) as $source => $target) {
            fputcsv($handle, array($source, $target), $this->delimiter, $this->enclosure);
        }

        rewind($handle);
        $output = stream_get_contents($handle);
        fclose($handle);

        return $output;
    }

    /**
     * Sets the delimiter and escape character for CSV.
     *
<<<<<<< HEAD
     * @param string $delimiter delimiter character
     * @param string $enclosure enclosure character
=======
     * @param string $delimiter Delimiter character
     * @param string $enclosure Enclosure character
>>>>>>> git-aline/master/master
     */
    public function setCsvControl($delimiter = ';', $enclosure = '"')
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtension()
    {
        return 'csv';
    }
}
