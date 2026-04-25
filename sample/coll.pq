trace.on()

@users = [
  {name: "홍길동", age: 25},
  {name: "김철수", age: 18},
  {name: "이영희", age: 32}
]

@names = (@users)
  .where(age > 20)
  .map(name)
  .get()

for $n in @names
  msg.print($n)
end