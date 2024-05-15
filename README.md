# Endolang
Endolang は Brainfuck をベースとした言語で PHP で実装されています。

## run
```bash
$ bin/endolang example/congratulations.endo
```

## QA
```bash
$ composer tests
```

### Unit testing
```bash
$ composer test
```

### Static analysis
```bash
$ composer stan
$ composer psalm
```

### Code formatting
```bash
# dry-run
$ composer cs
# write
$ composer cs-fix
```

### Mutation testing
```bash
$ composer infection
```
