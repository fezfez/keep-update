keep-update
===========

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fezfez/keep-update/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fezfez/keep-update/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/fezfez/keep-update/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fezfez/keep-update/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/fezfez/keep-update/badges/build.png?b=master)](https://scrutinizer-ci.com/g/fezfez/keep-update/build-status/master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/18aed416-db11-4e14-bd3b-0a18f23683b6/mini.png)](https://insight.sensiolabs.com/projects/18aed416-db11-4e14-bd3b-0a18f23683b6)

Keep update resolve the problem of remaps data from jsonSerialize

Example

I have this dto representation of my model

```php

class News implements \JsonSerializable
{
  /**
   * @var string
   */
  private $title;
  /**
   * @var Author
   */
  private $author;
  
  
  // setters, getters
  
  public function jsonSerialize()
  {
	  return array(
		  'title'   => $this->title,
		  'author'  => $this->author
	  );
  }
}
  
class Author implements \JsonSerializable
{
  private $name;
  
  // setters, getters
  
  public function jsonSerialize()
  {
	  return array(
		  'name' => $this->name
	  );
  }
}

```
  
If i do 

```php
$author = new Author();
$author->setName('Stéphane');

$news = new News();
$news->setTitle('My very news');
$news->setAuthor($author);

file_put_content('tmp', json_encode($news));
```
  
I will have a json representation in tmp file. Now i want to wake the representation.

```php
$newsArray = json_decode(file_get_content('tmp'));
```

How to be sure that's the array i have is a correct representation of my dto's ? You have to create a  validator class, that's very annoying...

With keepUpdate you only have to add Annotation in your attribute, resuming the previous sample

```php

use KeepUpdate\Annotation;

class News implements \JsonSerializable
{
  /**
   * @var string
   */
  private $title;
  /**
   * @Annotation\Chain(class="Author")
   * @var Author
   */
  private $author;
  
  
  // setters, getters
  
  public function jsonSerialize()
  {
	  return array(
		  'title'   => $this->title,
		  'author'  => $this->author
	  );
  }
}

class Author implements \JsonSerializable
{
  private $name;
  
  // setters, getters
  
  public function jsonSerialize()
  {
	  return array(
		  'name' => $this->name
	  );
  }
}


$author = new Author();
$author->setName('Stéphane');

$news = new News();
$news->setTitle('My very news');
$news->setAuthor($author);

file_put_content('tmp', json_encode($news));
$newsArray = json_decode(file_get_content('tmp'));

$arrayValidatorFactory = \KeepUpdate\ArrayValidatorFactory::getInstance();

try {
  $arrayValidatorFactory->isValid($news, $newsArray);
} catch(\KeepUpdate\ValidationException $e) {
  echo 'Not valid !';
}

// or

try {
  $arrayValidatorFactory->isValid('News', $newsArray);
} catch(\KeepUpdate\ValidationException $e) {
  echo 'Not valid !';
}
```

Validate an array representation of a dto is now more simple
