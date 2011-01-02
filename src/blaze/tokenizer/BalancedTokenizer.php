<?php

namespace blaze\tokenizer;

/**
 * Description of BalancedTokenizer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
interface BalancedTokenizer extends Tokenizer{

	public function getOpenToken();
	public function getCloseToken();

}
?>
