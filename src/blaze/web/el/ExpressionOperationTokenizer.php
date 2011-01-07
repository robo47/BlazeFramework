<?php

namespace blaze\web\el;

use blaze\lang\Object,
 blaze\tokenizer\Tokenizer;

/**
 * Description of ELContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ExpressionOperationTokenizer extends Object implements Tokenizer {

    private $regex;

    public function __construct() {
        $oper = '\\*\\/\\%\\+\\-\\=\\!\\|\\&\\?\\:\\>\\<';
        $this->regex = '/^\\s* (!)?  \\s* ([^' . $oper . ']+?) \\s* (?: ([' . $oper . ']+)  \\s*+ (.+) )?$/x';
    }

    public function tokenize($string) {
        $operationParts = array();
        $elem = $this->parse($string);
        $operationParts[] = $elem;

        while ($elem != null && ($elem['rightString'] != null || $elem['leftNegation'])) {
            $elem = $this->parse($elem['rightString']);

            if ($elem != null)
                $operationParts[] = $elem;
        }

        return $operationParts;
    }

    private function parse($string) {
        $operators = array('*', '/', '%', '+', '-', '<=', '<', '>=', '>', '==', '!=', '&&', '||', '?', ':');
        preg_match_all($this->regex, $string, $matches);
        $element = array();

        if (count($matches[0]) == 0)
            return null; // no match

            if (count($matches[4]) != 0 && strlen($matches[4][0]) != 0) {
            if (!in_array($matches[3][0], $operators))
                return null; // illegal expression
 $matches[3] = $matches[3][0];
            $matches[4] = $matches[4][0];
        }else {
            $matches[3] = null;
            $matches[4] = null;
        }

        $element['leftNegation'] = $matches[1][0] == '!';
        $element['leftExpression'] = $matches[2][0];
        $element['operation'] = $matches[3];
        $element['rightString'] = $matches[4];
        return $element;
    }

}

?>
