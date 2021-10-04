# phpstan-internal-rules
PHPStan rules to handle @internal tag, preventing prohibited usage of such classes

- [x] [Internal class instantiation](test/data/internal-class-instantiation-rule-violation.php)
- [x] [Internal class or interface used as property type](test/data/internal-class-in-property-declaration-rule-violation.php)
- [ ] Inheritance from an internal class or interface
- [ ] Internal class method call(static, call_user_func and direct call)
- [x] Internal trait usage
