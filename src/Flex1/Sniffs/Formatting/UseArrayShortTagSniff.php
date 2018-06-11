<?php

namespace Flex1\Sniffs\Formatting;

/**
 * Class UseArrayShortTagSniff
 */
class UseArrayShortTagSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [
            T_ARRAY,
        ];
    }

    /**
     * @param \PHP_CodeSniffer\Files\File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $fix = $phpcsFile->addFixableError('Array short tag [ ... ] must be used', $stackPtr, 'NoArrayShortTagUsed');

        if ($fix === true) {
            $tokens = $phpcsFile->getTokens();
            $token = $tokens[$stackPtr];

            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($stackPtr, '');
            $phpcsFile->fixer->replaceToken($token['parenthesis_opener'], '[');

            for ($i = ($stackPtr + 1); $i < $token['parenthesis_opener']; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }

            $phpcsFile->fixer->replaceToken($token['parenthesis_closer'], ']');
            $phpcsFile->fixer->endChangeset();
        }
    }
}
