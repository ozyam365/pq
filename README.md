# pq

Write less PHP. Do more.

A tiny DSL that turns simple scripts into PHP.

---

## Example

```pq
@name = "pq"
msg.print("hello " + @name)


```md
## More Example

```pq
@r["subject"] = @subject
@r["note"] = @note
@r["author"] = @author
@r["reg_date"] = now()

db.bbs.insert(@r)