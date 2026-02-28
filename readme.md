# Lazarusphp Database Class

## instantiation

```php
use LazarusPhp\Database;
Connection::make($type,$hostname,$username,$password,$dbname);
```
if a .env file is loaded it is possible to pass them to the database class allowing parameters to be left empty.

## Lazarus Database class is not designed to be called as a standalone but extended from other classes such as 

(QueryBuilder)[https://github.com/lazarusphp/queryBuilder]

