<?php

namespace blaze\tokenizer;

/**
 * Description of BalancedTokenizer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
interface BalancedTokenizer extends Tokenizer{

	public function getOpenToken();
	public function getCloseToken();

}
?>
