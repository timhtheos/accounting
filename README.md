Accounting
==========

A Symfony project created on July 26, 2017, 2:31 AM.

I just wanna spend 1 hour a day learning Symfony 3, from scratch.

## Starting the app

To just start it:

```
php bib/console server:start
```

To stop:

```
php bin/console server:stop
```

To start while watching:

```
php bin/console server:run
```

To stop watching, just press `CTRL+c`.

## Generate Doctrine2 entities

```
php bin/console doctrine:generate:entity
```

You will be asked the following:

1.  Entity shortcut name.

    In this app, I entered `AppBundle:Accounts`.

    Possible error 01:
    ```
    The entity name isn't valid ("accounts" given, expecting something like
    AcmeBlogBundle:Blog/Post)
    ```

    Solution: Include the bundle name, in this case, `AppBundle`.

    Possible error 02:
    ```
    [Doctrine\DBAL\Exception\ConnectionException]
    An exception occured in driver: SQLSTATE[HY000] [1049] Unknown database 'symfony'
    ```

    ```
    [Doctrine\DBAL\Driver\PDOException]
    SQLSTATE[HY000] [1049] Unknown database 'symfony'
    ```

    ```
    [PDOException]
    SQLSTATE[HY000] [1049] Unknown database 'symfony'
    ```

    Solution: Database is not created and/or `app/config/parameters.yml` file is
    not configured.

2.  Configuration format (yml, xml, php, or annotation).

    In this app, I just leave it as-is to `annotation`.

3.  New field name (press <return> to stop adding fields).

    In this app, I need the following fields:

    | field name | type     | length | null     | unique     |
    | ---------- | -------- | ------ | -------- | ---------- |
    | name       | string   | 30     | not null | not unique |
    | type       | string   | 30     | not null | not unique |
    | alias      | string   | 30     | not null | not unique |
    | currency   | string   | 3      | not null | not unique | 
    | date_added | datetime |        | not null | not unique |
