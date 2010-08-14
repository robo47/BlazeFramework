<?php
namespace blaze\persistence;

/**
 * Description of Query
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Query {
    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
     public function getList();
     public function getUniqueResult();
     
     public function setBinary();
     public function setBoolean();
     public function setCalendar();
     public function setDate();
     public function setDouble();
     public function setEntity();
     public function setFloat();
     public function setInteger();
     public function setLong();
     public function setString();
}

?>
