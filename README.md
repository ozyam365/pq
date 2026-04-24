# pq

Make PHP shorter and easier.
pq ver 0.01  = phpquick 
---

## Concept

- Chain-based syntax (db.users.where(...))
- Simple variable access (@item.name)

##This explains the type of incident.

@items = db.users.where("age > 20")

## Run

php run.php

## Output

hello pq

## Example

```pq
@name = "pq"
msg.print("hello " + @name)



## More Example

```pq
@r["subject"] = @subject
@r["note"] = @note
@r["author"] = @author
@r["reg_date"] = now()

db.bbs.insert(@r)
