<?php

namespace blaze\persistence\tool;

use blaze\lang\Object;

/**
 * Description of ForwardEngineer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
class ForwardEngineer extends Object {

    private $dir;

    public function __construct(\blaze\io\File $destDir) {
        $this->dir = $destDir;
    }

    public function forwardEngineerXmlFile(\blaze\io\File $file) {
        $buf = new \blaze\lang\StringBuffer();
        $t = new \blaze\persistence\meta\driver\XmlMetaDriver();
        $cd = $t->parseFile($file);
        $cd->generate($buf);

        $fileName = \blaze\lang\String::asWrapper($cd->getName());
        $fileName = $fileName->substring($fileName->lastIndexOf('\\') + 1);
        $writer = new \blaze\io\output\FileWriter(new \blaze\io\File($this->dir, $fileName.'.php'));
        $writer->write($buf->toString());
        $writer->close();
    }

    public function forwardEngineerXmlFiles(\blaze\io\File $dir){
        foreach($dir->listFiles() as $file){
            if($file->getName()->substring($file->getName()->lastIndexOf('.') + 1)->compare('xml') == 0)
                $this->forwardEngineerXmlFile($file);
        }

        // Lookup the classdescriptors and tabledescriptors
    }
}

?>
