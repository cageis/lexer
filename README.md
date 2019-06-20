# *Lexer* 
[![Build Status](https://travis-ci.org/cageis/lexer.svg?branch=master)](https://travis-ci.org/cageis/lexer) 

Lexer is a minimal string parser that can be used to convert text into a list of tokens.

## Example Usage
```php
<?php
$lexer = CageIs\Lexer\LexerFactory::create();
$tokens = $lexer->addTokenPattern(new CageIs\Lexer\TokenPattern('\d+', 'num'))
    ->addTokenPattern(new CageIs\Lexer\TokenPattern('[a-zA-Z]+', 'alpha'))
    ->setWhitespaceIgnore(true)
    ->parse("hello\n123\n^&111111")
    ->toArray();

// The results will be
[
  [
    'name' => "alpha",
    'match' => "hello",
  ],
  [
    'name' => "num",
    'match' => "123",
  ],
  [
    'name' => "Unknown",
    'match' => "^",
  ],
  [
    'name' => "Unknown",
    'match' => "&",
  ],
  [
    'name' => "num",
    'match' => "111111",
  ]
];

```
Note: not calling `$tokens->toArray()` will return a collection object (`CageIs\Lexer\TokenizedCollection`) with a couple of helpful collection methods.
