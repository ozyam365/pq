# pq

Making PHP code short and easy to develop
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
