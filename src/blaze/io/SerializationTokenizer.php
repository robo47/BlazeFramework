<?php

namespace blaze\io;

use blaze\lang\Object,
 blaze\tokenizer\BalancedTokenizer;

/**
 * Description of SerializationTokenizer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class SerializationTokenizer extends Object implements BalancedTokenizer {

    private $regex;
    private $openToken;
    private $openTokenLen;
    private $closeToken;
    private $closeTokenLen;

    public function __construct($openToken, $closeToken) {
        $this->openToken = $openToken;
        $this->openTokenLen = strlen($openToken);
        $this->closeToken = $closeToken;
        $this->closeTokenLen = strlen($closeToken);

        $tokenComb = $openToken . $closeToken;
        $this->regex = '/' .
                '(?:' . // Begin recursion group
                '(?:\\' . $openToken . // Opening token
                '(?:' . // Possessive subgroup
                '(?: [^' . $tokenComb . ']+ )' . //  Get chars which or not the token
                '|' . //    or
                '(?R)' . //  Recurse
                ')*' . // Zero or more times
                '\\' . $closeToken . ')' . // Closing token
                '|' . //  or
                '[^' . $tokenComb . ']+' . // Chars outside of the expression
                ')' . // End recursion group
                '/';
    }

    public function getOpenToken() {
        return $this->openToken;
    }

    public function getCloseToken() {
        return $this->closeToken;
    }

    /**
     *
     * @param <type> $string
     * @return array index 0 contains the tokenized objects and index 1 the index of the string where tokenization ended
     */
    public function tokenize($string) {
        $matches = array();
        preg_match_all($this->regex, $string, $matches, PREG_OFFSET_CAPTURE);
        $parts = array();
        $nextPos = 0;

        if (count($matches[0]) == 0)
            return null; // no match
        if ($matches[0][0][1] != 0)
            return null; // illegal expression

            for ($i = 0; $i < count($matches[0]); $i++) {
                if ($nextPos != $matches[0][$i][1])
                    return array($parts, $nextPos); // illegal expression
                $nextPos += strlen($matches[0][$i][0]);

                if ($matches[0][$i][0][0] == '{')
                    $parts[count($parts) - 1] .= $matches[0][$i][0];
                else {
                    $tokens = explode(';', $matches[0][$i][0]);

                    for ($j = 0; $j < count($tokens) - 1; $j++)
                        $parts[] = $tokens[$j] . ';';
                    $parts[] = $tokens[count($tokens) - 1];
                }
            }

            return array($parts, $nextPos);;
    }

}

?>
