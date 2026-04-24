## pq

Make PHP shorter and easier.

pq (phpquick) is a tiny DSL that converts simple scripts into PHP.

Version 0.01  
Created together with ChatGPT.

---

## Concept
Chain-based syntax (db.users.where(...))
Simple variable access (@item.name)

@items = db.users.where("age > 20")

## Syntax
@ → variable

[] → array

. → chain


## Run
php run.php

## Output
hello pq


## More Example

```pq
@r["subject"] = @subject
@r["note"] = @note
@r["author"] = @author
@r["reg_date"] = now()

db.bbs.insert(@r)
