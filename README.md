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

trace.on()

@users = [
  {name:"hong", age:25},
  {name:"kim", age:18},
  {name:"lee", age:32}
]
//@aaa -> variable    (@aaa) -> object
@result = (@users)
  .where(age > 20 && name != "kim")
  .map(name + " (" + age + ")")
  .get()

for $n in @result
  msg.print($n)
end