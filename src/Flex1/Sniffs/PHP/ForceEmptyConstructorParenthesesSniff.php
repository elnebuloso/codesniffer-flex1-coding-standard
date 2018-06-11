<?php

namespace Flex1\Sniffs\PHP;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class ForceEmptyConstructorParenthesesSniff
 */
class ForceEmptyConstructorParenthesesSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [
            T_NEW,
        ];
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $phpcsFile->getTokens();

        $end = $phpcsFile->findNext([
            T_CLOSE_PARENTHESIS,
            T_COMMA,
            T_SEMICOLON,
        ], $stackPtr);

        $hasParentheses = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr, $end);

        if (!$hasParentheses) {
            $fix = $phpcsFile->addFixableError('There must be parentheses after constructor call.', $stackPtr, 'NoConstructorParenthesesUsed');

            if ($fix) {
                $phpcsFile->fixer->beginChangeset();
                $phpcsFile->fixer->addContentBefore($end, '()');
                $phpcsFile->fixer->endChangeset();
            }
        }
    }
}
