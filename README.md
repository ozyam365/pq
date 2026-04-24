# pq

Make PHP shorter and easier.
---

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
