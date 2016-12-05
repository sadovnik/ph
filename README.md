# pretty heredoc

Heredoc alternative for text.

## Problem
It's painful to write heredocs in the middle of some identation level:
```php
class CliApp
{
    // ...
    public static function printUsage()
    {
        echo <<<EOL
Usage:
    linter [--fix] [--debug] <path>
    linter (-h | --help)
    linter --version
EOL;
    }
}
```

Ruby provides a way to make smart heredocs that respect identation:
```ruby
class CliApp
  def self.print_usage
    puts <<~EOL
      Usage:
          linter [--fix] [--debug] <path>
          linter (-h | --help)
          linter --version
    EOL
  end
end
```

But PHP does not.

So I made a basic function that recieves string and strips it:
```php

use function Sadovnik\PrettyHeredoc\ph as ✍️;

class CliApp
{
    // ...
    public static function printUsage()
    {
        echo ✍️('
            Usage:
                linter [--fix] [--debug] <path>
                linter (-h | --help)
                linter --version
        ');
    }
}
```

Enjoy it!
