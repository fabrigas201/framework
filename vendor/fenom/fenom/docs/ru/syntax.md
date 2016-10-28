Синтаксис
=========

По синтаксису шаблона Fenom похож на [Smarty](http://www.smarty.net/), но обладает рядом улучшений.
Все теги шаблонизатора заключаются в фигурные скобки: `{` — открытие тега и `}` — закрытие тега.

**Замечание**
Хоть Fenom и позаимствовал синтаксис Smarty, но он не заимствовал теги Smarty как есть.
Однако некоторые теги очень похожи. Но не все так плохо, Fenom имеет набор [дополнений](https://github.com/bzick/fenom-extra)
которые могут сделать Fenom более похожим на Smarty, чтобы переход был мягче.

## Переменные

Переменные могут быть выведены на экран или могут быть использованы для функций, атрибутов, модификаторов внутри сложных выражений и т.д.
Переменные в Fenom представлены знаком доллара с последующим именем переменной. Имя переменной чувствительно к регистру.
Правильное имя переменной должно начинаться с буквы или символа подчеркивания и состоять из букв, цифр и символов подчеркивания в любом количестве.

### Использование переменных

Следующий пример использует простые переменные `$user_id` и `$user_name` для формирования приветственного сообщения.

```smarty
<div class="user">Hello, <a href="/users/{$user_id}">{$user_name}</a>.</div>
```

Пример выведет следующий HTML код:

```html
<div class="user">Hello, <a href="/users/17">Bzick</a>.</div>
```

Переменные могут быть массивом. В этом случае обращение по ключу происходит через оператор `.` или, как в PHP, через операторы `[` и `]`
```smarty
<div class="user">Hello, <a href="/users/{$user.id}">{$user.name}</a>.</div>
```
`{$user.id}` and `{$user['id']}` are same:
```smarty
<div class="user">Hello, <a href="/users/{$user['id']}">{$user['name']}</a>.</div>
```

В случае объекта, доступ к его свойствам осущесвляется так как и в PHP — через оператор `->`:
```smarty
<div class="user">Hello, <a href="/users/{$user->id}">{$user->name}</a>.</div>
```

Методы, как и свойства можно вызвать через оператор `->`, передав в метод любые рагументы:
```smarty
<div class="user">Hello, <a href="/users/{$user->getId()}">{$user->getName()}</a>.</div>
```

**Note**
Будте осторожны, Fenom не проверяет наличие метода в классе перед вызовом.
Что бы избежать фатальной ошибки определите метод `__call` у класса объекта.
Вызов методов в шаблоне можно вообще выключить в [настройках](./configuration.md).

Ниже приведены комбинированые примеры работы с переменными:

```smarty
{$foo.bar.baz}
{$foo.$bar.$baz}
{$foo[5].baz}
{$foo[5].$baz}
{$foo.bar.baz[4]}
{$foo[ $bar.baz ]}
{$foo[5]}
{$foo.5}
{$foo.bar}
{$foo.'bar'}
{$foo."bar"}
{$foo['bar']}
{$foo["bar"]}
{$foo.$bar}
{$foo[$bar]}
{$foo->bar}
{$foo->bar.buz}
{$foo->bar.buz[ $bar->getId("user") ]}
{$foo->bar(5)->buz(5.5)}
```

### Системная переменная

Безымянная системная переменная начинается с `$.` и предоставляет доступ к глобальным системным переменным и системной информации:

* `$.env` — массив `$_ENV`.
* `$.get` — массив `$_GET`.
* `$.post` — массив `$_POST`.
* `$.files` — массив `$_FILES`.
* `$.cookie` — массив `$_COOKIE`.
* `$.server` — массив `$_SERVER`.
* `$.session` — массив `$_SESSION`.
* `$.globals` — массив `$GLOBALS`.
* `$.request` — массив `$_REQUEST`.
* `$.tpl.name` возвращает текущее название шаблона.
* `$.tpl.basename` возвращает текущее название шаблона без схемы.
* `$.tpl.scm` возвращает схему шаблона.
* `$.tpl.options` возвращает параметры шбалона в виде целого числа.
* `$.tpl.depends` возвращает массив шаблонов, на которые ссылается текущий шаблон.
* `$.tpl.time` возвращает штамп времени, когда шаблон последний раз менялся
* `$.version` возвращает версию Fenom.
* `$.const` обращение к PHP константе: `$.const.PHP_EOL` обращение к константе `PHP_EOL`. Поддерживается пространство имен
  которое разделяется через точку: `$.const.Storage.FS::DIR_SEPARATOR` обращение к PHP константе `Storage\FS::DIR_SEPARATOR`
  если такой констатнты нет будет взята константа `Storage\FS\DIR_SEPARATOR`.
* `$.call` обращение к статическомому методу. `$.call.Storage.FS::put($filename, $data)` обращение к методу `Storage\FS::put($filename, $data)`.
  Настройка `disable_call` отключает возможность обращения к `$.call`. Так же можно ограничить и указать список доступных к вызову классов и функций.
* `$.block` проверка на сущестование блоков которые были определены до момента обращения к акцессору. Например, `{$.blocks.BLOCK_NAME}`.
* так же вы можете [добавить](./ext/extend.md#Расширение-глобальной-переменной) свои или [удалить](./ext/extend.md#Расширение-глобальной-переменной) существующие системные переменные и функции
 

## Скалярные значения

### Строки

Строка может быть определена двумя различными способами: двойные кавычки (`"string"`) и одинарные кавычки (`'string'`).

#### Двойные кавычки

Если строка заключена в двойные кавычки `"`, Fenom распознает большее количество управляющих последовательностей для специальных символов:

| Последовательность  | Значение |
|---------------------|----------|
| `\n`                | новая строка (LF или 0x0A (10) в ASCII)
| `\r`                | возврат каретки (CR или 0x0D (13) в ASCII)
| `\t`                | горизонтальная табуляция (HT или 0x09 (9) в ASCII)
| `\v`                | вертикальная табуляция (VT или 0x0B (11) в ASCII)
| `\f`                | подача страницы (FF или 0x0C (12) в ASCII)
| `\\`                | обратная косая черта
| `\$`                | знак доллара
| `\"`                | двойная кавычка
| `\[0-7]{1,3}`       | последовательность символов, соответствующая регулярному выражению символа в восьмеричной системе счисления
| `\x[0-9A-Fa-f]{1,2}`| последовательность символов, соответствующая регулярному выражению символа в шестнадцатеричной системе счисления

Но самым важным свойством строк в двойных кавычках является обработка переменных.
Существует два типа синтаксиса: простой и сложный. Простой синтаксис более легок и удобен.
Он дает возможность обработки переменной, значения массива или свойства объекта с минимумом усилий.
Сложный синтаксис может быть определен по фигурным скобкам, окружающим выражение.

##### Простой синтаксис

Если Fenom встречает знак доллара ($), он захватывает так много символов, сколько возможно, чтобы сформировать правильное имя переменной.
Если вы хотите точно определить конец имени, заключайте имя переменной в фигурные скобки.

```smarty
{"Hi, $username!"}   выведет "Hi, Username!"
```

Для чего-либо более сложного, используйте сложный синтаксис.

##### Сложный синтаксис

Он называется сложным не потому, что труден в понимании, а потому что позволяет использовать сложные выражения.
Любая скалярная переменная, элемент массива или свойство объекта, отображаемое в строку, может быть представлена в строке этим синтаксисом.
Просто запишите выражение так же, как и вне строки, а затем заключите его в `{` и `}`.
Поскольку `{` не может быть экранирован, этот синтаксис будет распознаваться только когда `$` следует непосредственно за `{`.
Используйте `{\$`, чтобы напечатать `{$`. Несколько поясняющих примеров:

```smarty
{"Hi, {$user.name}!"}        выводит: Hi, Username!
{"Hi, {$user->name}!"}       выводит: Hi, Username!
{"Hi, {$user->getName()}!"}  выводит: Hi, Username!
{"Hi, {\$user->name}!"}      выводит: Hi, {$user->name}!
```

Допускаются также различные операции и модификаторы:

```smarty
{"Hi, {$user.name|up}!"}                  выводит: Hi, USERNAME!
{"Hi, {$user.name|up ~ " (admin)"}!"}     выводит: Hi, USERNAME (admin)!
```

#### Одинарные кавычки

Простейший способ определить строку - это заключить ее в одинарные кавычки (символ `'`).

Чтобы использовать одинарную кавычку внутри строки, проэкранируйте ее обратной косой чертой `\`.
Если необходимо написать саму обратную косую черту, продублируйте ее `\\`.
Все остальные случаи применения обратной косой черты будут интерпретированы как обычные символы:
это означает, что если вы попытаетесь использовать другие управляющие последовательности, такие как `\r` или `\n`, они будут выведены как есть вместо какого-либо особого поведения.

```smarty
{'Hi, $foo'}            выводит 'Hi, $foo'
{'Hi, {$foo}'}          выводит 'Hi, {$foo}'
{'Hi, {$user.name}'}    выводит 'Hi, {$user.name}'
{'Hi, {$user.name|up}'} выводит "Hi, {$user.name|up}"
```

### Целые числа

Целые числа могут быть указаны в десятичной (основание 10), шестнадцатеричной (основание 16),
восьмеричной (основание 8) или двоичной (основание 2) системе счисления, с необязательным предшествующим знаком (`-` или `+`).

Для записи в восьмеричной системе счисления, необходимо поставить пред числом 0 (ноль). 
Для записи в шестнадцатеричной системе счисления, необходимо поставить перед числом 0x.
Для записи в двоичной системе счисления, необходимо поставить перед числом 0b

```smarty
{var $a = 1234}  десятичное число
{var $a = -123}  отрицательное число
{var $a = 0123}  восьмеричное число (эквивалентно 83 в десятичной системе)
{var $a = 0x1A}  шестнадцатеричное число (эквивалентно 26 в десятичной системе)
{var $a = 0b11111111}  двоичное число (эквивалентно 255 в десятичной системе)
```

**Замечение**
Двоичная запись числа (`0b1011011`) не доступна на старых версиях PHP — 5.3 или ниже.
Попытка исользовать на старых версия PHP приведет к исключению при компиляциях.

**Замечение**
Размер целого числа зависит от платформы, хотя, как правило, максимальное значение примерно равно 2 миллиардам (это 32-битное знаковое).
64-битные платформы обычно имеют максимальное значение около 9223372036854775807.

**Предупреждение**
Если в восьмеричном целом числе будет обнаружена неверная цифра (например, 8 или 9), оставшаяся часть числа будет проигнорирована.

### Числа с плавающей точкой

Числа с плавающей точкой (также известные как "float", "double", или "real") могут быть определены следующими синтаксисами:

```smarty
{var $a = 1.234}
{var $b = 1.2e3}
{var $c = 7E-10}
```

### Булев тип

Это простейший тип. Булевое выражает истинность значения. Он может быть либо TRUE либо FALSE.
Для указания булевого значения, используйте ключевое слово TRUE или FALSE. Оба регистро-независимы.

```smarty
{set $a = true}
```

### NULL

Специальное значение NULL представляет собой переменную без значения. NULL - это единственно возможное значение типа null.

Обычно возникают путаницы между NULL и FALSE, так как по роли они похожи, но разлицаются по принципу:
NULL - это отсутствие присутствия, а FALSE - присутствие отсутствия.

### Операции

Как и любой другой язык программирования/шаблонизации, Fenom поддерживает множество различных операторов:

* Арифметические операторы — `+`, `-`, `*`, `/`, `%`
* Логические операторы — `||`, `&&`, `!$var`, `and`, `or`, `xor`
* Операторы сравнения — `>`, `>=`, `<`, `<=`, `==`, `!=`, `!==`, `<>`
* Битовые операторы — `|`, `&`, `^`, `~$var`, `>>`, `<<`
* Операторы присвоения — `=`, `+=`, `-=`, `*=`, `/=`, `%=`, `&=`, `|=`, `^=`, `>>=`, `<<=`
* Строковый оператор — `$str1 ~ $str2`
* Тернарные операторы — `$a ? $b : $c`, `$a ! $b : $c`, `$a ?: $c`, `$a !: $c`
* Проверяющие операторы — `$var?`, `$var!`
* Оператор тестирование — `is`, `is not`
* Оператор содержания — `in`, `not in`

Подробнее об [операторах](./operators.md).

## Массивы

Массив (тип array) может быть создан конструкцией `[]`. В качестве параметров она принимает любое количество разделенных запятыми пар `key => value` (`ключ => значение`).
```
[
    key  => value,
    key2 => value2,
    key3 => value3,
    ...
]
```
Запятая после последнего элемента массива необязательна и может быть опущена.
Обычно это делается для однострочных массивов, т.е. `[1, 2]` предпочтительней `[1, 2, ]`.
Для многострочных массивов с другой стороны обычно используется завершающая запятая, так как позволяет легче добавлять новые элементы в конец массива.

```smarty
{set $array = [
    "foo" => "bar",
    "bar" => "foo",
]}
```

`key` может быть либо целым числом, либо строкой. `value` может быть любого типа.

Дополнительно с ключом key будут сделаны следующие преобразования:

* Строки, содержащие целое число будут преобразованы к числу. Например, ключ со значением `"8"` будет в действительности сохранен со значением `8`. С другой стороны, значение `"08"` не будет преобразовано, так как оно не является корректным десятичным целым.
* Числа с плавающей точкой также будут преобразованы к числу, т.е. дробная часть будет отброшена. Например, ключ со значением `8.7` будет в действительности сохранен со значением `8`.
* Булев также преобразовываются к целому числу. Например, ключ со значением `true` будет сохранен со значением `1` и ключ со значением `false` будет сохранен со значением `0`.
* NULL будет преобразован к пустой строке. Например, ключ со значением `null` будет в действительности сохранен со значением `""`.
* Массивы (тип array) и объекты (тип object) не могут использоваться в качестве ключей. При подобном использовании будет генерироваться предупреждение: Недопустимый тип смещения (Illegal offset type).

Если несколько элементов в объявлении массива используют одинаковый ключ, то только последний будет использоваться, а все другие будут перезаписаны.

Параметр `key` является необязательным. Если он не указан, Fenom будет использовать предыдущее наибольшее значение целочисленного ключа, увеличенное на 1.

Существующий массив может быть изменен явной установкой значений в нем.
Это выполняется присвоением значений массиву с указанием в скобках ключа или после точки.
Кроме того, используя скобки, вы можете опустить ключ.

```smarty
{set $arr.key = value}
{set $arr[] = value} {* будет взят максимальный целочисленый ключ, увеличенный на 1 *}
```

Если массив `$arr` еще не существует, он будет создан. Таким образом, это еще один способ определить массив.
Однако такой способ применять не рекомендуется, так как если переменная `$arr` уже содержит некоторое значение (например, строку),
то это значение останется на месте и `[]` может на самом деле означать доступ к символу в строке. Лучше инициализировать переменную путем явного присваивания значения.

## Константы

Константы - это идентификаторы (имена) простых значений, определенные в PHP. 
Исходя из их названия, нетрудно понять, что их значение не может изменяться в ходе выполнения шаблона.
Имена констант чувствительны к регистру. По принятому соглашению, имена констант всегда пишутся в верхнем регистре.
Константы доступны из любого шаблона через глобальную переменную {$.const.*}: `{$.const.PHP_EOL}`.
В шаблоне определить константу нельзя.

## PHP функции и методы

Fenom предоставляет возможноть обращаться к функиям и методам самого PHP. Использование их в шаблонах не рекомендуется.
Используя системную переменную `$.php` можно вызвать любую функцию или метод в шаблоне:

```smarty
{$.php.some_function($a, $b, $c)}
```
Метод вызывается иначе

```smarty
{$.php.MyClass::method($a, $b, $c)}
```

пространство имен указывается перед функций или классом, разделяя точкой вместо обратного слеша:

```smarty
{$.php.My.NS.some_function($a, $b, $c)}
{$.php.My.NS.MyClass::method($a, $b, $c)}
```

Вызов функции и методов можно выключить настройкой `???` или ограничить.

## Модификаторы

Модификаторы переменных могут быть применены к переменным, пользовательским функциям или строкам.
Для их применения надо после модифицируемого значения указать символ `|` (вертикальная черта) и название модификатора.
Так же модификаторы могут принимать параметры, которые влияют на их поведение.
Эти параметры следуют за названием модификатора и разделяются `:` (двоеточием).
Кроме того, по умолчанию все функции PHP могут быть использованы в качестве модификаторов (что можно отключить в настройках) и модификаторы можно комбинировать.

```smarty
{var $foo="User"}
{$foo|upper}            выведет "USER"
{$foo|lower}            выведет "user"
{"{$foo|lower}"}        выведет "user"
{"User"|lower}}         выведет "user"
{$looong_text|truncate:80:"..."}  обрежет текст до 80 символов и добавит символы "..."
{$looong_text|lower|truncate:$settings.count:$settings.etc}
{set $foo="User"|upper}    значение переменной $foo будет "USER"
```

## Теги

Все сущности шаблона можно разжелить на две группы:

* заполнитель (placeholder) — вывод переменной в шаблоне, например `{$name}`
* тег — конструкция, выполняющаяя некоторые действия, которая выглядит как именованный заполнитель (placeholder), например `{include $name}`

Теги также можно разделить на две группы:

* Функии. Тег функции вызывает пользовательскую во время выполнения шаблона, результат функции будет выведен вместо тега.
Пользовательские функции являются дополнительными и могут быть индивидуальными. Они могут быть изменены по вашему желанию, также вы можете создать новые.
* Компиляторы. В отличии от функций компиляторы вызываются во время компиляции шаблона и возвращают PHP код, который описывает некоторое действие.
Компиляторы и формируют основные конструкции типа `if`, `foreach` и т.д.

### Игнорирование кода

В шаблонизаторе Fenom используются фигурные скобки для отделения HTML от кода Fenom.
Если требуется вывести текст, содержащий фигурные скобки, то есть следующие варианты это сделать:

1. Использование блочного тега `{ignore}{/ignore}`. Текст внутри этого тега текст не компилируется шаблонизатором и выводится как есть.
2. Если после открывающей фигурной скобки есть пробельный символ (пробел или `\t`) или перенос строки (`\r` или `\n`), то она не воспринимается как разделитель кода Fenom и код после неё выводится как есть.
3. Установить опцию `:ignore` у блочного тега. Все Fenom теги внутри блока будут проигнорированны

Example:

```smarty
{ignore}
<style>
	h1 {font-size: 24px; color: #F00;}
</style>
{/ignore}
<script>
	(function (text) {
		var e = document.createElement('P');
		e.innerHTML = text;
		document.body.appendChild(e);
	})('test');
{if:ignore $cdn.yandex}
    var item = {cdn: "//yandex.st/"};
{/if}
</script>
```

Outputs

```html
<style>
	h1 {font-size: 24px; color: #F00;}
</style>
<script>
	(function (text) {
		var e = document.createElement('P');
		e.innerHTML = text;
		document.body.appendChild(e);
	})('test');
	var item = {cdn: "//yandex.st/"};
</script>
```

### Пробелы

Шаблонизатор допускает любое количество пробелов или переносов строк в своём коде

```smarty
{include 'control.tpl'
    $options = $list
    $name    = $cp.name
    $type    = 'select'
    isolate  = true
    disable_static = true
}

{foreach [
    "one"   => 1,
    "two"   => 2,
    "three" => 3
] as $key   => $val}

    {$key}: {$val}

{/foreach}
```

### Параметры тегов

|    имя  | код  | тип тега  | описание |
| ------- | ---- | --------- | ------------ |
|   strip |    s | блоковый   | активирует удаление лишних пробелов на подобии модфикатора `strip` |
|  ignore |    i | блоковый   | парсер будет игнорировать любой Fenom синтаксис на контент блокового тега  |
|     raw |    a | любой     | отключает экранирование |
|  escape |    e | любой     | принудительно активирует экранирование |

```smarty
{script:ignore} ... {/script}
{foreach:ignore:strip ...} ... {/foreach}
```