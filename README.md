# MonoTools
Collection of simple php tools.

[![Build Status](https://travis-ci.org/nimmneun/MonoTools.svg?branch=master)](https://travis-ci.org/nimmneun/MonoTools)
<a href='https://coveralls.io/r/nimmneun/MonoTools?branch=master'><img src='https://coveralls.io/repos/nimmneun/MonoTools/badge.svg?branch=master' alt='Coverage Status' /></a>

# MonoCsv
Yet another simple php csv file/string reader using php's Spl(Temp)FileObject to read from files or strings. I just wanted something more convenient, while still keeping all of the SplFileObject functions at my fingertips =)
```php
$csv = MonoCsv::load('../data/test01.csv');
// Skip 2 lines on each loop and do something
while (false !== $row = $csv->skip(2)->next())
{
    echo $row[0]."\n";
}
```
# MonoShell
Simple php exec wrapper to execute shell commands (with some limitations) and retrieve the return values.
```php
// Store command output to $os or throw exception on error.
try {
  $os = MonoShell::run('uname', 1)->getOut();
} catch (InvalidArgumentException $e) {}
```
