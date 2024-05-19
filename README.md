# Endolang
Endolang は Brainfuck をベースとした言語で PHP で実装されています。

|トークン| 動作                              |
|:-:|:--------------------------------|
|え| ポインターをインクリメントする                 |
|ん| ポインターをデクリメントする                  |
|ど| 現在のポインタの値をインクリメントする             |
|ぅ| 現在のポインタの値をデクリメントする              |
|〜| 現在のポインタの値を出力する                  |
|結| ループの開始。現在のポインタの値が0になるまでループを繰り返す |
|婚| ループの終了。                         |
|！| 入力の先頭1バイトを現在のポインタに代入する          |

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
