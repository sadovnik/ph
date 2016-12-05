# pretty heredoc

It's painful to write heredocs in the middle of some indentation level:
```php
class CliApp
{
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

Ruby has smart heredocs that respect indentation:
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

But PHP has not.

So I made a basic function that receives string and strips it:
```php

use function Sadovnik\PrettyHeredoc\ph as ✍️;

class CliApp
{
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
