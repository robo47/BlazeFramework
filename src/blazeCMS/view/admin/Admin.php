<?php
namespace blazeCMS\view\admin;
use blaze\lang\Object,
blaze\util\Date,
blaze\web\tagLibrary\HtmlTag,
blaze\web\tagLibrary\ViewTag,
blaze\web\tagLibrary\PlainTag,
blaze\ds\Connection,
blaze\ds\SQLException,
blaze\lang\String;

/**
 * Description of Admin
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Admin extends Object implements \blaze\web\WebView {

    /**
     *
     * @var blazeCMS\view\TexTag
     */
    private $textTag;
    /**
     *
     * @var blazeCMS\WebContext
     */
    private $context;

    function __construct() {
        $this->context = \blazeCMS\WebContext::getInstance();
        $this->textTag = \blazeCMS\view\TextTag::create();
    }

    public function getComponents() {
        $root = new HtmlTag('http://www.w3.org/1999/xhtml');
        $root->add($this->textTag);
        $this->textTag->append('<head>'.$this->getHead().'</head>');
        $this->textTag->append('<body>'.$this->getContent().'</body>');

        $ds = \blaze\ds\DataSourceManager::getInstance()->getDataSource('bdsc:pdomysql://localhost/mydb?uid=root');
        $con = $ds->getConnection();
        $stmt = $con->prepareStatement('SELECT * FROM test WHERE test_timestamp = ?');
        $stmt->setTimestamp(0, new Date(2010,6,17,21,11,22,0));
        $stmt->execute();

        $tbl = $con->getMetaData()->getSchema('mydb')->getTable('test');
        //var_dump($tbl->getColumn('test')->getConstraints());
        $meta = $stmt->getMetaData();
        //var_dump($meta->getColumn(0)->getConstraint('PRIMARY')->getColumns());
        $stmt->getResultSet()->next();
        //var_dump($stmt->getResultSet()->getDecimal(0));
        //$c = new \blazeCMS\tool\ClassGenerator();
        //$c->generateForDb(\blaze\lang\ClassLoader::getClassPath());
        //var_dump(\blazeCMS\component\DbAuthentification::getInstance()->getUser('admin@blazebit.com', '123'));
        return $root;
    }

    protected function getHead() {
        return '<title>Admin</title>';
    }

    protected function getContent() {
        return 'Welcome to the Blaze CMS!';
    }
}

?>
