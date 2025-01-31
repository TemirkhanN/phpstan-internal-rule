# phpstan-internal-rules
PHPStan rules to handle @internal tag, preventing prohibited usage of such classes

- [x] [Internal class instantiation](test/data/internal-class-instantiation-rule-violation.php)
- [x] [Internal class or interface used as property type](test/data/internal-class-in-property-declaration-rule-violation.php)
- [ ] Inheritance from an internal class or interface
- [ ] Internal class method call(static, call_user_func and direct call)
- [x] Internal trait usage

# Usage

This is likely pretty much outdated since it was just a proof of concept.  
You can give it a try by installing it via composer  

```bash
composer require --dev temirkhan/phpstan-internal-rules
```

then add extension to your phpstan.neon.dist

```yaml
includes:
  - vendor/temirkhan/phpstan-internal-rule/extension.neon
```
