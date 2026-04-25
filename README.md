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

@name = "pq"

msg.print("hello " + @name)


```md
## More Example

trace.on()

@data = http.get("https://api.coinbase.com/v2/prices/spot?currency=USD").json()

msg.print("BTC: " + @data["data"]["amount"])
