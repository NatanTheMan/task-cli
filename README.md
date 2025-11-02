# Task Tracker Cli
- [Installation](#Installation)
- [How to use](#How-to-use)
- [Examples](#Examples)
- [Types](#Types)

## Installation

```
git clone https://github.com/NatanTheMan/task-cli
cd task-cli
```

## How to use

run it
```
./index.php
```

Possible actions:
```
add <description (string)>
```
To add a task with description "foo".
```
delete <id>
```
Delete by id.
```
update <id> <new description>
```
Update task description by id.
```
list
```
Print all tasks.
```
list <status>
```
Filter tasks by status proved.
```
mark-done <id>
```
Set task status to `done` by id
```
mark-in-progress <id>
```
Set task status to `in-progress` by id

## Examples

```
./index.php add "foo"

./index.php list
// 1 - "foo" - todo

./index.php update 1 "bar"

./index.php list
// 1 - "bar" - todo

./index.php mark-done 1

./index.php list
// 1 - "bar" - done

./index.php delete 1
```

## Types

```
Task:
  string description
  Status status (default Todo)

enum Status:
  Done
  Todo
  InProgress
```
